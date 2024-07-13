@extends('admin.layouts.app')

@section('title', 'Detail Transaction')

@section('content')
    <div class="pagetitle">
        <h1>Detail Transaksi {{ $transaction->transaction_code }}</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/admin/dashboard">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="/admin/transaction">Transaksi</a></li>
                <li class="breadcrumb-item active">Data Transaksi</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Detail Transaksi {{ $transaction->transaction_code }}</h5>
                        <h6>Data Transaksi</h6>
                        <table class="table mb-5">
                            <tbody>
                                <tr>
                                    <th>Pembeli</th>
                                    <td>{{ $transaction->user->name }}</td>
                                </tr>
                                <tr>
                                    <th>Provinsi</th>
                                    <td>{{ $transaction->provinces->name }}</td>
                                </tr>
                                <tr>
                                    <th>Kabupaten/Kota</th>
                                    <td>{{ $transaction->cities->name }}</td>
                                </tr>
                                <tr>
                                    <th>Alamat Lengkap</th>
                                    <td>{{ $transaction->address }}</td>
                                </tr>
                                <tr>
                                    <th>Kurir</th>
                                    <td>{{ $transaction->courier }}</td>
                                </tr>
                                <tr>
                                    <th>Service</th>
                                    <td>{{ $transaction->service }}</td>
                                </tr>
                                <tr>
                                    <th>Berat</th>
                                    <td>{{ $transaction->weight }} (gr)</td>
                                </tr>
                                <tr>
                                    <th>Ongkir</th>
                                    <td>Rp{{ number_format($transaction->cost_courier) }}</td>
                                </tr>
                                <tr>
                                    <th>Total</th>
                                    <td>Rp{{ number_format($transaction->grand_total) }}</td>
                                </tr>
                                <tr>
                                    <th>Tanggal</th>
                                    <td>{{ $transaction->created_at }}</td>
                                </tr>
                                <tr>
                                    <th>Status Pembayaran</th>
                                    <td>{{ $transaction->status_payment }}</td>
                                </tr>
                                <tr>
                                    <th>Status Pengiriman</th>
                                    <td>{{ $transaction->status_shipping }}</td>
                                </tr>
                            </tbody>
                        </table>
                        <!-- Table with stripped rows -->
                        <h6>Data Detail Transaksi</h6>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Gambar</th>
                                    <th scope="col">Produk</th>
                                    <th scope="col">Jumlah</th>
                                    <th scope="col">Harga</th>
                                    <th scope="col">Akumulasi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($details as $detail)
                                    <tr>
                                        <td><img src="{{ Storage::url($detail->product->image) }}" alt=""
                                                style="height:40px; width:60px; object-fit: cover;">
                                        </td>
                                        <td>{{ $detail->product->name }}</td>
                                        <td>{{ $detail->qty }}</td>
                                        <td>Rp{{ number_format($detail->product->price) }}</td>
                                        <td>Rp{{ number_format($detail->product->price * $detail->qty) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <!-- End Table with stripped rows -->
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
