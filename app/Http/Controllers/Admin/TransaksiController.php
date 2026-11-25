<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

// CRUD lengkap untuk transaksi kasir.
class TransaksiController extends Controller
{
    // READ (daftar): Riwayat Kasir & Riwayat Online
    public function index()
    {
        return view('admin.transaksi.index', [
            'kasir' => Order::where('source', 'kasir')->latest()->take(50)->get(),
            'online' => Order::where('source', 'online')->latest()->take(50)->get(),
        ]);
    }

    // CREATE (form): halaman "Transaksi Baru"
    public function create()
    {
        return view('admin.transaksi.create');
    }

    // CREATE (simpan ke MySQL)
    public function store(Request $request)
    {
        $data = $request->validate([
            'customer_name' => 'required|string|max:100',
            'qty' => 'required|integer|min:1|max:100',
            'service_method' => 'required|in:pickup,delivery',
            'payment_method' => 'required|in:qris,cash',
        ]);

        $harga = config('depo.harga_galon');

        Order::create($data + [
            'source' => 'kasir',
            'order_type' => 'langsung',
            'price' => $harga,
            'total' => $data['qty'] * $harga,   // total dihitung di server, bukan dari form
            'payment_status' => 'lunas',        // kasir menyimpan setelah pelanggan bayar
            'process_status' => 'menunggu',
        ]);

        return redirect()->route('admin.transaksi.index')->with('success', 'Transaksi berhasil disimpan.');
    }

    // UPDATE (form)
    public function edit(Order $order)
    {
        return view('admin.transaksi.edit', compact('order'));
    }

    // UPDATE (simpan perubahan)
    public function update(Request $request, Order $order)
    {
        $data = $request->validate([
            'customer_name' => 'required|string|max:100',
            'qty' => 'required|integer|min:1|max:100',
            'service_method' => 'required|in:pickup,delivery',
            'payment_method' => 'required|in:qris,cash',
            'payment_status' => 'required|in:lunas,belum',
            'process_status' => 'required|in:menunggu,diproses,terisi,selesai',
        ]);

        $order->update($data + ['total' => $data['qty'] * $order->price]);

        return redirect()->route('admin.transaksi.index')->with('success', 'Transaksi berhasil diperbarui.');
    }

    // DELETE
    public function destroy(Order $order)
    {
        $order->delete();

        return redirect()->route('admin.transaksi.index')->with('success', 'Transaksi dihapus.');
    }
}
