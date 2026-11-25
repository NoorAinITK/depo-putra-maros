@extends('layouts.app')
@section('title', 'Edit Pengeluaran')
@section('heading', 'EDIT PENGELUARAN')
@section('back', route('admin.pengeluaran.index'))

@section('content')
<form method="POST" action="{{ route('admin.pengeluaran.update', $expense) }}" class="stack">
    @csrf @method('PUT')
    <input class="input" name="description" value="{{ old('description', $expense->description) }}" required>
    <input class="input" type="number" name="amount" min="1" value="{{ old('amount', $expense->amount) }}" required>
    <input class="input" type="date" name="spent_at" value="{{ old('spent_at', $expense->spent_at->toDateString()) }}" required>
    <button class="btn">SIMPAN PERUBAHAN</button>
    <a class="btn gray" href="{{ route('admin.pengeluaran.index') }}">BATALKAN</a>
</form>
@endsection
