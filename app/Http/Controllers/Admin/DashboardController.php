<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;

class DashboardController extends Controller
{
    // READ: ringkasan hari ini + 3 transaksi terakhir
    public function index()
    {
        $hariIni = Order::whereDate('created_at', today());

        return view('admin.dashboard', [
            'pemasukan' => (clone $hariIni)->where('payment_status', 'lunas')->sum('total'),
            'jumlah' => (clone $hariIni)->count(),
            'terakhir' => Order::latest()->take(3)->get(),
        ]);
    }
}
