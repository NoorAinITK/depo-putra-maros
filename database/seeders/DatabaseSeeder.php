<?php

namespace Database\Seeders;

use App\Models\Expense;
use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Password di-hash otomatis oleh cast 'hashed' di model User.
        User::create([
            'name' => 'Yessi Setyo Soesanto', 'email' => 'admin@depo.test', 'phone' => '082100000000',
            'address' => 'JL. Projakal GG Blambangan No 1 Rt 01', 'role' => 'admin', 'password' => 'password',
        ]);

        $nayla = User::create([
            'name' => 'Nayla Ardina Maya', 'email' => 'nayla@depo.test', 'phone' => '081500000000',
            'address' => 'Jl. Sultan Hasanuddin Rt. 01 No. 1, Balikpapan', 'birth_date' => '2004-05-10',
            'gender' => 'Perempuan', 'role' => 'user', 'password' => 'password',
        ]);

        // Contoh transaksi supaya dashboard & laporan tidak kosong.
        $contoh = [
            // [hari lalu, jam, qty, sumber, status proses]
            [0, 9, 2, 'kasir', 'menunggu'],
            [0, 10, 1, 'online', 'diproses'],
            [1, 14, 5, 'kasir', 'selesai'],
            [2, 11, 3, 'online', 'selesai'],
            [3, 15, 2, 'kasir', 'selesai'],
            [4, 9, 4, 'kasir', 'selesai'],
            [6, 13, 1, 'online', 'selesai'],
            [9, 10, 5, 'kasir', 'selesai'],
            [15, 14, 2, 'kasir', 'selesai'],
            [22, 16, 3, 'online', 'selesai'],
        ];

        foreach ($contoh as [$hari, $jam, $qty, $sumber, $proses]) {
            $waktu = now()->subDays($hari)->setTime($jam, 30);
            $harga = config('depo.harga_galon');

            Order::forceCreate([
                'user_id' => $sumber === 'online' ? $nayla->id : null,
                'customer_name' => $sumber === 'online' ? $nayla->name : 'Pelanggan Kasir',
                'source' => $sumber,
                'order_type' => 'langsung',
                'qty' => $qty,
                'price' => $harga,
                'total' => $qty * $harga,
                'service_method' => 'pickup',
                'payment_method' => $sumber === 'online' ? 'qris' : 'cash',
                'payment_status' => 'lunas',
                'process_status' => $proses,
                'scheduled_at' => $sumber === 'online' ? $waktu : null,
                'created_at' => $waktu,
                'updated_at' => $waktu,
            ]);
        }

        Expense::create(['description' => 'Bayar listrik', 'amount' => 20000, 'spent_at' => now()->subDays(2)]);
        Expense::create(['description' => 'Beli filter air', 'amount' => 15000, 'spent_at' => now()->subDays(8)]);
    }
}
