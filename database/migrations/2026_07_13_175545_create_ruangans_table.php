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
    Schema::create('ruangans', function (Blueprint $table) {
        $table->id();
        $table->string('kode_ruangan');
        $table->string('nama_ruangan');
        
        // 4 Kolom Dimensi Baru
        $table->string('panjang')->nullable();
        $table->string('lebar')->nullable();
        $table->string('tinggi')->nullable();
        $table->string('luas')->nullable();
        
        $table->string('foto_depan');
        $table->string('foto_belakang');
        $table->string('foto_kiri');
        $table->string('foto_kanan');
        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ruangans');
    }
};
