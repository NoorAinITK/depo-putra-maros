@extends('layouts.app')
@section('title', 'Pengeluaran')
@section('heading', 'PENGELUARAN')
@section('back', route('admin.laporan'))

@section('content')
<h3 class="section" style="margin-top:0">TAMBAH PENGELUARAN</h3>
<form method="POST" action="{{ route('admin.pengeluaran.store') }}" class="stack">
    @csrf
    <input class="input" name="description" value="{{ old('description') }}" placeholder="Keterangan (mis. Bayar listrik)" required>
    <input class="input" type="number" name="amount" min="1" value="{{ old('amount') }}" placeholder="Jumlah (Rp)" required>
    <input class="input" type="date" name="spent_at" value="{{ old('spent_at', today()->toDateString()) }}" required>
    <button class="btn">SIMPAN</button>
</form>

<h3 class="section">DAFTAR PENGELUARAN</h3>
@forelse($expenses as $e)
    <div class="list-row">
        <div>
            <b>{{ $e->description }}</b><br>
            <small class="muted">{{ $e->spent_at->translatedFormat('d M Y') }}</small>
        </div>
        <div class="right">
            <b>Rp {{ number_format($e->amount, 0, ',', '.') }}</b>
            <div class="actions" style="margin-top:6px">
                <a class="btn-sm" href="{{ route('admin.pengeluaran.edit', $e) }}">Edit</a>
                <form method="POST" action="{{ route('admin.pengeluaran.destroy', $e) }}" onsubmit="return confirm('Hapus pengeluaran ini?')">
                    @csrf @method('DELETE')
                    <button class="btn-sm danger">Hapus</button>
                </form>
            </div>
        </div>
    </div>
@empty
    <p class="muted">Belum ada pengeluaran.</p>
@endforelse
@endsection
