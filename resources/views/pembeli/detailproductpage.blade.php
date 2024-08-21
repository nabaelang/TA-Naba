@extends('pembeli.layouts.app')

@section('title', 'Detail Product')

@section('content')
    <section class="products">
        <div class="container p-5">
            <div class="row align-items-center">
                <div class="col-md-10 mx-auto col-xl-5 mb-4">
                    <div class="lc-block">
                        <img class="img-fluid" src="{{ asset(Storage::url($product->image)) }}" alt="{{ $product->name }}"
                            loading="lazy" />
                    </div>
                </div>
                <div class="col-12 col-xl-5 mx-auto">
                    <div class="lc-block mb-5 me-lg-5">
                        <div editable="rich">
                            <h1 class="fw-normal">{{ $product->name }}</h1>
                            <h5 class="fw-normal">Rp {{ $product->price }}</h5>
                            <div class="d-flex justify-content-between align-items-end mt-5">
                                <form id="quantityForm">
                                    <div>
                                        <label for="qty" class="form-label fw-bold fs-5">Atur Jumlah</label>
                                        <input type="number" class="form-control" id="qty" name="quantity"
                                            value="1" min="1" max="{{ $product->stock - 5 }}" />
                                    </div>
                                </form>
                                <span class="fs-5 fw-light">Stock Total: {{ $product->stock }}</span>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="d-flex justify-content-between">
                            <span>Sub Total:</span>
                            <span id="subtotal">Rp {{ $product->price }}</span>
                        </div>
                        <form action="{{ route('add_toCart', $product->id) }}" method="POST" id="cartForm">
                            @csrf
                            <input type="hidden" name="quantity" value="1" id="hiddenQuantity">
                            <button class="btn btn-md button-primary mt-2 w-100" id="cartButton">Keranjang</button>
                        </form>
                        <div id="error-message" class="text-danger mt-2" style="display: none;">Jumlah produk tidak boleh
                            melebihi stok yang tersedia dan harus menyisakan minimal 5 buah stok.</div>
                    </div>
                </div>
            </div>
            <div class="row mt-lg-3 mt-md-4 my-5">
                <div class="col col-lg-10 col-xl-8">
                    <p class="text-secondary">Description</p>
                    <hr />
                    <p>
                        {!! $product->description !!}
                    </p>
                </div>
            </div>
            <div class="row mt-lg-3 mt-md-4 my-5">
                <div class="col col-lg-10 col-xl-8">
                    <p class="text-secondary">Ulasan Product</p>
                    <hr />
                    @foreach ($product->reviews as $review)
                        <div class="review mb-3">
                            <p><strong>{{ $review->user->name }}</strong></p>
                            <p>{{ $review->review }}</p>
                            <hr>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <script>
        document.getElementById('qty').addEventListener('input', function() {
            let quantity = this.value;
            let price = {{ $product->price }};
            let subtotal = quantity * price;

            document.getElementById('subtotal').innerText = 'Rp ' + subtotal;
            document.getElementById('hiddenQuantity').value = quantity;
        });

        document.getElementById('cartForm').addEventListener('submit', function(event) {
            event.preventDefault();
            let quantity = document.getElementById('qty').value;
            let stock = {{ $product->stock }};
            if (quantity > stock - 5) {
                document.getElementById('error-message').style.display = 'block';
                return false;
            } else {
                document.getElementById('error-message').style.display = 'none';
                document.getElementById('hiddenQuantity').value = quantity;
                this.submit();
            }
        });
    </script>
@endsection
