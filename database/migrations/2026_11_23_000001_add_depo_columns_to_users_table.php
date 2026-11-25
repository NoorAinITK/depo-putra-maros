<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Menambah kolom yang dibutuhkan form "Daftar sebagai Pengguna" & halaman Profil
// ke tabel users bawaan Laravel (yang sudah punya name, email, password).
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone', 20)->nullable()->unique()->after('email');
            $table->text('address')->nullable()->after('phone');
            $table->date('birth_date')->nullable()->after('address');
            $table->enum('gender', ['Laki-laki', 'Perempuan'])->nullable()->after('birth_date');
            $table->enum('role', ['admin', 'user'])->default('user')->after('gender');
            $table->string('photo')->nullable()->after('role');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['phone', 'address', 'birth_date', 'gender', 'role', 'photo']);
        });
    }
};
