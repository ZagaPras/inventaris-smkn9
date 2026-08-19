<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;

class BarangImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        if ($rows->isEmpty()) {
            return;
        }

        $headerFound = false;
        $colRuangan    = 0;
        $colBarang     = 1;
        $colMerk       = 2;
        $colSpesifikasi = 3;
        $colKondisi    = 4;
        $colJumlah     = 5;
        $colKeterangan = 6;

        $lastNamaRuang = 'Tanpa Ruangan';

        foreach ($rows as $row) {
            $cells = [];
            foreach ($row as $key => $val) {
                $cells[$key] = trim((string)$val);
            }

            if (empty(array_filter($cells))) {
                continue;
            }

            if (!$headerFound) {
                $rowTextUpper = strtoupper(implode(' ', $cells));

                if (str_contains($rowTextUpper, 'RUANG') && str_contains($rowTextUpper, 'BARANG')) {
                    $headerFound = true;
                    foreach ($cells as $colIdx => $cellText) {
                        $txt = strtoupper($cellText);
                        if (str_contains($txt, 'RUANG')) {
                            $colRuangan = $colIdx;
                        } elseif (str_contains($txt, 'BARANG') && !str_contains($txt, 'KONDISI') && !str_contains($txt, 'JUMLAH')) {
                            $colBarang = $colIdx;
                        } elseif (str_contains($txt, 'MEREK') || str_contains($txt, 'MERK')) {
                            $colMerk = $colIdx;
                        } elseif (str_contains($txt, 'SPESIFIKASI') || str_contains($txt, 'SPEK')) {
                            $colSpesifikasi = $colIdx;
                        } elseif (str_contains($txt, 'KONDISI')) {
                            $colKondisi = $colIdx;
                        } elseif (str_contains($txt, 'JUMLAH') || str_contains($txt, 'QTY')) {
                            $colJumlah = $colIdx;
                        } elseif (str_contains($txt, 'KETERANGAN') || str_contains($txt, 'KET')) {
                            $colKeterangan = $colIdx;
                        }
                    }
                    continue;
                }

                if (str_contains($rowTextUpper, 'INVENTARIS') || str_contains($rowTextUpper, 'LAPORAN') || str_contains($rowTextUpper, 'TAHUN')) {
                    continue;
                }
            }

            $namaRuangVal   = isset($cells[$colRuangan]) ? $cells[$colRuangan] : '';
            $namaBarangVal  = isset($cells[$colBarang]) ? $cells[$colBarang] : '';
            $merkVal        = isset($cells[$colMerk]) ? $cells[$colMerk] : '';
            $spesifikasiVal = isset($cells[$colSpesifikasi]) ? $cells[$colSpesifikasi] : '';
            $kondisiVal     = isset($cells[$colKondisi]) ? $cells[$colKondisi] : '';
            $jumlahVal      = isset($cells[$colJumlah]) ? $cells[$colJumlah] : '';
            $keteranganVal  = isset($cells[$colKeterangan]) ? $cells[$colKeterangan] : '';

            if (!empty($namaRuangVal)) {
                $namaRuangUpper = strtoupper($namaRuangVal);
                if (str_contains($namaRuangUpper, 'NAMA RUANG') || str_contains($namaRuangUpper, 'INVENTARIS')) {
                    continue;
                }
                $lastNamaRuang = $namaRuangVal;
            }
            $namaRuang = $lastNamaRuang;

            if (empty($namaBarangVal)) {
                continue;
            }
            $namaBarangUpper = strtoupper($namaBarangVal);
            if (str_contains($namaBarangUpper, 'NAMA BARANG')) {
                continue;
            }

            $ruangan = DB::table('ruangans')->where('nama_ruangan', $namaRuang)->first();
            if ($ruangan) {
                $ruanganId = $ruangan->id;
            } else {
                $cleanRuang = strtoupper(preg_replace('/[^A-Z0-9]/i', '', $namaRuang));
                $baseKodeRuang = 'RNG-' . ($cleanRuang ? substr($cleanRuang, 0, 10) : rand(100, 999));
                $kodeRuangan = $baseKodeRuang;
                $counter = 1;
                while (DB::table('ruangans')->where('kode_ruangan', $kodeRuangan)->exists()) {
                    $kodeRuangan = $baseKodeRuang . '-' . $counter;
                    $counter++;
                }

                $ruanganId = DB::table('ruangans')->insertGetId([
                    'kode_ruangan'  => $kodeRuangan,
                    'nama_ruangan'  => substr($namaRuang, 0, 100),
                    'panjang'       => null,
                    'lebar'         => null,
                    'tinggi'        => null,
                    'luas'          => null,
                    'foto_depan'    => '',
                    'foto_belakang' => '',
                    'foto_kiri'     => '',
                    'foto_kanan'    => '',
                    'created_at'    => now(),
                    'updated_at'    => now(),
                ]);
            }

            $merk = ($merkVal === '-' || empty($merkVal)) ? null : substr($merkVal, 0, 100);

            $spesifikasi = ($spesifikasiVal === '-' || empty($spesifikasiVal)) ? 'Tidak ada spesifikasi' : $spesifikasiVal;
            if (strlen($spesifikasi) > 250) {
                $spesifikasi = substr($spesifikasi, 0, 245) . '...';
            }

            $keterangan = ($keteranganVal === '-' || empty($keteranganVal)) ? null : $keteranganVal;
            if ($keterangan && strlen($keterangan) > 250) {
                $keterangan = substr($keterangan, 0, 245) . '...';
            }

            $kondisiLower = strtolower($kondisiVal);
            if (str_contains($kondisiLower, 'berat') || str_contains($kondisiLower, 'parah')) {
                $kondisi = 'Rusak Berat';
            } elseif (str_contains($kondisiLower, 'ringan') || str_contains($kondisiLower, 'sedang') || str_contains($kondisiLower, 'rusak')) {
                $kondisi = 'Rusak Ringan';
            } else {
                $kondisi = 'Baik';
            }

            $jumlah = (is_numeric($jumlahVal) && (int)$jumlahVal > 0) ? (int)$jumlahVal : 1;

            $queryCheck = DB::table('barangs')
                ->where('nama_barang', substr($namaBarangVal, 0, 100))
                ->where('ruangan_id', $ruanganId);

            if ($merk !== null) {
                $queryCheck->where('merk', $merk);
            } else {
                $queryCheck->whereNull('merk');
            }

            $existingBarang = $queryCheck->first();

            $payload = [
                'merk'        => $merk,
                'spesifikasi' => $spesifikasi,
                'jumlah'      => $jumlah,
                'kondisi'     => $kondisi,
                'keterangan'  => $keterangan,
                'updated_at'  => now(),
            ];

            if ($existingBarang) {
                DB::table('barangs')->where('id', $existingBarang->id)->update($payload);
            } else {
                $cleanBarang = strtoupper(substr(preg_replace('/[^A-Z0-9]/i', '', $namaBarangVal), 0, 4));
                $baseKodeBarang = 'BRG-' . ($cleanBarang ?: 'ITEM') . '-' . rand(1000, 9999);
                $kodeBarang = $baseKodeBarang;
                while (DB::table('barangs')->where('kode_barang', $kodeBarang)->exists()) {
                    $kodeBarang = 'BRG-' . ($cleanBarang ?: 'ITEM') . '-' . rand(1000, 9999);
                }

                $payload['ruangan_id']  = $ruanganId;
                $payload['nama_barang'] = substr($namaBarangVal, 0, 100);
                $payload['kode_barang'] = $kodeBarang;
                $payload['created_at']  = now();

                DB::table('barangs')->insert($payload);
            }
        }
    }
}