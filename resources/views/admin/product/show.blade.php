@extends('admin.layouts.app')

@section('title', 'Detail Product')
@section('content')
    <div class="pagetitle">
        <h1>Data Produk</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/admin/dashboard">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="/admin/product">Produk</a></li>
                <li class="breadcrumb-item active">Data Produk</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Data Produk {{ $product->name }}</h5>
                        <!-- Table with stripped rows -->
                        <table class="table">
                            <tbody>
                                <tr>
                                    <th>Nama Produk</th>
                                    <td>{{ $product->name }}</td>
                                </tr>
                                <tr>
                                    <th>Kategori Produk</th>
                                    <td>{{ $product->category->name }}</td>
                                </tr>
                                <tr>
                                    <th>Gambar Produk</th>
                                    <td>
                                        <img src="{{ Storage::url($product->image) }}" alt=""
                                            style="height:400px; width:420px; object-fit: cover;">
                                    </td>
                                </tr>
                                <tr>
                                    <th>Stock</th>
                                    <td>{{ $product->stock }}</td>
                                </tr>
                                <tr>
                                    <th>Harga</th>
                                    <td>{{ $product->price }}</td>
                                </tr>
                                <tr>
                                    <th>Berat</th>
                                    <td>{{ $product->weight }}</td>
                                </tr>
                                <tr>
                                    <th>Deskripsi</th>
                                    <td>{!! $product->description !!}</td>
                                </tr>
                            </tbody>
                        </table>
                        <!-- End Table with stripped rows -->
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
