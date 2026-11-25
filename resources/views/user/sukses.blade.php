@extends('layouts.app')
@section('title', 'Pemesanan Berhasil')

@section('content')
<div class="success-page">
    <div style="display:flex;flex-direction:column;align-items:center">
        <div class="check">✓</div>
        <h2 style="font-size:24px;margin-top:40px">Pemesanan Berhasil!</h2>
    </div>
    <div style="width:100%">
        <p>Kembali ke Halaman untuk memesan galon</p>
        <a class="btn primary" href="{{ route('user.beranda') }}">Kembali</a>
    </div>
</div>
@endsection
