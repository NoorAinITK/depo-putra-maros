@extends('layouts.app')
@section('title', 'Edit Transaksi')
@section('heading', 'EDIT TRANSAKSI')
@section('back', route('admin.transaksi.index'))

@section('content')
<form method="POST" action="{{ route('admin.transaksi.update', $order) }}">
    @csrf @method('PUT')

    <label class="lbl">Nama Pemesan</label>
    <input class="input" name="customer_name" value="{{ old('customer_name', $order->customer_name) }}" required>

    <label class="lbl">Jumlah Galon</label>
    <input class="input" type="number" name="qty" min="1" max="100" value="{{ old('qty', $order->qty) }}" required>

    <label class="lbl">Layanan</label>
    <select class="input" name="service_method">
        @foreach(['pickup' => 'Pick Up', 'delivery' => 'Delivery'] as $v => $t)
            <option value="{{ $v }}" @selected(old('service_method', $order->service_method) === $v)>{{ $t }}</option>
        @endforeach
    </select>

    <label class="lbl">Metode Bayar</label>
    <select class="input" name="payment_method">
        @foreach(['qris' => 'QRIS', 'cash' => 'CASH'] as $v => $t)
            <option value="{{ $v }}" @selected(old('payment_method', $order->payment_method) === $v)>{{ $t }}</option>
        @endforeach
    </select>

    <label class="lbl">Status Pembayaran</label>
    <select class="input" name="payment_status">
        @foreach(['lunas' => 'Lunas', 'belum' => 'Belum Lunas'] as $v => $t)
            <option value="{{ $v }}" @selected(old('payment_status', $order->payment_status) === $v)>{{ $t }}</option>
        @endforeach
    </select>

    <label class="lbl">Status Galon</label>
    <select class="input" name="process_status">
        @foreach(['menunggu' => 'Menunggu', 'diproses' => 'Diproses', 'terisi' => 'Sudah Terisi', 'selesai' => 'Selesai'] as $v => $t)
            <option value="{{ $v }}" @selected(old('process_status', $order->process_status) === $v)>{{ $t }}</option>
        @endforeach
    </select>

    <div class="stack" style="margin-top:22px">
        <button class="btn">SIMPAN PERUBAHAN</button>
        <a class="btn gray" href="{{ route('admin.transaksi.index') }}">BATALKAN</a>
    </div>
</form>
@endsection
