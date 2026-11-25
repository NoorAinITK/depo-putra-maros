<div class="qr-box" id="qr">
    @if(file_exists(public_path('images/qris.png')))
        <img src="{{ asset('images/qris.png') }}" alt="QRIS">
    @else
        <div class="qr-placeholder">[QR CODE]<small>Taruh gambar QRIS di public/images/qris.png</small></div>
    @endif
</div>
