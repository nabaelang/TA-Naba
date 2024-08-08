@extends('pembeli.layouts.app')

@section('title', 'Search Result')

@section('content')
    <section class="product">
        <div class="container p-5">
            <div class="row mb-3">
                <div class="col text-center">
                    <h2 class="text-center">Search Results</h2>
                    @if ($products->isEmpty())
                        <p>No products found.</p>
                    @else
                </div>
                <div class="row row-cols-1 row-cols-md-3 g-4 mb-5">
                    @foreach ($products as $product)
                        <div class="col">
                            <div class="card">
                                <img src="{{ Storage::url($product->image) }}" class="card-img-top w-100"
                                    alt="{{ $product->name }}">
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
                @endif
            </div>
        </div>
        </div>
    </section>
@endsection
