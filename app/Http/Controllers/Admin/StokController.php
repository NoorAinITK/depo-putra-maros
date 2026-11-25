<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;

class StokController extends Controller
{
    // Urutan status galon: menunggu -> diproses -> terisi -> selesai
    private const LANJUT = ['menunggu' => 'diproses', 'diproses' => 'terisi', 'terisi' => 'selesai'];

    // READ: antrian galon hari ini
    public function index()
    {
        $orders = Order::hariIni()->get();

        return view('admin.stok', [
            'terisi' => $orders->where('process_status', 'terisi')->sum('qty'),
            'diproses' => $orders->where('process_status', 'diproses')->sum('qty'),
            'menunggu' => $orders->where('process_status', 'menunggu')->sum('qty'),
            'selesai' => $orders->where('process_status', 'selesai')->sum('qty'),
            'total' => $orders->sum('qty'),
            'antrian' => $orders->where('process_status', '!=', 'selesai')->sortBy('waktu')->values(),
        ]);
    }

    // UPDATE: geser status satu langkah
    public function update(Order $order)
    {
        $berikut = self::LANJUT[$order->process_status] ?? null;

        if ($berikut) {
            $data = ['process_status' => $berikut];
            // Pesanan CASH baru dibayar saat galon diambil -> otomatis lunas ketika selesai
            if ($berikut === 'selesai') {
                $data['payment_status'] = 'lunas';
            }
            $order->update($data);
        }

        return back()->with('success', 'Status galon diperbarui.');
    }
}
