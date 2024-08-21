<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request, Product $product)
    {
        $request->validate([
            'review' => 'required|string|max:500',
        ]);

        Review::create([
            'user_id' => Auth::id(),
            'product_id' => $product->id,
            'review' => $request->review,
        ]);

        return redirect()->back()->with('success', 'Ulasan Anda berhasil disimpan.');
    }
}
