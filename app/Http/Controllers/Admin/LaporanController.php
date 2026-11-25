<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use App\Models\Order;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    // READ + agregasi: laporan Mingguan / Bulanan
    public function index(Request $request)
    {
        $periode = $request->query('periode') === 'bulanan' ? 'bulanan' : 'mingguan';

        $awal = $periode === 'bulanan' ? now()->startOfMonth() : now()->startOfWeek();
        $akhir = $periode === 'bulanan' ? now()->endOfMonth() : now()->endOfWeek();

        $orders = Order::where('payment_status', 'lunas')
            ->whereBetween('created_at', [$awal, $akhir])
            ->get();

        $pemasukan = $orders->sum('total');
        $pengeluaran = Expense::whereBetween('spent_at', [$awal->toDateString(), $akhir->toDateString()])->sum('amount');

        if ($periode === 'bulanan') {
            $label = ['M1', 'M2', 'M3', 'M4'];
            $batang = collect(range(1, 4))->map(fn ($m) => $orders
                ->filter(fn ($o) => min(4, (int) ceil($o->created_at->day / 7)) === $m)
                ->sum('total'));
        } else {
            $label = ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'];
            $batang = collect(range(1, 7))->map(fn ($h) => $orders
                ->filter(fn ($o) => $o->created_at->dayOfWeekIso === $h)
                ->sum('total'));
        }

        return view('admin.laporan', [
            'periode' => $periode,
            'pemasukan' => $pemasukan,
            'jumlah' => $orders->count(),
            'pengeluaran' => $pengeluaran,
            'keuntungan' => $pemasukan - $pengeluaran,
            'label' => $label,
            'batang' => $batang,
            'maks' => max(1, $batang->max()),
        ]);
    }
}
