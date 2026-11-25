<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\User\PesanController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Halaman awal & autentikasi (Selamat Datang -> Admin / Pengguna)
|--------------------------------------------------------------------------
*/
Route::get('/', [AuthController::class, 'pilihPeran'])->name('home');
Route::get('/login', fn () => redirect()->route('home'))->name('login'); // tujuan redirect bila belum login

Route::middleware('guest')->group(function () {
    Route::get('/login/{role}', [AuthController::class, 'formLogin'])->where('role', 'admin|user')->name('login.form');
    Route::post('/login/{role}', [AuthController::class, 'login'])->where('role', 'admin|user')->name('login.attempt');
    Route::get('/daftar', [AuthController::class, 'formDaftar'])->name('register');
    Route::post('/daftar', [AuthController::class, 'daftar'])->name('register.store');
});

Route::middleware('auth')->group(function () {
    Route::post('/keluar', [AuthController::class, 'logout'])->name('logout');

    // Profil dipakai bersama admin & pengguna
    Route::get('/profil', [ProfilController::class, 'show'])->name('profil.show');
    Route::get('/profil/edit', [ProfilController::class, 'edit'])->name('profil.edit');
    Route::put('/profil', [ProfilController::class, 'update'])->name('profil.update');
});

/*
|--------------------------------------------------------------------------
| ADMIN (kasir): dashboard, transaksi (CRUD), laporan, stok galon, pengeluaran (CRUD)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/', [Admin\DashboardController::class, 'index'])->name('dashboard');

    // CRUD transaksi: index, create, store, edit, update, destroy
    Route::resource('transaksi', Admin\TransaksiController::class)
        ->parameters(['transaksi' => 'order'])
        ->except('show');

    Route::get('laporan', [Admin\LaporanController::class, 'index'])->name('laporan');

    Route::get('stok', [Admin\StokController::class, 'index'])->name('stok');
    Route::patch('stok/{order}', [Admin\StokController::class, 'update'])->name('stok.update');

    // CRUD pengeluaran (bahan hitung keuntungan)
    Route::resource('pengeluaran', Admin\PengeluaranController::class)
        ->parameters(['pengeluaran' => 'expense'])
        ->only(['index', 'store', 'edit', 'update', 'destroy']);
});

/*
|--------------------------------------------------------------------------
| PENGGUNA (pelanggan): pesan galon, bayar, riwayat
|--------------------------------------------------------------------------
*/
Route::prefix('pengguna')->name('user.')->middleware(['auth', 'role:user'])->group(function () {
    Route::get('/', [PesanController::class, 'beranda'])->name('beranda');

    Route::get('pesan/{mode}', [PesanController::class, 'create'])->where('mode', 'sekarang|terjadwal')->name('pesan');
    Route::post('pesan/{mode}', [PesanController::class, 'lanjut'])->where('mode', 'sekarang|terjadwal')->name('pesan.lanjut');

    Route::get('pembayaran', [PesanController::class, 'pembayaran'])->name('pembayaran');
    Route::post('pembayaran', [PesanController::class, 'bayar'])->name('bayar');
    Route::get('sukses', [PesanController::class, 'sukses'])->name('sukses');

    Route::get('riwayat', [PesanController::class, 'riwayat'])->name('riwayat');
    Route::delete('riwayat/{order}', [PesanController::class, 'batal'])->name('batal');
});
