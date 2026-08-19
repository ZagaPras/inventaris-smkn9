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
    Schema::create('barangs', function (Blueprint $table) {
        $table->id();
        $table->foreignId('ruangan_id')->constrained('ruangans')->onDelete('cascade');
        $table->string('nama_barang');
        $table->string('kode_barang')->unique();
        $table->integer('jumlah');
        $table->enum('kondisi', ['Baik', 'Rusak Ringan', 'Rusak Berat']);
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barangs');
    }
};
