<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $carts = Cart::where('user_id', Auth::user()->id)->get();
        return view('pembeli.cart', ['carts' => $carts]);
    }

    public function addToCart(Product $product, Request $request)
    {
        $product_id = $product->id;
        $user_id = Auth::user()->id;

        $existing_cart = Cart::where('product_id', $product_id)->first();

        if ($existing_cart == null) {

            // validasi request
            $request->validate([
                'quantity' => 'required|gte:1|lte:' . $product->stock
            ]);

            // create cart
            Cart::create([
                'product_id' => $product_id,
                'user_id' => $user_id,
                'quantity' => $request->quantity,
                'price' => $product->price,
                'weight' => $product->weight,

            ]);
        } else {
            // validasi agar kuantitas pada cart tidak melebihi stock produk
            $request->validate([
                'quantity' => 'required|gte:1|lte:' . ($product->stock - $existing_cart->quantity)
            ]);

            $existing_cart->update([
                'quantity' => $existing_cart->quantity + $request->quantity
            ]);
        }

        return redirect('/cart');
    }

    public function updateCart(Cart $cart, Request $request)
    {
        // validasi request
        $request->validate([
            'quantity' => 'required|gte:1|lte:' . $cart->product->stock
        ]);

        $cart->update([
            'quantity' => $request->quantity
        ]);

        return response()->json(['success' => true]);
    }


    public function deleteCart(Cart $cart)
    {
        $cart->delete();
        return redirect('/cart')->with('success', 'Produk berhasil dihapus dari keranjang!');
    }
}
