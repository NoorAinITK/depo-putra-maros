@extends('layouts.app')
@section('title', 'Pembayaran')
@section('heading', 'PEMBAYARAN')
@section('back', route('user.pesan', $draft['mode']))

@section('content')
<div class="summary-box">
    <div class="row" style="font-size:13px">RINGKASAN</div>
    <div class="row"><span>Isi Ulang x{{ $draft['qty'] }}</span><span>Rp {{ number_format($total, 0, ',', '.') }}</span></div>
    <div class="row"><span>Jadwal ({{ ucfirst($draft['service_method']) }})</span><span>{{ $jadwal->translatedFormat('d M Y H:i') }}</span></div>
    <div class="row t"><span>TOTAL</span><span>Rp {{ number_format($total, 0, ',', '.') }}</span></div>
</div>

<form method="POST" action="{{ route('user.bayar') }}">
    @csrf
    <h3 class="section">PILIH METODE</h3>
    <label class="pay"><span>QRIS</span><input type="radio" name="payment_method" value="qris" checked></label>
    <label class="pay"><span>CASH</span><input type="radio" name="payment_method" value="cash"></label>

    @include('partials.qr')

    <button class="btn primary">KONFIRMASI &amp; BAYAR</button>
</form>
@endsection
