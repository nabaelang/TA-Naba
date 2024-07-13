<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Models\DetailTransaction;
use App\Models\Province;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

// Midtrans
use Midtrans\Snap;
use Midtrans\Config;
use Midtrans\Notification;

class CheckoutController extends Controller
{
    public function checkoutPage(Request $request)
    {
        $carts = Cart::where('user_id', Auth::user()->id)->get();
        $provinces = Province::all();

        return view('pembeli.checkoutpage', ['carts' => $carts, 'provinces' => $provinces, 'ongkir' => '']);
    }

    public function checkOngkir(Request $request)
    {
        $response = Http::withHeaders([
            'key' => config('services.rajaongkir.key')
        ])->post('https://api.rajaongkir.com/starter/cost', [
            'origin' => 455, // ID Kabupaten Tangerang
            'destination' => $request->destination,
            'weight' => $request->weight,
            'courier' => $request->courier
        ]);

        if ($response->successful() && isset($response['rajaongkir']['results'])) {
            $ongkir = $response['rajaongkir']['results'];
            // Save necessary data to session
            session([
                'courier' => $request->courier,
                'province' => $request->province,
                'city' => $request->destination,
                'weight' => $request->weight,
            ]);
        } else {
            $ongkir = [];
        }

        return response()->json([
            'success' => true,
            'ongkir' => $ongkir,
        ]);
    }

    public function checkoutProcess(Request $request)
    {
        $user = Auth::user();

        // Checkout Process
        $transaction_code = 'TRANS-' . mt_rand(000, 999);

        $carts = Cart::with(['product', 'user'])
            ->where('user_id', Auth::user()->id)
            ->get();

        // Create Transaction
        $transaction = Transaction::create([
            'transaction_code' => $transaction_code,
            'user_id' => $user->id,
            'courier' => $request->courier,
            'service' => $request->service,
            'cost_courier' => $request->cost_courier,
            'weight' => $request->weight,
            'name' => Auth::user()->name,
            'phone' => Auth::user()->phone_number,
            'province' => $request->province,
            'city' => $request->city,
            'address' => Auth::user()->address,
            'status_payment' => 'Pending',
            'status_shipping' => 'Pending',
            'grand_total' => $request->grand_total
        ]);

        // Get the newly created transaction ID
        $order_id = $transaction->id;

        // Create Detail Transaction
        foreach ($carts as $cart) {
            DetailTransaction::create([
                'transaction_id' => $transaction->id,
                'product_id' => $cart->product->id,
                'qty' => $cart->quantity,
                'price' => $cart->product->price,
            ]);

            // Reduce product stock if transaction successful
            $product = Product::find($cart->product_id);

            $product->update([
                'stock' => $product->stock - $cart->quantity
            ]);

            // Add item details to the array
            $itemDetails[] = [
                'id' => $cart->product->id,
                'price' => $cart->product->price,
                'quantity' => $cart->qty,
                'name' => $cart->product->name,
            ];
        }

        // Delete Cart Data
        Cart::with(['product', 'user', 'warung'])
            ->where('user_id', Auth::user()->id)
            ->delete();

        // Midtrans Configuration
        Config::$serverKey = config('services.midtrans.serverKey');
        Config::$isProduction = config('services.midtrans.isProduction');
        Config::$isSanitized = config('services.midtrans.isSanitized');
        Config::$is3ds = config('services.midtrans.is3ds');

        // Create array for Midtrans
        $midtrans = [
            'transaction_details' => [
                'order_id' => $order_id, // Use unique order_id
                'gross_amount' => $transaction->grand_total,
            ],
            'customer_details' => [
                'first_name' => Auth::user()->name,
                'phone' => Auth::user()->phone_number,
                'email' => Auth::user()->email,
                'address' => Auth::user()->address,
            ],
            'enabled_payments' => [
                'gopay', 'permata_va', 'bank_transfer'
            ],
            'vtweb' => []
        ];

        // Get Snap Payment Page URL
        $paymentUrl = Snap::createTransaction($midtrans)->redirect_url;

        // Redirect to Snap Payment Page
        return redirect($paymentUrl);
    }

    public function callback(Request $request)
    {
        // Set konfigurasi Midtrans
        Config::$serverKey = config('services.midtrans.serverKey');
        Config::$isProduction = config('services.midtrans.isProduction');
        Config::$isSanitized = config('services.midtrans.isSanitized');
        Config::$is3ds = config('services.midtrans.is3ds');

        // Instance notifikasi Midtrans
        $notification = new Notification();

        // Assign ke variabel untuk memudahkan penulisan kode
        $status = $notification->transaction_status;
        $type = $notification->payment_type;
        $fraud = $notification->fraud_status;
        $order_id = $notification->order_id;

        // Cari transaksi berdasarkan ID
        $transaction = Transaction::findOrFail($order_id);

        // Handle status notifikasi
        if ($status == 'capture') {
            if ($type == 'credit_cart') {
                if ($fraud == 'challenge') {
                    $transaction->status_payment = 'PENDING';
                    $transaction->update(['status_payment' => 'Pending']);
                } else {
                    $transaction->status_payment = 'SUCCESS';
                    $transaction->update(['status_payment' => 'Success']);
                }
            }
        } else if ($status == 'settlement') {
            $transaction->status_payment = 'SUCCESS';
            $transaction->update(['status_payment' => 'Success']);
        } else if ($status == 'pending') {
            $transaction->status_payment = 'PENDING';
            $transaction->update(['status_payment' => 'Pending']);
        } else if ($status == 'deny') {
            $transaction->status_payment = 'CANCELLED';
            $transaction->update(['status_payment' => 'Cancelled']);
        } else if ($status == 'expire') {
            $transaction->status_payment = 'CANCELLED';
            $transaction->update(['status_payment' => 'Cancelled']);
        } else if ($status == 'cancel') {
            $transaction->status_payment = 'CANCELLED';
            $transaction->update(['status_payment' => 'Cancelled']);
        }

        // Simpan transaksi
        $transaction->save();
    }
}
