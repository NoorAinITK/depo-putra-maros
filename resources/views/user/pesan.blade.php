@extends('layouts.app')
@section('title', $mode === 'sekarang' ? 'Pesan Galon Sekarang' : 'Pilih Jadwal')
@section('heading', $mode === 'sekarang' ? 'Pesan Galon Sekarang' : 'PILIH JADWAL')
@section('back', route('user.beranda'))

@section('content')
<form method="POST" action="{{ route('user.pesan.lanjut', $mode) }}">
    @csrf

    @if($mode === 'sekarang')
        <div class="card" style="display:flex;gap:14px;align-items:center">
            <span style="font-size:30px">💧</span>
            <div>
                <b style="font-size:14px">{{ config('depo.nama') }}</b><br>
                <small class="muted">Buka {{ config('depo.jam_buka') }}<br>{{ config('depo.alamat') }}</small>
            </div>
        </div>
    @endif

    <h3 class="section">{{ $mode === 'sekarang' ? 'PILIH PRODUK' : 'METODE LAYANAN' }}</h3>

    @if($mode === 'terjadwal')
        @include('user._layanan')
        <h3 class="section">PILIH PRODUK</h3>
    @endif

    <div class="product">
        <div><b>Isi Ulang Air Galon</b><b>Rp {{ number_format(config('depo.harga_galon'), 0, ',', '.') }}</b></div>
        <div class="stepper">
            <button type="button" onclick="ubah(-1)">−</button>
            <input id="qty" name="qty" type="number" min="1" max="100" value="{{ old('qty', 1) }}">
            <button type="button" onclick="ubah(1)">+</button>
        </div>
    </div>

    @if($mode === 'sekarang')
        <h3 class="section">METODE LAYANAN</h3>
        @include('user._layanan')

        <div class="stack" style="margin-top:16px">
            <input class="input" name="customer_name" value="{{ old('customer_name', auth()->user()->name) }}" placeholder="👤 Nama Pemesan" required>
            <input class="input" type="time" name="pickup_time" value="{{ old('pickup_time') }}" min="08:00" max="17:00" required title="Jam Pengambilan">
            <small class="muted">Jam pengambilan: {{ config('depo.jam_buka') }}</small>
        </div>
    @else
        <h3 class="section">PILIH TANGGAL</h3>
        <input class="input" type="date" name="date" min="{{ today()->toDateString() }}" value="{{ old('date') }}" required>

        <h3 class="section">SLOT WAKTU</h3>
        <select class="input" name="slot" required>
            <option value="">Pilih jam</option>
            @foreach($slots as $s)
                <option value="{{ $s }}" @selected(old('slot') === $s)>{{ $s }} WITA</option>
            @endforeach
        </select>
    @endif

    @php $harga = config('depo.harga_galon'); @endphp
    <div class="total"><span>TOTAL</span><span id="total" data-price="{{ $harga }}">Rp {{ number_format($harga, 0, ',', '.') }}</span></div>
    <small class="muted">Delivery dikirim ke alamat di profil Anda.</small>

    <button class="btn" style="margin-top:14px">LANJUT PEMBAYARAN</button>
</form>
@endsection
