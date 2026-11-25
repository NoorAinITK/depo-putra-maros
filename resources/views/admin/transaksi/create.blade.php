@extends('layouts.app')
@section('title', 'Transaksi Baru')
@section('heading', 'TRANSAKSI')
@section('back', route('admin.dashboard'))

@section('content')
<div class="tabs">
    <a class="on" href="{{ route('admin.transaksi.create') }}">Transaksi Baru</a>
    <a href="{{ route('admin.transaksi.index') }}">Riwayat Transaksi</a>
</div>

<form method="POST" action="{{ route('admin.transaksi.store') }}">
    @csrf

    <h3 class="section">PILIH PRODUK</h3>
    <div class="product">
        <div><b>Isi Ulang Air Galon</b><b>Rp {{ number_format(config('depo.harga_galon'), 0, ',', '.') }}</b></div>
        <div class="stepper">
            <button type="button" onclick="ubah(-1)">−</button>
            <input id="qty" name="qty" type="number" min="1" max="100" value="{{ old('qty', 1) }}">
            <button type="button" onclick="ubah(1)">+</button>
        </div>
    </div>

    <h3 class="section">DETAIL PESANAN</h3>
    <div class="card" style="display:flex;justify-content:space-between;align-items:center;gap:10px;border:1px solid #333">
        <input class="input" style="background:#fff;flex:1" name="customer_name" value="{{ old('customer_name') }}" placeholder="👤 Nama Pemesan" required>
        <div class="choice" style="flex-direction:column;gap:6px">
            <label><input type="radio" name="service_method" value="pickup" @checked(old('service_method', 'pickup') === 'pickup')> Pick Up</label>
            <label><input type="radio" name="service_method" value="delivery" @checked(old('service_method') === 'delivery')> Delivery</label>
        </div>
    </div>

    <h3 class="section">PILIH METODE</h3>
    <label class="pay"><span>QRIS</span><input type="radio" name="payment_method" value="qris" @checked(old('payment_method', 'qris') === 'qris')></label>
    <label class="pay"><span>CASH</span><input type="radio" name="payment_method" value="cash" @checked(old('payment_method') === 'cash')></label>

    @include('partials.qr')

    <div class="total"><span>TOTAL</span><span id="total" data-price="{{ config('depo.harga_galon') }}">Rp {{ number_format(config('depo.harga_galon'), 0, ',', '.') }}</span></div>

    <div class="stack" style="margin-top:16px">
        <button class="btn">SIMPAN TRANSAKSI</button>
        <a class="btn gray" href="{{ route('admin.dashboard') }}">BATALKAN</a>
    </div>
</form>
@endsection
