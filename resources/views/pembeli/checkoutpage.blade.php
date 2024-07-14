@extends('pembeli.layouts.app')

@section('title', 'Checkout')

@section('content')
    <section class="checkout px-3">
        <div class="container">
            <section class="py-5">
                <div class="container">
                    <div class="row">
                        <div class="col text-center">
                            <h3>Checkout</h3>
                        </div>
                    </div>
                </div>
            </section>
            <section class="py-5">
                @php
                    $sub_total = 0;
                    $grand_total = 0;
                    $weight = 0;
                    $ongkos = 0;
                @endphp
                <div class="row">
                    <div class="col-lg-8 mb-5">
                        <h5 class="mb-3">Data Pembeli</h5>
                        <form action="#">
                            <div class="row gy-3 my-2">
                                <div class="col-lg-6">
                                    <label class="form-label" for="name">Nama</label>
                                    <input class="form-control" type="text" id="name"
                                        value="{{ Auth::user()->name }}" disabled>
                                </div>
                                <div class="col-lg-6">
                                    <label class="form-label" for="email">Email</label>
                                    <input class="form-control" type="email" id="email"
                                        value="{{ Auth::user()->email }}" disabled>
                                </div>
                                <div class="col-lg-6">
                                    <label class="form-label" for="phone">Nomor Telepon</label>
                                    <input class="form-control" type="text" id="phone"
                                        value="{{ Auth::user()->phone_number }}" disabled>
                                </div>
                                <div class="col-lg-6">
                                    <label class="form-label" for="address">Alamat</label>
                                    <textarea class="form-control" type="text" id="address" disabled>{{ Auth::user()->address }}</textarea>
                                </div>
                            </div>
                        </form>
                        <h5 class="mb-3 mt-5">Rincian Pengiriman</h5>
                        <form id="ongkirForm">
                            @csrf
                            <div class="row gy-3 my-2">
                                <div class="col-lg-6 mb-3">
                                    <div class="form-group">
                                        <label class="form-label">Provinsi</label>
                                        <select class="form-control" id="province" name="province">
                                            <option value="">-- Pilih Provinsi --</option>
                                            @foreach ($provinces as $province)
                                                <option value="{{ $province->id }}">{{ $province->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-6 mb-3">
                                    <div class="form-group">
                                        <label class="form-label">Kota/Kabupaten</label>
                                        <select class="form-control" id="city" name="destination">
                                            <option value="">-- Pilih Kota --</option>
                                            <!-- Cities will be loaded here using AJAX -->
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-6 mb-3">
                                    @foreach ($carts as $cart)
                                        @php
                                            $weight += $cart->product->weight * $cart->quantity;
                                        @endphp
                                    @endforeach
                                    <label class="form-label" for="weight">Total Berat Barang (gr)</label>
                                    <input class="form-control text-muted" type="number" id="weight" name="weight"
                                        value="{{ $weight }}">
                                </div>

                                <div class="col-lg-6 mb-3">
                                    <div class="form-group">
                                        <label class="form-label">Ekspedisi</label>
                                        <select class="form-control" id="courier" name="courier">
                                            <option value="">-- Pilih Ekspedisi --</option>
                                            <option value="jne">JNE</option>
                                            <option value="tiki">TIKI</option>
                                            <option value="pos">POS</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <input type="button" name="checkOngkir" class="btn btn-md button-primary w-100"
                                id="checkOngkirButton" value="Cek Ongkir">
                        </form>

                        <div class="mt-5">
                            <div id="ongkirOptions">
                                @if ($ongkir != '')
                                    <h5 class="mb-3">Opsi Pengiriman</h5>
                                    <form id="shippingForm">
                                        @csrf
                                        @foreach ($ongkir as $item)
                                            <h6>{{ $item['name'] }}</h6>
                                            @foreach ($item['costs'] as $cost)
                                                @foreach ($cost['cost'] as $harga)
                                                    <div class="form-check">
                                                        <input class="form-check-input shipping-option" type="radio"
                                                            name="shipping_cost" value="{{ $harga['value'] }}"
                                                            data-service="{{ $cost['service'] }}"
                                                            data-cost="{{ $harga['value'] }}">
                                                        <label class="form-check-label">
                                                            {{ $cost['service'] }} -
                                                            Rp{{ number_format($harga['value']) }} (Estimasi:
                                                            {{ $harga['etd'] }} hari)
                                                        </label>
                                                    </div>
                                                @endforeach
                                            @endforeach
                                        @endforeach
                                        <input type="hidden" name="courier" id="courier" value="{{ session('courier') }}">
                                        {{-- <input type="hidden" name="province" value="{{ session('province') }}">
                                        <input type="hidden" name="city" value="{{ session('city') }}"> --}}
                                        <input type="hidden" name="province" value="{{ session('province') }}" id="province">
                                        <input type="hidden" name="city" value="{{ session('city') }}" id="city">
                                        <input type="hidden" name="weight" value="{{ session('weight') }}">
                                        <input type="hidden" name="selected_service" id="selectedService">
                                        <input type="hidden" name="shipping_cost_value" id="shippingCostValue">
                                        <button type="button" id="addShippingCost"
                                            class="btn button-primary mt-3 w-100">Tambahkan Ongkos Kirim</button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                    <!-- ORDER SUMMARY-->
                    <div class="col-lg-4">
                        <div class="card border-0 rounded-0 p-lg-4 bg-light">
                            <div class="card-body">
                                <h5 class="mb-5">Pesananmu</h5>
                                <ul class="list-unstyled mb-0">
                                    <p class="fw-bold">Daftar Produk</p>
                                    @foreach ($carts as $cart)
                                        @php
                                            $sub_total += $cart->product->price * $cart->quantity;
                                        @endphp
                                        <li class="d-flex align-items-center justify-content-between">
                                            <strong class="small fw-bold">{{ $cart->product->name }}</strong>
                                            <span
                                                class="text-muted small">Rp{{ number_format($cart->product->price * $cart->quantity) }}</span>
                                        </li>
                                        <li class="border-bottom my-2"></li>
                                    @endforeach
                                    <p class="fw-bold mt-5">Rincian Pembayaran</p>
                                    <li class="d-flex align-items-center justify-content-between">
                                        <strong class="small fw-bold">Total Produk</strong>
                                        <span class="text-muted small"
                                            id="subTotal">Rp{{ number_format($sub_total) }}</span>
                                    </li>
                                    <li class="border-bottom my-2"></li>
                                    <li class="d-flex align-items-center justify-content-between">
                                        <strong class="small fw-bold">Ongkos Kirim</strong>
                                        <span class="text-muted small"
                                            id="ongkosKirim">Rp{{ number_format($ongkos) }}</span>
                                    </li>
                                    <li class="border-bottom my-2"></li>
                                    @php
                                        $grand_total = $sub_total + $ongkos;
                                    @endphp
                                    <li class="d-flex align-items-center justify-content-between">
                                        <strong class="small fw-bold">Grand Total</strong>
                                        <span id="grandTotal">Rp{{ number_format($grand_total) }}</span>
                                        <input type="hidden" value="{{ $grand_total }}" name="grand_total"
                                            id="grandTotalValue">
                                    </li>
                                </ul>
                            </div>
                            <div class="mt-5 px-2">
                                <form action="{{ route('checkout.process') }}" method="post" class="">
                                    @csrf
                                    <input type="hidden" name="grand_total" value="{{ $grand_total }}"
                                        id="formGrandTotal">
                                    <input type="hidden" name="courier" value="{{ session('courier') }}">
                                    <input type="hidden" name="province" value="{{ session('province') }}">
                                    <input type="hidden" name="city" value="{{ session('city') }}">
                                    <input type="hidden" name="weight" value="{{ session('weight') }}">
                                    <input type="hidden" name="service" id="finalService">
                                    <input type="hidden" name="cost_courier" id="finalShippingCost">
                                    <div class="col-lg-12 form-group">
                                        <button class="btn button-primary" type="submit" style="width: 100%;">Bayar
                                            Sekarang</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </section>
@endsection

@push('javascript')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const provinceSelect = document.getElementById('province');
            const citySelect = document.getElementById('city');
            const checkOngkirButton = document.getElementById('checkOngkirButton');
            const ongkirForm = document.getElementById('ongkirForm');
            const ongkirOptions = document.getElementById('ongkirOptions');
            let selectedServiceInput = document.getElementById('selectedService');
            let shippingCostValue = document.getElementById('shippingCostValue');
            let finalServiceInput = document.getElementById('finalService');
            let finalShippingCostInput = document.getElementById('finalShippingCost');

            const subTotalElement = document.getElementById('subTotal');
            const ongkosKirimElement = document.getElementById('ongkosKirim');
            const grandTotalElement = document.getElementById('grandTotal');
            const formGrandTotal = document.getElementById('formGrandTotal');
            const grandTotalValue = document.getElementById('grandTotalValue');

            provinceSelect.addEventListener('change', function() {
                const provinceId = this.value;
                fetch(`/api/rajaongkir/cities?province_id=${provinceId}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            citySelect.innerHTML = '<option value="">-- Pilih Kota --</option>';
                            data.data.forEach(city => {
                                citySelect.innerHTML +=
                                    `<option value="${city.id}">${city.name}</option>`;
                            });
                        }
                    });
            });

            checkOngkirButton.addEventListener('click', function(event) {
                event.preventDefault();
                const formData = new FormData(ongkirForm);

                fetch('{{ route('checkOngkir') }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content'),
                        },
                        body: formData,
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Render opsi pengiriman
                            const ongkirOptionsContent = data.ongkir.map(item => {
                                return `
                            <h6>${item.name}</h6>
                            ${item.costs.map(cost => {
                                return `
                                        ${cost.cost.map(harga => {
                                            return `
                                            <div class="form-check">
                                                <input class="form-check-input shipping-option" type="radio" name="shipping_cost" value="${harga.value}" data-service="${cost.service}" data-cost="${harga.value}">
                                                <label class="form-check-label">
                                                    ${cost.service} - Rp${harga.value} (Estimasi: ${harga.etd} hari)
                                                </label>
                                            </div>
                                        `;
                                        }).join('')}
                                    `;
                            }).join('')}
                        `;
                            }).join('');

                            ongkirOptions.innerHTML = `
                        <h5 class="mb-3">Opsi Pengiriman</h5>
                        <form id="shippingForm">
                            ${ongkirOptionsContent}
                            <input type="hidden" name="selected_service" id="selectedService">
                            <input type="hidden" name="shipping_cost_value" id="shippingCostValue">
                            <button type="button" id="addShippingCost" class="btn button-primary mt-3 w-100">Tambahkan Ongkos Kirim</button>
                        </form>
                    `;

                            // Redefine selectedServiceInput and shippingCostValue after rendering new content
                            selectedServiceInput = document.getElementById('selectedService');
                            shippingCostValue = document.getElementById('shippingCostValue');
                            finalServiceInput = document.getElementById('finalService');
                            finalShippingCostInput = document.getElementById('finalShippingCost');

                            // Tambahkan event listener ke radio button setelah opsi pengiriman dirender
                            document.querySelectorAll('input[name="shipping_cost"]').forEach(input => {
                                input.addEventListener('change', function() {
                                    console.log('Selected shipping cost:', this.value);
                                    console.log('Selected service:', this.dataset
                                        .service);
                                    console.log('Selected cost:', this.dataset.cost);

                                    if (selectedServiceInput) {
                                        selectedServiceInput.value = this.dataset
                                            .service;
                                    }
                                    if (finalServiceInput) {
                                        finalServiceInput.value = this.dataset.service;
                                    }
                                    if (shippingCostValue) {
                                        shippingCostValue.value = this.dataset.cost;
                                    }
                                    if (finalShippingCostInput) {
                                        finalShippingCostInput.value = this.value;
                                    }

                                    console.log('selectedServiceInput:',
                                        selectedServiceInput ? selectedServiceInput
                                        .value : null);
                                    console.log('finalServiceInput:',
                                        finalServiceInput ? finalServiceInput
                                        .value : null);
                                    console.log('shippingCostValue:',
                                        shippingCostValue ? shippingCostValue
                                        .value : null);
                                    console.log('finalShippingCostInput:',
                                        finalShippingCostInput ?
                                        finalShippingCostInput.value : null);
                                });
                            });

                            // Tambahkan event listener ke button setelah opsi pengiriman dirender
                            const newAddShippingCostButton = document.getElementById('addShippingCost');
                            if (newAddShippingCostButton) {
                                newAddShippingCostButton.addEventListener('click', function() {
                                    const shippingCost = parseFloat(shippingCostValue.value);
                                    const subTotal = parseFloat({{ $sub_total }});
                                    const grandTotal = subTotal + shippingCost;

                                    if (ongkosKirimElement) {
                                        ongkosKirimElement.innerText =
                                            `Rp${shippingCost.toLocaleString()}`;
                                    }
                                    if (grandTotalElement) {
                                        grandTotalElement.innerText =
                                            `Rp${grandTotal.toLocaleString()}`;
                                    }
                                    if (grandTotalValue) {
                                        grandTotalValue.value = grandTotal;
                                    }
                                    if (formGrandTotal) {
                                        formGrandTotal.value = grandTotal;
                                    }
                                });
                            }
                        }
                    });
            });
        });
    </script>
@endpush
