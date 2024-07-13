<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function landingPage()
    {
        $products = Product::with('category')->get();

        return view('pembeli.landingpage', ['products' => $products]);
    }

    public function productPage(Request $request)
    {
        $categories = Category::all();
        $selectedCategory = $request->input('category');

        if ($selectedCategory) {
            // Filter products based on selected category
            $products = Product::whereHas('category', function ($query) use ($selectedCategory) {
                $query->where('id', $selectedCategory);
            })->get();
        } else {
            // Show all products if no category is selected
            $products = Product::with('category')->get();
        }

        return view('pembeli.productpage', [
            'products' => $products,
            'categories' => $categories,
            'selectedCategory' => $selectedCategory,
        ]);
    }

    public function productDetailPage($id)
    {
        $product = Product::findOrFail($id);

        return view('pembeli.detailproductpage', ['product' => $product]);
    }
}
