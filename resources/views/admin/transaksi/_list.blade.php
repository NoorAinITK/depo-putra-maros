@forelse($orders as $order)
    <div class="order-wrap">
        @include('partials.order-card', ['order' => $order])
        <div class="actions">
            <a class="btn-sm" href="{{ route('admin.transaksi.edit', $order) }}">Edit</a>
            <form method="POST" action="{{ route('admin.transaksi.destroy', $order) }}" onsubmit="return confirm('Hapus transaksi ini?')">
                @csrf @method('DELETE')
                <button class="btn-sm danger">Hapus</button>
            </form>
        </div>
    </div>
@empty
    <p class="muted">Belum ada data.</p>
@endforelse
