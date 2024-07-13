@extends('pembeli.layouts.app')

@section('title', 'Pembayaran')

@section('content')
    <section class="h-100 h-custom cart">
        <div class="container py-5 h-100">
            <div class="row">
                <div class="col text-center">
                    <h3>Pembayaran Transaksi</h3>
                </div>
            </div>
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col">
                    <div class="card">
                        <div class="card-header">
                            Pembayaran Transaksi {{ $transaction->invoice }}
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">{{ $transaction->invoice }}</h5>
                            <p class="card-text">Anda akan membayar transaksi {{ $transaction->invoice }} dengan harga
                                {{ $transaction->grand_total }}</p>
                            <button class="btn btn-md button=primary">Bayar Sekarang</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('javascript')
    {{-- midtrans --}}
    <!-- TODO: Remove ".sandbox" from script src URL for production environment. Also input your client key in "data-client-key" -->
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
    <script type="text/javascript">
        document.getElementById('pay-button').onclick = function() {
            // SnapToken acquired from previous step
            snap.pay('{{ $transaction->snap_token }}', {
                // Optional
                onSuccess: function(result) {
                    /* You may add your own js here, this is just example */
                    document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                },
                // Optional
                onPending: function(result) {
                    /* You may add your own js here, this is just example */
                    document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                },
                // Optional
                onError: function(result) {
                    /* You may add your own js here, this is just example */
                    document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                }
            });
        };
    </script>
@endpush
