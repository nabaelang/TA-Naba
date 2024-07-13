@extends('pembeli.layouts.app')

@section('title', 'Product Page')

@section('content')
    <section class="products">
        <div class="container p-5">
            <div class="row mb-3">
                <div class="col text-center">
                    <h3>Furniture <span>Categories</span></h3>
                </div>
            </div>
            <div class="row mb-5">
                <div class="col">
                    <nav class="nav nav-pills flex-column flex-sm-row">
                        <a class="flex-sm-fill text-sm-center nav-link {{ is_null($selectedCategory) ? 'active' : '' }}"
                            href="{{ url('/product') }}">Semua</a>
                        @foreach ($categories as $category)
                            <a class="flex-sm-fill text-sm-center nav-link {{ $selectedCategory == $category->id ? 'active' : '' }}"
                                href="{{ url('/product?category=' . $category->id) }}">{{ $category->name }}</a>
                        @endforeach
                    </nav>
                </div>
            </div>
            <div class="row row-cols-1 row-cols-md-3 g-4 mb-5">
                @foreach ($products as $product)
                    <div class="col">
                        <div class="card">
                            <img src="{{ Storage::url($product->image) }}" class="card-img-top w-100" alt="..." />
                            <div class="card-body">
                                <h5 class="card-title">{{ $product->name }}</h5>
                                <div class="d-flex justify-content-between align-items-center">
                                    <p class="card-text">Rp {{ $product->price }}</p>
                                    <a class="btn button-primary btn-md" href="product/{{ $product->id }}"
                                        role="button">Beli</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
