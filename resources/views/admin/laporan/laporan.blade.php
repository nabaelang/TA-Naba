@extends('admin.layouts.app')

@section('title', 'Laporan Penjualan')

@section('content')
    <div class="pagetitle">
        <h1>Laporan Penjualan</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/admin/dashboard">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="/admin/laporan">Laporan Penjualan</a></li>
                <li class="breadcrumb-item active">Laporan Penjualan</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Data Laporan Penjualan</h5>
                        <form id="laporanForm">
                            @csrf
                            <table class="table table-borderless">
                                <tbody>
                                    <tr>
                                        <th>
                                            <label for="start_date" class="form-label">Tanggal Awal</label>
                                        </th>
                                        <td>
                                            <input type="date" name="start_date" required class="form-control">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            <label for="end_date">Tanggal Akhir</label>
                                        </th>
                                        <td>
                                            <input type="date" name="end_date" required class="form-control">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th></th>
                                        <td>
                                            <button type="submit" class="btn btn-md btn-primary">Buat Laporan</button>
                                            <button id="downloadPdfBtn" class="btn btn-md btn-success" disabled>Unduh
                                                Laporan PDF</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </form>

                        <!-- Table with stripped rows -->
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">No.</th>
                                    <th scope="col">Tanggal</th>
                                    <th scope="col">Total</th>
                                </tr>
                            </thead>
                            <tbody class="bodyLaporan">

                            </tbody>
                            <tfoot id="footerTable" style="display: none;">
                                <tr>
                                    <td colspan="2"><strong>Total Pendapatan:</strong></td>
                                    <td id="totalPendapatan"><strong>Rp0</strong></td>
                                </tr>
                            </tfoot>
                        </table>
                        <!-- End Table with stripped rows -->
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

{{-- @push('javascript')
    <script>
        $(document).ready(function() {
            $('#laporanForm').on('submit', function(e) {
                e.preventDefault();
                const startDate = $('input[name="start_date"]').val();
                const endDate = $('input[name="end_date"]').val();

                $.ajax({
                    url: '{{ route('laporan.getData') }}',
                    method: 'GET',
                    data: {
                        start_date: startDate,
                        end_date: endDate,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(data) {
                        let tbody = $('.bodyLaporan');
                        tbody.empty();
                        let totalPendapatan = 0;

                        data.forEach((item, index) => {
                            let row = `<tr>
                                <td>${index + 1}</td>
                                <td>${item.date}</td>
                                <td>Rp${item.total}</td>
                            </tr>`;
                            tbody.append(row);
                            totalPendapatan += item.total;
                        });

                        $('#totalPendapatan').text(`Rp${totalPendapatan}`);
                        $('#footerTable').show();
                    },
                    error: function(xhr) {
                        alert('Terjadi kesalahan: ' + xhr.responseJSON.error);
                    }
                });
            });
        });
    </script>
@endpush --}}
@push('javascript')
    <script>
        $(document).ready(function() {
            $('#laporanForm').on('submit', function(e) {
                e.preventDefault();
                const startDate = $('input[name="start_date"]').val();
                const endDate = $('input[name="end_date"]').val();

                $.ajax({
                    url: '{{ route('laporan.getData') }}',
                    method: 'GET',
                    data: {
                        start_date: startDate,
                        end_date: endDate,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(data) {
                        let tbody = $('.bodyLaporan');
                        tbody.empty();
                        let totalPendapatan = 0;

                        data.forEach((item, index) => {
                            let row = `<tr>
                                <td>${index + 1}</td>
                                <td>${item.date}</td>
                                <td>Rp${item.total}</td>
                            </tr>`;
                            tbody.append(row);
                            totalPendapatan += item.total;
                        });

                        $('#totalPendapatan').text(`Rp${totalPendapatan}`);
                        $('#footerTable').show();
                        $('#downloadPdfBtn').prop('disabled', false); // Enable download button
                    },
                    error: function(xhr) {
                        alert('Terjadi kesalahan: ' + xhr.responseJSON.error);
                    }
                });
            });

            $('#downloadPdfBtn').on('click', function() {
                const startDate = $('input[name="start_date"]').val();
                const endDate = $('input[name="end_date"]').val();

                window.location.href = '{{ route('laporan.downloadPdf') }}?start_date=' + startDate +
                    '&end_date=' + endDate;
            });
        });
    </script>
@endpush
