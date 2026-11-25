@extends('layouts.app')
@section('title', 'Profil')
@section('heading', 'PROFIL')

@section('content')
<div style="margin:-16px -16px 0">
    <div class="profile-head">
        @if($user->photo_url)
            <img class="avatar" src="{{ $user->photo_url }}" alt="Foto profil">
        @else
            <div class="avatar">🍶</div>
        @endif
        <h2>{{ $user->name }}</h2>
    </div>

    <div class="field"><small>NOMOR TELEPON</small><span>{{ $user->phone }}</span></div>
    <div class="field"><small>ALAMAT</small><span>{{ $user->address }}</span></div>
    <div class="field"><small>EMAIL</small><span>{{ $user->email }}</span></div>
    @if($user->role === 'user')
        <div class="field"><small>TANGGAL LAHIR</small><span>{{ $user->birth_date?->translatedFormat('d F Y') ?? '-' }}</span></div>
        <div class="field"><small>JENIS KELAMIN</small><span>{{ $user->gender ?? '-' }}</span></div>
    @endif
</div>

<div class="btn-row">
    <a class="btn" style="border-radius:10px;border-color:var(--line)" href="{{ route('profil.edit') }}">Edit Profil</a>
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button class="btn outline" style="border-radius:10px">KELUAR</button>
    </form>
</div>
@endsection
