@extends('pembeli.layouts.app')

@section('title', 'Cart')

@section('content')
    <section class="h-100 h-custom cart">
        <div class="container py-5 h-100">
            <div class="row">
                <div class="col text-center">
                    <h3>Keranjang</h3>
                </div>
            </div>
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col">
                    <div class="card">
                        <div class="card-body p-4">
                            <div class="row">
                                @if ($carts->isEmpty())
                                    <div class="text-center">
                                        <h4>Tidak ada produk dalam keranjang.</h4>
                                    </div>
                                @else
                                    <div class="col-lg-9">
                                        <div class="card mb-3">
                                            <div class="card-body">
                                                @foreach ($carts as $cart)
                                                    <div class="product d-flex justify-content-between">
                                                        <div class="d-flex flex-row align-items-center pb-3">
                                                            <div class="ms-lg-5">
                                                                <img src="{{ asset(Storage::url($cart->product->image)) }}"
                                                                    class="img-fluid rounded-3" alt="Shopping item"
                                                                    style="width: 400px" />
                                                            </div>
                                                            <div class="ms-5">
                                                                <h4>{{ $cart->product->name }}</h4>
                                                                <div class="d-flex flex-column mt-3">
                                                                    <p class="fs-5 text-start">
                                                                        Rp
                                                                        <span class="product-price"
                                                                            data-price="{{ $cart->product->price }}">
                                                                            {{ number_format($cart->product->price * $cart->quantity) }}
                                                                        </span>
                                                                    </p>
                                                                    <div class="d-flex flex-row align-items-center">
                                                                        {{-- hapus item --}}
                                                                        <form action="{{ route('update_cart', $cart) }}"
                                                                            method="post">
                                                                            @method('delete')
                                                                            @csrf
                                                                            <button class="btn fs-4 me-3">
                                                                                <i class="fa-solid fa-trash-can"></i>
                                                                            </button>
                                                                        </form>
                                                                        {{-- update quantity item --}}
                                                                        <div class="d-flex align-items-center">
                                                                            <button
                                                                                class="btn btn-outline-secondary quantity-decrease"
                                                                                data-cart-id="{{ $cart->id }}">-</button>
                                                                            <input type="number"
                                                                                class="form-control mx-2 quantity-input"
                                                                                name="quantity" id="quantity"
                                                                                value="{{ $cart->quantity }}"
                                                                                data-cart-id="{{ $cart->id }}"
                                                                                style="width: 100px;" />
                                                                            <button
                                                                                class="btn btn-outline-secondary quantity-increase"
                                                                                data-cart-id="{{ $cart->id }}">+</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                    @if (!$carts->isEmpty())
                        <div class="col-lg-3 my-5">
                            <div class="card rounded-3">
                                <div class="card-body">
                                    <div>
                                        <h5 class="mb-3">Ringkasan Belanja</h5>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <p class="mb-2">Subtotal</p>
                                        <p class="mb-2">Rp <span id="cart-subtotal">75.000</span></p>
                                    </div>
                                    <hr class="mt-3" />
                                    <a href="{{ route('checkout.page') }}" class="btn button-primary btn-md w-100">
                                        Lanjutkan Pembelian
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        </div>
        </div>
        </div>
    </section>
@endsection

@push('javascript')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.quantity-increase').forEach(button => {
                button.addEventListener('click', function() {
                    updateQuantity(this.dataset.cartId, 1);
                });
            });

            document.querySelectorAll('.quantity-decrease').forEach(button => {
                button.addEventListener('click', function() {
                    updateQuantity(this.dataset.cartId, -1);
                });
            });

            document.querySelectorAll('.quantity-input').forEach(input => {
                input.addEventListener('change', function() {
                    updateQuantity(this.dataset.cartId, 0, this.value);
                });
            });

            // Initial subtotal calculation on page load
            updateSubtotal();
        });

        function updateQuantity(cartId, change, newValue = null) {
            const quantityInput = document.querySelector(`.quantity-input[data-cart-id='${cartId}']`);
            const productPrice = quantityInput.closest('.product').querySelector('.product-price');
            const pricePerUnit = productPrice.dataset.price;

            let quantity = parseInt(quantityInput.value);

            if (newValue !== null) {
                quantity = parseInt(newValue);
            } else {
                quantity += change;
            }

            if (quantity < 1) quantity = 1;

            fetch(`/cart/${cartId}`, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        quantity: quantity
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        quantityInput.value = quantity;
                        productPrice.textContent = (quantity * pricePerUnit).toLocaleString('id-ID');
                        updateSubtotal();
                    }
                });
        }

        function updateSubtotal() {
            let subtotal = 0;
            document.querySelectorAll('.product-price').forEach(priceElement => {
                subtotal += parseInt(priceElement.textContent.replace(/\D/g, ''));
            });
            document.getElementById('cart-subtotal').textContent = subtotal.toLocaleString('id-ID');
        }
    </script>
@endpush
