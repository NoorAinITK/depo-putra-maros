@extends('layouts.app')
@section('title', 'Beranda')
@section('heading', 'Beranda')

@section('content')
<h2 style="font-size:28px;margin:30px 0 6px">Halo, {{ \Illuminate\Support\Str::before($user->name, ' ') }}</h2>
<p style="font-weight:700;margin:0 0 30px">Mau pesan galon sekarang atau nanti?</p>

<a class="menu-big" style="border:1px solid #000;box-shadow:0 3px 4px rgba(0,0,0,.25)" href="{{ route('user.pesan', 'sekarang') }}">
    <span class="ic">⚡</span><span style="flex:1">Pesan Sekarang</span><span>&rarr;</span>
</a>
<a class="menu-big" style="border:1px solid #000;box-shadow:0 3px 4px rgba(0,0,0,.25)" href="{{ route('user.pesan', 'terjadwal') }}">
    <span class="ic">📅</span><span style="flex:1">Pesan Terjadwal</span><span>&rarr;</span>
</a>

<div class="card" style="margin-top:60px;border:1px solid #000;display:flex;align-items:center;gap:16px;font-weight:700;font-size:14px">
    <span style="font-size:28px">💧</span> Air Berkualitas, Hidup Berkualitas
</div>
@endsection
