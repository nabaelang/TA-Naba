<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::orderBy('created_at', 'desc')->get();
        return view("admin.transaction.index", compact("transactions"));
    }

    public function show(Transaction $transaction)
    {
        $details = $transaction->detail_transactions()->with('product')->get();
        $transaction->load(['provinces', 'cities']); // Load province and city relations
        return view("admin.transaction.show", compact("transaction", "details"));
    }


    public function edit($id)
    {
        $transaction = Transaction::findOrfail($id);
        return view("admin.transaction.edit", compact("transaction"));
    }

    public function update(Request $request, $id)
    {
        $transaction = Transaction::findOrfail($id);
        $validated = $request->validate([
            "status_shipping" => "required",
        ]);

        Transaction::where("id", $id)->update([
            "status_shipping" => $validated["status_shipping"],
        ]);

        return redirect("/admin/transaction")->with('success', 'Transaksi berhasil diperbarui!');
    }
}
