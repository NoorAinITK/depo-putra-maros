@extends('layouts.app')
@section('title', 'Riwayat Transaksi')
@section('heading', 'RIWAYAT TRANSAKSI')

@section('content')
@forelse($orders as $order)
    <div class="order-wrap">
        @include('partials.order-card', ['order' => $order])
        <div class="actions">
            <span class="badge {{ $order->process_status }}">{{ ucfirst($order->process_status) }}</span>
            @if($order->process_status === 'menunggu')
                <form method="POST" action="{{ route('user.batal', $order) }}" onsubmit="return confirm('Batalkan pesanan ini?')">
                    @csrf @method('DELETE')
                    <button class="btn-sm danger">Batalkan</button>
                </form>
            @endif
        </div>
    </div>
@empty
    <p class="muted">Belum ada riwayat pesanan.</p>
@endforelse
@endsection
