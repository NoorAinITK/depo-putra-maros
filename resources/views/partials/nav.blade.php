<nav class="bottom-nav">
    @if(auth()->user()->role === 'admin')
        <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">🏠<span>Beranda</span></a>
        <a href="{{ route('admin.transaksi.index') }}" class="{{ request()->routeIs('admin.transaksi.*') ? 'active' : '' }}">💲<span>Transaksi</span></a>
        <a href="{{ route('admin.laporan') }}" class="{{ request()->routeIs('admin.laporan', 'admin.pengeluaran.*') ? 'active' : '' }}">📋<span>Laporan</span></a>
        <a href="{{ route('admin.stok') }}" class="{{ request()->routeIs('admin.stok') ? 'active' : '' }}">🍶<span>Stok</span></a>
        <a href="{{ route('profil.show') }}" class="{{ request()->routeIs('profil.*') ? 'active' : '' }}">👤<span>Profil</span></a>
    @else
        <a href="{{ route('user.beranda') }}" class="{{ request()->routeIs('user.beranda', 'user.pesan*', 'user.pembayaran', 'user.sukses') ? 'active' : '' }}">🏠<span>Beranda</span></a>
        <a href="{{ route('user.riwayat') }}" class="{{ request()->routeIs('user.riwayat') ? 'active' : '' }}">📋<span>Riwayat</span></a>
        <a href="{{ route('profil.show') }}" class="{{ request()->routeIs('profil.*') ? 'active' : '' }}">👤<span>Profil</span></a>
    @endif
</nav>
