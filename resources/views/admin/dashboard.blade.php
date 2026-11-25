@extends('layouts.app')
@section('title', 'Beranda Admin')
@section('heading', config('depo.nama'))

@section('content')
<div class="summary">
    <div><small>PEMASUKAN</small><strong>Rp {{ number_format($pemasukan, 0, ',', '.') }}</strong></div>
    <div class="right"><small>TRANSAKSI</small><strong>{{ $jumlah }}</strong></div>
</div>

<h3 class="section">MENU UTAMA</h3>
<a class="menu-big" href="{{ route('admin.transaksi.create') }}"><span class="ic">💱</span><span>Transaksi Baru</span></a>
<div class="menu-grid">
    <a href="{{ route('admin.laporan') }}"><span class="ic">📋</span>Laporan</a>
    <a href="{{ route('admin.stok') }}"><span class="ic">🍶</span>Stok Galon</a>
</div>

<h3 class="section">TRANSAKSI TERAKHIR</h3>
@forelse($terakhir as $order)
    @include('partials.order-card', ['order' => $order])
@empty
    <p class="muted">Belum ada transaksi.</p>
@endforelse
@endsection
