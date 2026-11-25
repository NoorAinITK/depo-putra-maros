@extends('layouts.app')
@section('title', $role === 'admin' ? 'Login Admin' : 'Login Pengguna')

@section('content')
<div class="auth">
    <p style="text-align:left;margin:0"><a href="{{ route('home') }}" style="font-size:28px">&larr;</a></p>
    <div style="font-size:80px;margin-top:20px">{{ $role === 'admin' ? '🏠' : '👤' }}</div>
    <h1 style="font-size:28px;margin-top:14px">{{ $role === 'admin' ? 'Admin' : 'Pengguna' }}</h1>
    <p>{{ $role === 'admin' ? 'Masuk untuk mengelola toko anda' : 'Masuk untuk memesan galon' }}</p>

    <form method="POST" action="{{ route('login.attempt', $role) }}">
        @csrf
        <input class="input" type="text" name="identifier" value="{{ old('identifier') }}" placeholder="✉ Email atau nomor hp" required autofocus>
        <div style="height:14px"></div>
        <input class="input" type="password" name="password" placeholder="🔒 Kata sandi" required>
        <div style="height:26px"></div>
        <button class="btn primary">Masuk</button>
    </form>

    @if($role === 'user')
        <p style="margin-top:36px">Belum punya akun?</p>
        <a class="btn outline" style="border-radius:16px;border-color:var(--blue);padding:15px" href="{{ route('register') }}">Daftar Sebagai Pengguna</a>
    @endif
</div>
@endsection
