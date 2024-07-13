@extends('admin.layouts.app')

@section('title', 'Edit Product')

@section('content')
    <div class="pagetitle">
        <h1>Edit Product</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/admin/dashboard">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="/admin/product">Product</a></li>
                <li class="breadcrumb-item active">Edit Product</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Edit Product</h5>

                        <!-- General Form Elements -->
                        <form action="/admin/product/{{ $product->id }}" method="POST" enctype="multipart/form-data">
                            @method('put')
                            @csrf
                            <div class="row mb-3">
                                <label for="name" class="col-sm-2 col-form-label">Nama Product</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        name="name" value="{{ old('name', $product->name) }}">
                                </div>
                                @error('name')
                                    <div class="invalid-feedback">
                                        Nama tidak boleh kosong
                                    </div>
                                @enderror
                            </div>
                            <div class="row mb-3">
                                <label for="category_id" class="col-sm-2 col-form-label">Kategori Product</label>
                                <div class="col-sm-10">
                                    <select class="form-select" aria-label="Default select example" name="category_id">
                                        <option selected value="{{ $product->category_id }}">
                                            {{ old('category_id', $product->category->name) }}</option>
                                        <option>--- Pilih Kategori ---</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="description" class="col-sm-2 col-form-label">Deskripsi Product</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control description @error('description') is-invalid @enderror" style="height: 100px"
                                        name="description" id="description">{{ old('description', $product->description) }}</textarea>
                                </div>
                                @error('description')
                                    <div class="invalid-feedback">
                                        Deskripsi tidak boleh kosong
                                    </div>
                                @enderror
                            </div>
                            <div class="row mb-3">
                                <label for="weight" class="col-sm-2 col-form-label">Berat Product (gram)</label>
                                <div class="col-sm-10">
                                    <input type="number" class="form-control @error('weight') is-invalid @enderror"
                                        name="weight" value="{{ old('weight', $product->weight) }}">
                                </div>
                                @error('weight')
                                    <div class="invalid-feedback">
                                        Berat tidak boleh kosong
                                    </div>
                                @enderror
                            </div>
                            <div class="row mb-3">
                                <label for="price" class="col-sm-2 col-form-label">Harga Product</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control @error('price') is-invalid @enderror"
                                        name="price" value="{{ old('price', $product->price) }}">
                                </div>
                                @error('price')
                                    <div class="invalid-feedback">
                                        Harga tidak boleh kosong
                                    </div>
                                @enderror
                            </div>
                            <div class="row mb-3">
                                <label for="stock" class="col-sm-2 col-form-label">Stock Product</label>
                                <div class="col-sm-10">
                                    <input type="number" class="form-control @error('stock') is-invalid @enderror"
                                        name="stock" value="{{ old('stock', $product->stock) }}">
                                </div>
                                @error('stock')
                                    <div class="invalid-feedback">
                                        Stock tidak boleh kosong
                                    </div>
                                @enderror
                            </div>
                            <div class="row mb-3">
                                <label for="image" class="col-sm-2 col-form-label">Gambar Product</label>
                                <div class="col-sm-10">
                                    <input class="form-control @error('image') is-invalid @enderror" type="file"
                                        name="image" id="image" onchange="previewImage()"
                                        data-old-image="{{ $product->image ? Storage::url($product->image) : '' }}">

                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Preview Gambar</label>
                                <div class="col-sm-10">
                                    @if ($product->image)
                                        <img id="preview" src="{{ Storage::url($product->image) }}" alt="Preview Gambar"
                                            style="max-width: 400px; max-height: 400px;">
                                    @else
                                        <img id="preview" src="#" alt="Preview Gambar"
                                            style="max-width: 400px; max-height: 400px;">
                                    @endif
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Submit Button</label>
                                <div class="col-sm-10">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </div>
                        </form><!-- End General Form Elements -->
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('javascript')
    <script src="https://cdn.ckeditor.com/ckeditor5/41.3.1/classic/ckeditor.js"></script>
    <script>
        ClassicEditor
            .create(document.querySelector('#description'))
            .catch(error => {
                console.error(error);
            });
    </script>
    <script>
        window.addEventListener('DOMContentLoaded', (event) => {
            // Panggil fungsi previewImage saat halaman dimuat
            previewImage();
        });

        function previewImage() {
            const preview = document.getElementById('preview');
            const fileInput = document.getElementById('image');
            const file = fileInput.files[0];
            const reader = new FileReader();

            reader.onloadend = function() {
                preview.src = reader.result;
            }

            if (file) {
                reader.readAsDataURL(file);
            } else if (fileInput.getAttribute('data-old-image')) {
                // Jika tidak ada gambar yang dipilih, namun ada gambar sebelumnya
                preview.src = fileInput.getAttribute('data-old-image');
            } else {
                preview.src = '';
            }
        }
    </script>
@endpush
