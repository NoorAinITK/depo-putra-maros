@extends('layouts.app')
@section('title', 'Riwayat Transaksi')
@section('heading', 'TRANSAKSI')
@section('back', route('admin.dashboard'))

@section('content')
<div class="tabs">
    <a href="{{ route('admin.transaksi.create') }}">Transaksi Baru</a>
    <a class="on" href="{{ route('admin.transaksi.index') }}">Riwayat Transaksi</a>
</div>

<h3 class="section">Riwayat Kasir</h3>
@include('admin.transaksi._list', ['orders' => $kasir])

<h3 class="section">Riwayat Online</h3>
@include('admin.transaksi._list', ['orders' => $online])
@endsection
