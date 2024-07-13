<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $users = User::count();
        $transactions = Transaction::count();
        $products = Product::count();
        return view("admin.dashboard", compact("users", "transactions", "products"));
    }
}
