@extends('layouts.app')
@section('title', 'Edit Profil')
@section('heading', 'PROFIL')
@section('back', route('profil.show'))

@section('content')
<form method="POST" action="{{ route('profil.update') }}" enctype="multipart/form-data">
    @csrf @method('PUT')

    <label class="lbl">Ganti Foto</label>
    <input class="input" type="file" name="photo" accept="image/*">

    <label class="lbl">NAMA LENGKAP</label>
    <input class="input" name="name" value="{{ old('name', $user->name) }}" required>

    <label class="lbl">NOMOR TELEPON</label>
    <input class="input" name="phone" value="{{ old('phone', $user->phone) }}" required>

    <label class="lbl">ALAMAT</label>
    <input class="input" name="address" value="{{ old('address', $user->address) }}" required>

    <label class="lbl">EMAIL</label>
    <input class="input" type="email" name="email" value="{{ old('email', $user->email) }}" required>

    @if($user->role === 'user')
        <label class="lbl">TANGGAL LAHIR</label>
        <input class="input" type="date" name="birth_date" value="{{ old('birth_date', $user->birth_date?->toDateString()) }}">

        <label class="lbl">JENIS KELAMIN</label>
        <select class="input" name="gender">
            <option value="">-</option>
            @foreach(['Laki-laki', 'Perempuan'] as $g)
                <option value="{{ $g }}" @selected(old('gender', $user->gender) === $g)>{{ $g }}</option>
            @endforeach
        </select>
    @endif

    <button class="btn primary" style="margin-top:24px">SIMPAN</button>
</form>
@endsection
