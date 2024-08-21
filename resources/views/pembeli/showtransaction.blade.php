@extends('pembeli.layouts.app')

@section('title', 'Detail Transaction')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="invoice bg-white p-5 rounded shadow">
                    <div class="invoice-header mb-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="mb-0 font-weight-bold text-primary">CV Tajuk</h5>
                                <small class="text-muted">{{ $transaction->transaction_code }} |
                                    {{ $transaction->created_at->format('d M Y H:i') }}</small>
                            </div>
                            <div class="text-right">
                                <h1 class="invoice-title text-primary">INVOICE</h1>
                            </div>
                        </div>
                        <div class="mt-3">
                            <span class="badge badge-pill badge-primary px-3 py-2">Status:
                                {{ ucfirst($transaction->status_payment) }}</span>
                        </div>
                    </div>
                    <div class="invoice-info mb-4">
                        <div class="row">
                            <div class="col-md-6">
                                <h5 class="font-weight-bold text-primary">Informasi Transaksi</h5>
                                <p class="text-muted">Pembayaran: {{ ucfirst($transaction->status_payment) }}</p>
                                <p class="text-muted">Pengiriman: {{ ucfirst($transaction->status_shipping) }}</p>
                                <p class="text-muted">Kurir: {{ $transaction->courier }}</p>
                                <p class="text-muted">Service: {{ $transaction->service }}</p>
                                <p class="text-muted">Total Harga:
                                    Rp{{ number_format($transaction->grand_total - $transaction->cost_courier) }}</p>
                                <p class="text-muted">Ongkir: Rp{{ number_format($transaction->cost_courier) }}</p>
                                <p class="text-muted">Total Keseluruhan: Rp{{ number_format($transaction->grand_total) }}
                                </p>
                            </div>
                            <div class="col-md-6">
                                <h5 class="font-weight-bold text-primary">Informasi Pembeli</h5>
                                <p class="text-muted">{{ $transaction->user->name }}</p>
                                <p class="text-muted">{{ $transaction->user->email }}</p>
                                <p class="text-muted">{{ $transaction->user->phone_number }}</p>
                                <p class="text-muted">{{ $transaction->user->address }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="invoice-footer">
                        <h5 class="font-weight-bold text-primary">Informasi Detail Transaksi</h5>
                        <table class="table">
                            <thead class="bg-primary text-white">
                                <tr>
                                    <th scope="col">No.</th>
                                    <th scope="col">Nama Produk</th>
                                    <th scope="col">Harga</th>
                                    <th scope="col">Jumlah</th>
                                    <th scope="col">Sub Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($details as $detail)
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>{{ $detail->product->name }}</td>
                                        <td>Rp{{ number_format($detail->product->price) }}</td>
                                        <td>{{ $detail->qty }}</td>
                                        <td>Rp{{ number_format($detail->product->price * $detail->qty) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="review-section mt-5">
                    <h5 class="font-weight-bold text-primary">Beri Ulasan untuk Produk</h5>
                    @foreach ($details as $detail)
                        <div class="mb-3">
                            <h6>{{ $detail->product->name }}</h6>
                            @php
                                // Cek apakah user sudah memberikan ulasan untuk produk ini
                                $userReview = $detail->product->reviews()->where('user_id', Auth::id())->first();
                            @endphp

                            @if ($userReview)
                                <div class="alert alert-success">
                                    <p>Anda sudah memberikan ulasan untuk produk ini:</p>
                                    <p><strong>{{ $userReview->review }}</strong></p>
                                </div>
                            @else
                                <form action="{{ route('customer.review.store', $detail->product->id) }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <textarea name="review" class="form-control" rows="3" placeholder="Tulis ulasan Anda di sini"></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary mt-2">Kirim Ulasan</button>
                                </form>
                            @endif
                        </div>
                    @endforeach
                </div>

            </div>
        </div>
    </div>
@endsection

<style>
    .invoice {
        border: 1px solid #e3e3e3;
        background-color: #f8f9fa;
    }

    .invoice-header {
        border-bottom: 2px solid #007bff;
        padding-bottom: 20px;
    }

    .invoice-title {
        font-size: 36px;
        color: #007bff;
    }

    .invoice-info h5 {
        font-size: 18px;
        font-weight: bold;
    }

    .invoice-info p {
        margin: 0;
        font-size: 16px;
    }

    .invoice-footer h5 {
        margin-top: 20px;
        font-size: 18px;
        font-weight: bold;
    }

    .table {
        width: 100%;
        margin-bottom: 1rem;
        color: #212529;
    }

    .table th,
    .table td {
        padding: 0.75rem;
        vertical-align: top;
        /* border-top: 1px solid #dee2e6; */
    }

    .table-striped tbody tr:nth-of-type(odd) {
        /* background-color: rgba(0, 0, 0, .05); */
    }

    .table-bordered {
        border: 1px solid #dee2e6;
    }

    .table-bordered th,
    .table-bordered td {
        border: 1px solid #dee2e6;
    }

    .table-bordered thead th,
    .table-bordered thead td {
        border-bottom-width: 2px;
    }

    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
    }

    .btn-primary:hover {
        background-color: #0056b3;
        border-color: #0056b3;
    }

    .btn-outline-primary {
        border-color: #007bff;
        color: #007bff;
    }

    .btn-outline-primary:hover {
        background-color: #007bff;
        color: #fff;
    }
</style>
