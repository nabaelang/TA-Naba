<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use App\Models\Transaction;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index()
    {
        return view('admin.laporan.laporan');
    }

    // public function getData(Request $request)
    // {
    //     $startDate = $request->input('start_date');
    //     $endDate = $request->input('end_date');

    //     // Validasi tanggal
    //     if ($startDate > $endDate) {
    //         return response()->json(['error' => 'Tanggal awal tidak boleh lebih besar dari tanggal akhir'], 400);
    //     }

    //     // Generate a list of all dates within the specified range
    //     $dateRange = Carbon::parse($startDate)->toPeriod($endDate)->toArray();

    //     // Get transactions within the specified range
    //     $laporanPenjualan = Transaction::whereBetween('created_at', [$startDate, $endDate])
    //         ->where('status_payment', 'success')
    //         ->get();

    //     // Group transactions by formatted date
    //     $groupedTransactions = $laporanPenjualan->groupBy(function ($transaction) {
    //         return Carbon::parse($transaction->created_at)->isoFormat('D MMMM YYYY');
    //     });

    //     // Initialize an empty array to store merged data
    //     $mergedData = [];

    //     // Iterate through the date range
    //     foreach ($dateRange as $date) {
    //         $formattedDate = Carbon::parse($date)->isoFormat('D MMMM YYYY');
    //         $transactions = $groupedTransactions[$formattedDate] ?? collect();

    //         // Check if transactions exist for the date
    //         if ($transactions->isNotEmpty()) {
    //             $total = $transactions->sum('grand_total') - $transactions->sum('pajak');

    //             $mergedData[] = [
    //                 'date' => $formattedDate,
    //                 'total' => $total,
    //                 'transactions' => $transactions,
    //             ];
    //         }
    //     }

    //     return response()->json($mergedData);
    // }

    // public function downloadPdf(Request $request)
    // {
    //     $startDate = $request->input('start_date');
    //     $endDate = $request->input('end_date');

    //     // Validasi tanggal
    //     if ($startDate > $endDate) {
    //         return redirect()->back()->with('error', 'Tanggal awal tidak boleh lebih besar dari tanggal akhir');
    //     }

    //     // Generate a list of all dates within the specified range
    //     $dateRange = Carbon::parse($startDate)->toPeriod($endDate)->toArray();

    //     // Get transactions within the specified range
    //     $laporanPenjualan = Transaction::whereBetween('created_at', [$startDate, $endDate])
    //         ->where('status_payment', 'success')
    //         ->get();

    //     // Group transactions by formatted date
    //     $groupedTransactions = $laporanPenjualan->groupBy(function ($transaction) {
    //         return Carbon::parse($transaction->created_at)->isoFormat('D MMMM YYYY');
    //     });

    //     // Initialize an empty array to store merged data
    //     $mergedData = [];

    //     // Iterate through the date range
    //     foreach ($dateRange as $date) {
    //         $formattedDate = Carbon::parse($date)->isoFormat('D MMMM YYYY');
    //         $transactions = $groupedTransactions[$formattedDate] ?? collect();

    //         // Check if transactions exist for the date
    //         if ($transactions->isNotEmpty()) {
    //             $total = $transactions->sum('total') - $transactions->sum('pajak');

    //             $mergedData[] = [
    //                 'date' => $formattedDate,
    //                 'total' => $total,
    //                 'transactions' => $transactions,
    //             ];
    //         }
    //     }

    //     $pdf = PDF::loadView('admin.laporan.pdf', ['data' => $mergedData]);
    //     return $pdf->download('laporan_penjualan.pdf');
    // }

    public function getData(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Validasi tanggal
        if ($startDate > $endDate) {
            return response()->json(['error' => 'Tanggal awal tidak boleh lebih besar dari tanggal akhir'], 400);
        }

        // Generate a list of all dates within the specified range
        $dateRange = Carbon::parse($startDate)->toPeriod($endDate)->toArray();

        // Get transactions within the specified range
        $laporanPenjualan = Transaction::whereBetween('created_at', [$startDate, $endDate])
            ->where('status_payment', 'success')
            ->get();

        // Group transactions by formatted date
        $groupedTransactions = $laporanPenjualan->groupBy(function ($transaction) {
            return Carbon::parse($transaction->created_at)->isoFormat('D MMMM YYYY');
        });

        // Initialize an empty array to store merged data
        $mergedData = [];

        // Iterate through the date range
        foreach ($dateRange as $date) {
            $formattedDate = Carbon::parse($date)->isoFormat('D MMMM YYYY');
            $transactions = $groupedTransactions[$formattedDate] ?? collect();

            // Check if transactions exist for the date
            if ($transactions->isNotEmpty()) {
                $total = $transactions->sum('grand_total');

                $mergedData[] = [
                    'date' => $formattedDate,
                    'total' => $total,
                    'transactions' => $transactions,
                ];
            }
        }

        return response()->json($mergedData);
    }

    public function downloadPdf(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Validasi tanggal
        if ($startDate > $endDate) {
            return redirect()->back()->with('error', 'Tanggal awal tidak boleh lebih besar dari tanggal akhir');
        }

        // Generate a list of all dates within the specified range
        $dateRange = Carbon::parse($startDate)->toPeriod($endDate)->toArray();

        // Get transactions within the specified range
        $laporanPenjualan = Transaction::whereBetween('created_at', [$startDate, $endDate])
            ->where('status_payment', 'success')
            ->get();

        // Group transactions by formatted date
        $groupedTransactions = $laporanPenjualan->groupBy(function ($transaction) {
            return Carbon::parse($transaction->created_at)->isoFormat('D MMMM YYYY');
        });

        // Initialize an empty array to store merged data
        $mergedData = [];

        // Iterate through the date range
        foreach ($dateRange as $date) {
            $formattedDate = Carbon::parse($date)->isoFormat('D MMMM YYYY');
            $transactions = $groupedTransactions[$formattedDate] ?? collect();

            // Check if transactions exist for the date
            if ($transactions->isNotEmpty()) {
                $total = $transactions->sum('grand_total');

                $mergedData[] = [
                    'date' => $formattedDate,
                    'total' => $total,
                    'transactions' => $transactions,
                ];
            }
        }

        $pdf = PDF::loadView('admin.laporan.pdf', ['data' => $mergedData]);
        return $pdf->download('laporan_penjualan.pdf');
    }
}
