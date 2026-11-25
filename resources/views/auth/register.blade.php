@extends('layouts.app')
@section('title', 'Daftar Pengguna')

@section('content')
<div class="auth" style="padding-top:20px">
    <p style="text-align:left;margin:0"><a href="{{ route('login.form', 'user') }}" style="font-size:28px">&larr;</a></p>
    <h1 style="color:#2a2160;font-size:30px">Daftar sebagai<br>Pengguna</h1>
    <p>Buat akun untuk memesan galon</p>

    <form method="POST" action="{{ route('register.store') }}" style="margin-top:14px">
        @csrf
        <div class="stack">
            <input class="input" name="name" value="{{ old('name') }}" placeholder="👤 Nama Lengkap" required>
            <input class="input" name="phone" value="{{ old('phone') }}" placeholder="📞 Nomor Telepon" required>
            <input class="input" name="address" value="{{ old('address') }}" placeholder="📍 Alamat Lengkap" required>
            <input class="input" type="email" name="email" value="{{ old('email') }}" placeholder="✉ Email Aktif" required>
            <input class="input" type="date" name="birth_date" value="{{ old('birth_date') }}" title="Tanggal Lahir" required>
            <select class="input" name="gender" required>
                <option value="">⚥ Jenis Kelamin</option>
                <option value="Laki-laki" @selected(old('gender') === 'Laki-laki')>Laki-laki</option>
                <option value="Perempuan" @selected(old('gender') === 'Perempuan')>Perempuan</option>
            </select>
            <input class="input" type="password" name="password" placeholder="🔒 Kata sandi (min. 6 karakter)" required>
            <input class="input" type="password" name="password_confirmation" placeholder="🔒 Konfirmasi kata sandi" required>
        </div>
        <button class="btn primary" style="margin-top:14px">Daftar</button>
    </form>

    <p style="margin-top:20px">Sudah punya akun? <a class="link" href="{{ route('login.form', 'user') }}">Masuk disini</a></p>
</div>
@endsection
