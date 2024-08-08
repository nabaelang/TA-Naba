<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->get();
        return view('admin.product.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.product.add', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'category_id' => 'required',
            'weight' => 'required',
            'description' => 'required|string|max:65535',
            'price' => 'required',
            'stock' => 'required',
            'image' => 'mimes:jpg, jpeg, png|max:10240',
        ]);

        // menyimpan file image ke dalam storage
        $saveImage['image'] = Storage::putFile('public/image', $request->file('image'));

        Product::create([
            'name' => $validated['name'],
            'category_id' => $validated['category_id'],
            'description' => $validated['description'],
            'weight' => $validated['weight'],
            'price' => $validated['price'],
            'stock' => $validated['stock'],
            'image' => $saveImage['image'],
        ]);

        // kembali ke product index
        return redirect('/admin/product');
    }

    public function show($id)
    {
        $product = Product::with('category')->findOrFail($id);
        return view('admin.product.show', ['product' => $product]);
    }

    public function edit($id)
    {
        $product = Product::with('category')->findOrFail($id);
        $categories = Category::all();
        return view('admin.product.edit', ['product' => $product, 'categories' => $categories]);
    }

    public function update(Request $request, $id)
    {
        $product = Product::with('category')->findOrFail($id);

        $validated = $request->validate([
            'name' => 'required',
            'category_id' => 'required',
            'weight' => 'required',
            'description' => 'required|string|max:65535',
            'price' => 'required',
            'stock' => 'required',
            'image' => 'mimes:jpg, jpeg, png|max:10240',
        ]);

        // Cek apakah ada unggahan gambar baru
        if ($request->hasFile('image')) {
            // Hapus foto yang lama
            Storage::delete($product->image);

            // Simpan foto yang baru
            $newImage = ['image' => Storage::putFile('public/image', $request->file('image'))];
        } else {
            // Jika tidak ada gambar baru, gunakan gambar yang sudah ada
            $newImage = ['image' => $product->image];
        }

        $product->update([
            "name" => $validated["name"],
            "category_id" => $validated["category_id"],
            "description" => $validated["description"],
            "price" => $validated["price"],
            "weight" => $validated["weight"],
            "stock" => $validated["stock"],
            'image' => $newImage['image']
        ]);

        // kembali ke product index
        return redirect('/admin/product');
    }

    public function destroy($id)
    {
        Product::destroy($id);
        return redirect('/admin/product');
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $products = Product::where('name', 'LIKE', "%{$query}%")
            ->orWhere('description', 'LIKE', "%{$query}%")
            ->get();

        return view('pembeli.search-results', compact('products'));
    }
}
