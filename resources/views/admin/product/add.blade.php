@extends('admin.layouts.app')

@section('title', 'Tambah Product')

@section('content')
    <div class="pagetitle">
        <h1>Tambah Product</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/admin/dashboard">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="/admin/product">Product</a></li>
                <li class="breadcrumb-item active">Tambah Product</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Tambah Product</h5>

                        <!-- General Form Elements -->
                        <form action="/admin/product" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row mb-3">
                                <label for="name" class="col-sm-2 col-form-label">Nama Product</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        name="name" value="{{ old('name') }}">
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
                                        <option selected>Pilih Kategori</option>
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
                                        name="description" id="description">{{ old('description') }}</textarea>
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
                                        name="weight" value="{{ old('weight') }}">
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
                                        name="price" value="{{ old('price') }}">
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
                                        name="stock" value="{{ old('stock') }}">
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
                                        name="image" id="image" onchange="previewImage()">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Preview Gambar</label>
                                <div class="col-sm-10">
                                    <img id="preview" src="#" alt="Preview Gambar"
                                        style="max-width: 200px; max-height: 200px;">
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
        function previewImage() {
            const preview = document.getElementById('preview');
            const file = document.getElementById('image').files[0];
            const reader = new FileReader();

            reader.onloadend = function() {
                preview.src = reader.result;
            }

            if (file) {
                reader.readAsDataURL(file);
            } else {
                preview.src = '';
            }
        }
    </script>
@endpush
