// JS kecil: tombol +/- jumlah galon, total otomatis, dan tampil/sembunyi QR saat memilih QRIS.
document.addEventListener('DOMContentLoaded', () => {
    const qty = document.getElementById('qty');
    const total = document.getElementById('total');
    const qr = document.getElementById('qr');

    const hitung = () => {
        if (!qty || !total) return;
        const harga = parseInt(total.dataset.price) || 0;
        const jumlah = Math.max(1, parseInt(qty.value) || 1);
        total.textContent = 'Rp ' + (harga * jumlah).toLocaleString('id-ID');
    };

    window.ubah = (n) => {
        qty.value = Math.min(100, Math.max(1, (parseInt(qty.value) || 1) + n));
        hitung();
    };

    const toggleQr = () => {
        if (!qr) return;
        const pilih = document.querySelector('input[name=payment_method]:checked');
        qr.style.display = pilih && pilih.value === 'qris' ? 'block' : 'none';
    };

    if (qty) qty.addEventListener('input', hitung);
    document.querySelectorAll('input[name=payment_method]').forEach(r => r.addEventListener('change', toggleQr));
    hitung();
    toggleQr();
});
