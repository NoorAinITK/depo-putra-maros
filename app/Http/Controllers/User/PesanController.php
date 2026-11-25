<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

// Alur pengguna: Beranda -> Pesan (sekarang/terjadwal) -> Pembayaran -> Sukses -> Riwayat
class PesanController extends Controller
{
    public const SLOT = ['08:00', '09:00', '10:00', '11:00', '13:00', '14:00', '15:00', '16:00'];

    public function beranda(Request $request)
    {
        return view('user.beranda', ['user' => $request->user()]);
    }

    // Form pesan (mode: sekarang | terjadwal)
    public function create(string $mode)
    {
        return view('user.pesan', ['mode' => $mode, 'slots' => self::SLOT]);
    }

    // Langkah 1: validasi form, simpan sebagai "draft" di session, lanjut ke pembayaran
    public function lanjut(Request $request, string $mode)
    {
        $rules = [
            'qty' => 'required|integer|min:1|max:100',
            'service_method' => 'required|in:pickup,delivery',
        ];

        if ($mode === 'sekarang') {
            $rules += [
                'customer_name' => 'required|string|max:100',
                'pickup_time' => 'required|date_format:H:i|after_or_equal:08:00|before_or_equal:17:00',
            ];
        } else {
            $rules += [
                'date' => 'required|date|after_or_equal:today',
                'slot' => 'required|in:'.implode(',', self::SLOT),
            ];
        }

        $d = $request->validate($rules, [
            'pickup_time.after_or_equal' => 'Jam pengambilan minimal 08:00.',
            'pickup_time.before_or_equal' => 'Jam pengambilan maksimal 17:00.',
        ]);

        $waktu = $mode === 'sekarang'
            ? Carbon::today()->setTimeFromTimeString($d['pickup_time'])
            : Carbon::parse($d['date'].' '.$d['slot']);

        session(['draft' => [
            'mode' => $mode,
            'qty' => (int) $d['qty'],
            'service_method' => $d['service_method'],
            'customer_name' => $d['customer_name'] ?? $request->user()->name,
            'scheduled_at' => $waktu->toDateTimeString(),
        ]]);

        return redirect()->route('user.pembayaran');
    }

    // Langkah 2: halaman pembayaran (ringkasan + QRIS / Cash)
    public function pembayaran()
    {
        $draft = session('draft');
        if (! $draft) {
            return redirect()->route('user.beranda');
        }

        return view('user.pembayaran', [
            'draft' => $draft,
            'total' => $draft['qty'] * config('depo.harga_galon'),
            'jadwal' => Carbon::parse($draft['scheduled_at']),
        ]);
    }

    // Langkah 3: CREATE order di MySQL
    public function bayar(Request $request)
    {
        $draft = session('draft');
        if (! $draft) {
            return redirect()->route('user.beranda');
        }

        $data = $request->validate(['payment_method' => 'required|in:qris,cash']);
        $harga = config('depo.harga_galon');

        Order::create([
            'user_id' => $request->user()->id,
            'customer_name' => $draft['customer_name'],
            'source' => 'online',
            'order_type' => $draft['mode'] === 'sekarang' ? 'langsung' : 'terjadwal',
            'qty' => $draft['qty'],
            'price' => $harga,
            'total' => $draft['qty'] * $harga,
            'service_method' => $draft['service_method'],
            'payment_method' => $data['payment_method'],
            // QRIS dianggap lunas (simulasi). CASH baru lunas saat galon diambil.
            'payment_status' => $data['payment_method'] === 'qris' ? 'lunas' : 'belum',
            'process_status' => 'menunggu',
            'scheduled_at' => $draft['scheduled_at'],
        ]);

        session()->forget('draft');

        return redirect()->route('user.sukses');
    }

    public function sukses()
    {
        return view('user.sukses');
    }

    // READ: riwayat milik pengguna yang login saja
    public function riwayat(Request $request)
    {
        return view('user.riwayat', [
            'orders' => Order::where('user_id', $request->user()->id)->latest()->get(),
        ]);
    }

    // DELETE: batalkan pesanan sendiri selama belum diproses
    public function batal(Request $request, Order $order)
    {
        abort_unless($order->user_id === $request->user()->id && $order->process_status === 'menunggu', 403);

        $order->delete();

        return back()->with('success', 'Pesanan dibatalkan.');
    }
}
