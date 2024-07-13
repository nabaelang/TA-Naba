<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view("admin.category.index", compact("categories"));
    }

    public function create()
    {
        return view("admin.category.add");
    }

    public function store(Request $request)
    {
        // validasi form
        $validated = $request->validate([
            'name' => 'required|string',
        ]);

        // simpan ke db
        Category::create([
            'name' => $validated['name']
        ]);

        // kembali ke halaman category index
        return redirect('/admin/category');
    }

    public function edit($id)
    {
        // dapatkan category berdasarkan id
        $category = Category::findOrFail($id);
        return view('admin.category.edit', ['category' => $category]);
    }

    public function update(Request $request, $id)
    {
        // dapatkan category berdasarkan id
        $category = Category::findOrFail($id);

        // validasi form
        $validated = $request->validate([
            'name' => 'required|string',
        ]);

        // simpan ke db
        Category::where('id', $id)->update([
            'name' => $validated['name']
        ]);

        // kembali ke halaman category index
        return redirect('/admin/category');
    }

    public function destroy($id)
    {
        Category::destroy($id);

        return redirect('/admin/category');
    }
}
