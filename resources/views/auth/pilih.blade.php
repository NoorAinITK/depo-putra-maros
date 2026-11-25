@extends('layouts.app')
@section('title', 'Selamat Datang')

@section('content')
<div class="auth">
    <div class="logo-circle">🍶</div>
    <h1>{{ config('depo.nama') }}</h1>
    <p>Solusi mudah untuk kebutuhan galon anda</p>

    <h2>Selamat Datang!</h2>
    <p>Masuk Untuk Melanjutkan</p>

    <a class="role-card" href="{{ route('login.form', 'admin') }}"><span class="ic">🏠</span><span>Admin &rarr;</span></a>
    <a class="role-card" href="{{ route('login.form', 'user') }}"><span class="ic">👤</span><span>Pengguna &rarr;</span></a>

    <p class="muted" style="margin-top:50px">✔ Aman dan terlindungi</p>
</div>
@endsection
