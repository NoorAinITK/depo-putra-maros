<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Satu tabel "orders" dipakai untuk dua sumber transaksi:
//  - source = kasir  -> dibuat admin lewat menu "Transaksi Baru"
//  - source = online -> dibuat pengguna lewat "Pesan Sekarang" / "Pesan Terjadwal"
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('customer_name');
            $table->enum('source', ['kasir', 'online'])->default('kasir');
            $table->enum('order_type', ['langsung', 'terjadwal'])->default('langsung');
            $table->unsignedInteger('qty')->default(1);
            $table->unsignedInteger('price')->default(5000);
            $table->unsignedInteger('total');
            $table->enum('service_method', ['pickup', 'delivery'])->default('pickup');
            $table->enum('payment_method', ['qris', 'cash'])->default('cash');
            $table->enum('payment_status', ['lunas', 'belum'])->default('belum');
            // alur galon di halaman Stok Galon
            $table->enum('process_status', ['menunggu', 'diproses', 'terisi', 'selesai'])->default('menunggu');
            $table->dateTime('scheduled_at')->nullable(); // jam ambil / jadwal pesanan
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
