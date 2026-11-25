@extends('layouts.app')
@section('title', 'Stok Galon')
@section('heading', 'STOK GALON')
@section('back', route('admin.dashboard'))

@section('content')
@php $aksi = ['menunggu' => 'Proses', 'diproses' => 'Tandai Terisi', 'terisi' => 'Selesai (Diambil)']; @endphp

<div class="stat-grid">
    <div class="stat hl"><small>Sudah Terisi</small><strong>{{ $terisi }}</strong><small>Siap Di Ambil</small></div>
    <div class="stat"><small>Antri Diisi</small><strong>{{ $diproses }}</strong><small>Sedang Diproses</small></div>
</div>
<div class="stat wide" style="text-align:left">
    <small>Galon Kosong menunggu</small>
    <strong style="text-align:center">{{ $menunggu }}</strong>
    <small style="text-align:right">Belum Diproses</small>
</div>

<h3 class="section">ANTRIAN GALON HARI INI</h3>
@forelse($antrian as $order)
    <div class="card order">
        <div class="icon">💧</div>
        <div class="info">
            <strong>Galon - {{ $order->customer_name }}</strong>
            <small>{{ $order->waktu->format('H.i') }} &middot; {{ $order->qty }} galon &middot; {{ ucfirst($order->service_method) }}</small>
        </div>
        <div class="amount">
            <span class="badge {{ $order->process_status }}">{{ ucfirst($order->process_status) }}</span>
            <form method="POST" action="{{ route('admin.stok.update', $order) }}" style="margin-top:6px">
                @csrf @method('PATCH')
                <button class="btn-sm">{{ $aksi[$order->process_status] }}</button>
            </form>
        </div>
    </div>
@empty
    <p class="muted">Tidak ada antrian galon hari ini.</p>
@endforelse

<div class="total" style="margin-top:30px"><span>Total Galon Masuk Hari Ini</span><span>{{ $total }}</span></div>
<div class="total" style="border:none"><span>SUDAH SELESAI</span><span>{{ $selesai }}</span></div>
@endsection
