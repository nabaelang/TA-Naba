@extends('pembeli.layouts.app')

@section('title', 'Transaction')

@section('content')
    <section class="h-100 h-custom transaction">
        <div class="container py-5 h-100">
            <div class="row mb-4">
                <div class="col text-center">
                    <h3 class="display-4">Daftar Transaksi</h3>
                </div>
            </div>
            <div class="row mt-5">
                <div class="col">
                    <div class="card shadow-sm border-0">
                        <div class="card-body p-4">
                            <div class="row">
                                <div class="col">
                                    @foreach ($transactions as $transaction)
                                        <div class="card mb-3 border-light shadow-sm">
                                            <div class="card-body">
                                                <div class="product d-flex justify-content-between align-items-center">
                                                    <div class="d-flex flex-column">
                                                        <h5 class="mb-2">{{ $transaction->transaction_code }}</h5>
                                                        <p class="text-muted mb-1">{{ $transaction->created_at }}</p>
                                                        <p
                                                            class="badge mb-1 
                                                            @if ($transaction->status_payment == 'success') bg-primary 
                                                            @elseif($transaction->status_payment == 'pending') bg-warning 
                                                            @elseif($transaction->status_payment == 'Cancelled') bg-danger @endif">
                                                            {{ $transaction->status_payment }}
                                                        </p>
                                                        <p
                                                            class="badge mb-1
                                                            @if ($transaction->status_shipping == 'selesai') bg-success
                                                            @elseif($transaction->status_shipping == 'dikirim') bg-primary
                                                            @elseif($transaction->status_shipping == 'disiapkan') bg-warning
                                                            @elseif($transaction->status_shipping == 'pending') bg-secondary @endif">
                                                            {{ $transaction->status_shipping }}
                                                        </p>
                                                    </div>
                                                    <div class="text-end">
                                                        <h5 class="text-start mb-3">
                                                            Rp
                                                            <span class="product-price" data-price="{">
                                                                {{ number_format($transaction->grand_total) }}
                                                            </span>
                                                        </h5>
                                                        <a href="{{ route('customer.show.transaction', $transaction) }}"
                                                            class="btn btn-sm btn-primary">Detail Transaksi</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
