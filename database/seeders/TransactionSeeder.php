<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $transactions = [];

        for ($i = 0; $i < 47; $i++) {
            $transactions[] = [
                'transaction_code' => 'TRANS-' . Str::random(5), // kode transaksi acak dengan 5 karakter
                'user_id' => 1,
                'courier' => 'JNE', // atau bisa diganti sesuai keinginan
                'service' => 'REG', // layanan pengiriman, bisa diganti sesuai keinginan
                'cost_courier' => rand(15000, 50000), // biaya kurir acak antara 15.000 hingga 50.000
                'weight' => rand(500, 2000), // berat acak antara 500g hingga 2000g
                'name' => 'User ' . $i, // nama penerima bisa disesuaikan
                'phone' => '08123456789' . rand(0, 9), // nomor telepon acak
                'province' => rand(1, 34), // ID provinsi acak, sesuaikan dengan data provinsi yang ada
                'city' => rand(1, 100), // ID kota acak, sesuaikan dengan data kota yang ada
                'address' => 'Alamat ' . Str::random(10), // alamat acak
                'status_payment' => $this->randomPaymentStatus(), // status pembayaran acak
                'status_shipping' => $this->randomShippingStatus(), // status pengiriman acak
                'grand_total' => rand(100000, 1000000), // total transaksi acak antara 100.000 hingga 1.000.000
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('transactions')->insert($transactions);
    }

    /**
     * Get random payment status
     *
     * @return string
     */
    private function randomPaymentStatus()
    {
        $statuses = ['pending', 'success', 'failed', 'expired'];
        return $statuses[array_rand($statuses)];
    }

    /**
     * Get random shipping status
     *
     * @return string
     */
    private function randomShippingStatus()
    {
        $statuses = ['pending', 'disiapkan', 'dikirim', 'selesai'];
        return $statuses[array_rand($statuses)];
    }
}
