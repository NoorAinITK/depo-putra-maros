<div class="card order">
    <div class="icon">💧</div>
    <div class="info">
        <strong>Isi Ulang - {{ $order->customer_name }}</strong>
        <small>{{ $order->created_at->translatedFormat('d M Y H:i') }} &middot; {{ $order->qty }} Galon</small>
        @if($order->scheduled_at && $order->source === 'online')
            <br><small>Jadwal: {{ $order->scheduled_at->translatedFormat('d M Y H:i') }} ({{ ucfirst($order->service_method) }})</small>
        @endif
    </div>
    <div class="amount">
        <b>Rp {{ number_format($order->total, 0, ',', '.') }}</b>
        <span class="badge {{ $order->payment_status }}">{{ ucfirst($order->payment_status) }}</span>
    </div>
</div>
