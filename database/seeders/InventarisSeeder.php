<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InventarisSeeder extends Seeder
{
    public function run(): void
    {
        // Data Ruangan
        $ruanganId1 = DB::table('ruangans')->insertGetId([
            'kode_ruangan' => 'LAB-01',
            'nama_ruangan' => 'Laboratorium Komputer 1',
            'created_at' => now(), 'updated_at' => now()
        ]);

        $ruanganId2 = DB::table('ruangans')->insertGetId([
            'kode_ruangan' => 'TEORI-01',
            'nama_ruangan' => 'Ruang Teori Otomotif',
            'created_at' => now(), 'updated_at' => now()
        ]);

        // Data Barang di Lab Komputer
        DB::table('barangs')->insert([
            [
                'ruangan_id' => $ruanganId1,
                'nama_barang' => 'Komputer PC i5',
                'kode_barang' => 'PC-001',
                'jumlah' => 20,
                'kondisi' => 'Baik',
                'created_at' => now(), 'updated_at' => now()
            ],
            [
                'ruangan_id' => $ruanganId1,
                'nama_barang' => 'AC Split 2 PK',
                'kode_barang' => 'AC-01',
                'jumlah' => 2,
                'kondisi' => 'Baik',
                'created_at' => now(), 'updated_at' => now()
            ]
        ]);

        // Data Barang di Ruang Teori
        DB::table('barangs')->insert([
            [
                'ruangan_id' => $ruanganId2,
                'nama_barang' => 'Proyektor Epson',
                'kode_barang' => 'PRJ-01',
                'jumlah' => 1,
                'kondisi' => 'Rusak Ringan',
                'created_at' => now(), 'updated_at' => now()
            ]
        ]);
    }
}