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
        Schema::create('keluhans', function (Blueprint $table) {
            $table->id();
            
            // Kolom ini yang sebelumnya hilang (wajib ditambahkan)
            $table->unsignedBigInteger('user_id'); 
            
            $table->string('pelapor_nama');
            $table->string('pelapor_status');
            $table->unsignedBigInteger('ruangan_id');
            $table->unsignedBigInteger('barang_id');
            $table->text('deskripsi');
            
            // Status bertingkat: Menunggu (Baru), Diproses (Sedang dikerjakan), Selesai
            $table->enum('status', ['Menunggu', 'Diproses', 'Selesai'])->default('Menunggu');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Diperbaiki: Harus sesuai dengan nama tabel di fungsi up()
        Schema::dropIfExists('keluhans');
    }
};