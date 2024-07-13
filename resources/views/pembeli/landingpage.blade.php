@extends('pembeli.layouts.app')

@section('title', 'Landing Page')

@section('content')
    <!-- Hero -->
    <section class="hero align-items-center">
        <div class="container">
            <div class="row flex-lg-row-reverse align-items-center col-xxl-12 mx-auto py-4">
                <div class="col-lg-4 ms-lg-4">
                    <div class="lc-block mb-4">
                        <img class="img-fluid" src="{{ asset('custom/image/kursi.png') }}" alt="foto kursi" />
                    </div>
                    <!-- /lc-block -->
                </div>
                <div class="col-lg-7 ps-lg-4">
                    <div class="lc-block mb-4">
                        <div editable="rich">
                            <h1 class="rfs-30 fw-bold">
                                Cari Produk Furniture Terbaik Pilihan!
                            </h1>
                        </div>
                    </div>
                    <div class="lc-block mb-4">
                        <div editable="rich">
                            <p class="lead">Tempatnya Harga murah-murah dan Terbaik</p>
                        </div>
                    </div>
                    <div class="lc-block">
                        <a class="btn button-primary btn-md" href="#" role="button">Jelajahi</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Hero -->

    <!-- About -->
    <section class="about">
        <div class="container-fluid text-center p-5">
            <div class="row mb-3">
                <div class="col">
                    <h3>About <span>Us</span></h3>
                </div>
            </div>
            <div class="row mx-auto">
                <div class="col-lg-9 mx-auto">
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                        Doloribus ratione asperiores et deleniti magnam facilis, eveniet
                        corrupti nemo. Repudiandae cum ullam vero aut corporis fugit alias
                        accusantium, doloremque corrupti? Assumenda similique deleniti
                        voluptates impedit. Ipsam laudantium suscipit atque, illo, minus
                        dignissimos libero tenetur consequatur quo fugit perspiciatis
                        natus praesentium saepe eius adipisci reiciendis voluptate. Dolor
                        dolorem soluta illum incidunt perferendis voluptatibus aliquam!
                        Aut vitae sit ducimus itaque eius, hic aliquid quo praesentium,
                        ipsum, facilis quas deserunt tenetur cumque similique iure nulla
                        iusto possimus tempore minima vero! Velit amet maxime animi
                        provident, suscipit veniam quaerat perspiciatis, nam, at neque
                        laudantium assumenda!
                    </p>
                </div>
            </div>
        </div>
    </section>
    <!-- End About -->

    <!-- Product -->
    <section class="product">
        <div class="container p-5">
            <div class="row mb-3">
                <div class="col text-center">
                    <h3>Our <span>Products</span></h3>
                </div>
            </div>
            <div class="row row-cols-1 row-cols-md-3 g-4 mb-5">
                @foreach ($products as $product)
                    <div class="col">
                        <div class="card">
                            <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}"
                                class="card-img-top w-100" style="object-fit: cover;">

                            <div class="card-body">
                                <h5 class="card-title">{{ $product->name }}</h5>
                                <div class="d-flex justify-content-between align-items-center">
                                    <p class="card-text">Rp {{ $product->price }}</p>
                                    <a class="btn button-primary btn-md" href="/product/{{ $product->id }}"
                                        role="button">Beli</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="row">
                <div class="col text-center">
                    <a href="/product" class="btn btn-md button-primary">Lihat Semua Produk</a>
                </div>
            </div>
        </div>
    </section>
    <!-- End Product -->

    <!-- Service -->
    <section class="sevice">
        <div class="container p-5">
            <div class="row mb-3">
                <div class="col text-center">
                    <h3>Our <span>Services</span></h3>
                </div>
            </div>
            <div class="row text-center mx-auto d-flex justify-content-between">
                <div class="col-md-12 col-lg-3 p-5">
                    <img src="{{ asset('custom/image/sell.png') }}" alt="" width="100px" />
                </div>
                <div class="col-md-12 col-lg-3 p-5">
                    <img src="{{ asset('custom/image/fast.png') }}" alt="" width="100px" />
                </div>
                <div class="col-md-12 col-lg-3 p-5">
                    <img src="{{ asset('custom/image/delivery.png') }}" alt="" width="100px" />
                </div>
            </div>
        </div>
    </section>
    <!-- End Service -->
@endsection
