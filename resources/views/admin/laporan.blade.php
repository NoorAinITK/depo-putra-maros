@extends('layouts.app')
@section('title', 'Laporan Keuangan')
@section('heading', 'LAPORAN KEUANGAN')
@section('back', route('admin.dashboard'))

@section('content')
@php $rp = fn ($n) => 'Rp ' . number_format($n, 0, ',', '.'); @endphp

<div class="tabs">
    <a class="{{ $periode === 'mingguan' ? 'on' : '' }}" href="{{ route('admin.laporan', ['periode' => 'mingguan']) }}">Mingguan</a>
    <a class="{{ $periode === 'bulanan' ? 'on' : '' }}" href="{{ route('admin.laporan', ['periode' => 'bulanan']) }}">Bulanan</a>
</div>

<div class="stat-grid" style="margin-top:20px">
    <div class="stat-box"><small>Pemasukan</small><strong>{{ $rp($pemasukan) }}</strong></div>
    <div class="stat-box"><small>Transaksi</small><strong>{{ $jumlah }}</strong></div>
</div>

<h3 class="section">{{ $periode === 'bulanan' ? 'GRAFIK BULAN INI (PER MINGGU)' : 'GRAFIK MINGGU INI' }}</h3>
<div class="chart">
    @foreach($batang as $i => $nilai)
        <div class="col" title="{{ $rp($nilai) }}">
            <div class="bar" style="height: {{ round($nilai / $maks * 90) }}%"></div>
            <small>{{ $label[$i] }}</small>
        </div>
    @endforeach
</div>

<h3 class="section">{{ $periode === 'bulanan' ? 'RINCIAN BULAN INI' : 'RINCIAN MINGGU INI' }}</h3>
<div class="detail">
    <div class="row"><span>Isi Ulang ({{ $jumlah }} trx)</span><span>{{ $rp($pemasukan) }}</span></div>
    <div class="row"><span>Pengeluaran</span><span>{{ $rp($pengeluaran) }}</span></div>
</div>
<div class="profit"><span>Keuntungan</span><span>{{ $rp($keuntungan) }}</span></div>

<a class="btn" style="margin-top:10px" href="{{ route('admin.pengeluaran.index') }}">Kelola Pengeluaran</a>
@endsection
