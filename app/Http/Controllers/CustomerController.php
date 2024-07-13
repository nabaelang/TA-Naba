<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    public function index()
    {
        $transactions = Transaction::where('user_id', Auth::user()->id)->where('status_payment', 'success')->get();
        return view("pembeli.transaction", compact("transactions"));
    }

    public function show(Transaction $transaction)
    {
        $details = $transaction->detail_transactions()->with('product')->get();
        $transaction->load(['provinces', 'cities']); // Load province and city relations
        return view("pembeli.showtransaction", compact("transaction", "details"));
    }

    public function profile()
    {
        $user = Auth::user();
        return view('pembeli.profile', compact('user'));
    }

    public function edit()
    {
        $user = Auth::user();
        return view('pembeli.profileedit', compact('user'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . Auth::id(),
            'address' => 'required|string',
            'phone_number' => 'required|string',
        ]);

        $user = Auth::user();
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'address' => $request->address,
            'phone_number' => $request->phone_number,
        ]);

        return redirect()->route('profile.show')->with('success', 'Profile updated successfully.');
    }
}
