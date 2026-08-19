<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('barangs', function (Blueprint $table) {
            // 1. Tambah kolom merk tipe string, opsional (nullable), diletakkan setelah nama_barang
            $table->string('merk')->nullable()->after('nama_barang');

            // 2. Tambah kolom spesifikasi tipe text, wajib (tidak nullable), diletakkan setelah merk
            $table->text('spesifikasi')->after('merk');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('barangs', function (Blueprint $table) {
            // Menghapus kembali kolom jika migration dibatalkan (rollback)
            $table->dropColumn(['merk', 'spesifikasi']);
        });
    }
};