<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf; 
use App\Models\Ruangan;
use App\Models\Barang;

class RuanganController extends Controller
{
    public function index()
    {
        $ruangans = DB::table('ruangans')->get();
        return view('admin_ruangan', compact('ruangans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_ruangan'  => 'required|string|max:50',
            'nama_ruangan'  => 'required|string|max:100',
            'panjang'       => 'nullable|numeric',
            'lebar'         => 'nullable|numeric',
            'tinggi'        => 'nullable|numeric',
            'luas'          => 'nullable|numeric',
            'foto_depan'    => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'foto_belakang' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'foto_kiri'     => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'foto_kanan'    => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = [
            'kode_ruangan' => $request->kode_ruangan,
            'nama_ruangan' => $request->nama_ruangan,
            'panjang'      => $request->panjang,
            'lebar'        => $request->lebar,
            'tinggi'       => $request->tinggi,
            'luas'         => $request->luas,
            'created_at'   => now(),
            'updated_at'   => now(),
        ];

        $destinationPath = base_path('public' . DIRECTORY_SEPARATOR . 'ruangan');

        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0777, true);
        }

        $sisiFoto = ['foto_depan', 'foto_belakang', 'foto_kiri', 'foto_kanan'];
        
        foreach ($sisiFoto as $sisi) {
            if ($request->hasFile($sisi)) {
                $file = $request->file($sisi);
                $namaFile = $sisi . '_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move($destinationPath, $namaFile);
                $data[$sisi] = $namaFile;
            }
        }

        DB::table('ruangans')->insert($data);

        return redirect('/admin/ruangan')->with('success', 'Ruangan dan foto berhasil disimpan!');
    }

    public function detail($id)
    {
        $ruangan = DB::table('ruangans')->where('id', $id)->first();

        if (!$ruangan) {
            $ruangan = DB::table('ruangans')->where('kode_ruangan', $id)->first();
        }

        if (!$ruangan) {
            return redirect('/admin/ruangan')->with('error', 'Ruangan tidak ditemukan di database.');
        }

        $barangs = DB::table('barangs')
                    ->where('ruangan_id', $ruangan->id)
                    ->orderBy('kode_barang', 'asc') 
                    ->get();

        return view('detail_ruangan', compact('ruangan', 'barangs'));
    }

    public function edit($id)
    {
        $ruangan = DB::table('ruangans')->where('id', $id)->first();
        
        if (!$ruangan) {
            $ruangan = DB::table('ruangans')->where('kode_ruangan', $id)->first();
        }

        if (!$ruangan) {
            return redirect('/admin/ruangan')->with('error', 'Ruangan tidak ditemukan.');
        }

        return view('admin_ruangan_edit', compact('ruangan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kode_ruangan'  => 'required|string|max:50',
            'nama_ruangan'  => 'required|string|max:100',
            'panjang'       => 'nullable|numeric',
            'lebar'         => 'nullable|numeric',
            'tinggi'        => 'nullable|numeric',
            'luas'          => 'nullable|numeric',
            'foto_depan'    => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'foto_belakang' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'foto_kiri'     => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'foto_kanan'    => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $ruangan = DB::table('ruangans')->where('id', $id)->first();

        if (!$ruangan) {
            $ruangan = DB::table('ruangans')->where('kode_ruangan', $id)->first();
        }

        if (!$ruangan) {
            return redirect('/admin/ruangan')->with('error', 'Ruangan tidak ditemukan.');
        }

        $data = [
            'kode_ruangan' => $request->kode_ruangan,
            'nama_ruangan' => $request->nama_ruangan,
            'panjang'      => $request->panjang,
            'lebar'        => $request->lebar,
            'tinggi'       => $request->tinggi,
            'luas'         => $request->luas,
            'updated_at'   => now(),
        ];

        $destinationPath = base_path('public' . DIRECTORY_SEPARATOR . 'ruangan');

        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0777, true);
        }

        $sisiFoto = ['foto_depan', 'foto_belakang', 'foto_kiri', 'foto_kanan'];
        foreach ($sisiFoto as $sisi) {
            if ($request->hasFile($sisi)) {
                if (!empty($ruangan->$sisi)) {
                    $oldFilePath = $destinationPath . DIRECTORY_SEPARATOR . $ruangan->$sisi;
                    if (file_exists($oldFilePath)) {
                        @unlink($oldFilePath);
                    }
                }

                $file = $request->file($sisi);
                $namaFile = $sisi . '_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move($destinationPath, $namaFile);
                $data[$sisi] = $namaFile;
            }
        }

        DB::table('ruangans')->where('id', $ruangan->id)->update($data);

        return redirect('/admin/ruangan')->with('success', 'Data ruangan berhasil diperbarui!');
    }

    public function hapus($id)
    {
        $ruangan = DB::table('ruangans')->where('id', $id)->first();

        if (!$ruangan) {
            $ruangan = DB::table('ruangans')->where('kode_ruangan', $id)->first();
        }

        if ($ruangan) {
            $destinationPath = base_path('public' . DIRECTORY_SEPARATOR . 'ruangan');

            $sisiFoto = ['foto_depan', 'foto_belakang', 'foto_kiri', 'foto_kanan'];
            foreach ($sisiFoto as $sisi) {
                if (!empty($ruangan->$sisi)) {
                    $pathFile = $destinationPath . DIRECTORY_SEPARATOR . $ruangan->$sisi;
                    if (file_exists($pathFile)) {
                        @unlink($pathFile);
                    }
                }
            }

            DB::table('keluhans')->where('ruangan_id', $ruangan->id)->delete();
            DB::table('barangs')->where('ruangan_id', $ruangan->id)->delete();
            DB::table('ruangans')->where('id', $ruangan->id)->delete();

            return redirect('/admin/ruangan')->with('success', 'Ruangan beserta seluruh fotonya berhasil dihapus!');
        }

        return redirect('/admin/ruangan')->with('error', 'Ruangan tidak ditemukan.');
    }

    public function tambahBarang(Request $request, $id)
    {
        $request->validate([
            'kode_barang'   => 'required|array',
            'kode_barang.*' => 'required|string|max:50|distinct|unique:barangs,kode_barang',
            'nama_barang'   => 'required|array',
            'nama_barang.*' => 'required|string|max:100',
            'merk'          => 'nullable|array',
            'merk.*'        => 'nullable|string|max:100',
            'jumlah'        => 'required|array',
            'jumlah.*'      => 'required|integer|min:1',
            'kondisi'       => 'required|array',
            'kondisi.*'     => 'required|in:Baik,Rusak Ringan,Rusak Berat',
            'spesifikasi'   => 'required|array',
            'spesifikasi.*' => 'required|string',
        ], [
            'kode_barang.*.unique'   => 'Gagal disimpan: Ada Kode Barang yang sudah terdaftar di sistem.',
            'kode_barang.*.distinct' => 'Gagal disimpan: Terdapat Kode Barang yang duplikat/kembar di dalam form isian Anda.'
        ]);

        $ruangan = DB::table('ruangans')->where('id', $id)->first();
        if (!$ruangan) {
            $ruangan = DB::table('ruangans')->where('kode_ruangan', $id)->first();
        }

        if (!$ruangan) {
            return redirect('/admin/ruangan')->with('error', 'Gagal menambahkan barang: Ruangan tidak ditemukan.');
        }

        $dataBarang = [];
        $jumlahInput = count($request->kode_barang); 

        for ($i = 0; $i < $jumlahInput; $i++) {
            $dataBarang[] = [
                'ruangan_id'   => $ruangan->id,
                'kode_barang'  => $request->kode_barang[$i],
                'nama_barang'  => $request->nama_barang[$i],
                'merk'         => $request->merk[$i] ?? '-',
                'jumlah'       => $request->jumlah[$i],
                'kondisi'      => $request->kondisi[$i],
                'spesifikasi'  => $request->spesifikasi[$i],
                'created_at'   => now(),
                'updated_at'   => now(),
            ];
        }

        DB::table('barangs')->insert($dataBarang);

        return redirect('/admin/ruangan/detail/' . $id)->with('success', $jumlahInput . ' aset barang berhasil ditambahkan ke ruangan ini!');
    }

    public function cetakRuangan($id)
    {
        $ruangan = Ruangan::where('id', $id)->orWhere('kode_ruangan', $id)->firstOrFail();
        $barangs = Barang::where('ruangan_id', $ruangan->id)->get();

        $encodeImage = function ($fileName) {
            if ($fileName) {
                $fullPath = public_path('ruangan' . DIRECTORY_SEPARATOR . $fileName);
                if (file_exists($fullPath)) {
                    $type = pathinfo($fullPath, PATHINFO_EXTENSION);
                    $data = file_get_contents($fullPath);
                    return 'data:image/' . $type . ';base64,' . base64_encode($data);
                }
            }
            return null;
        };

        $foto_depan    = $encodeImage($ruangan->foto_depan);
        $foto_belakang = $encodeImage($ruangan->foto_belakang);
        $foto_kiri     = $encodeImage($ruangan->foto_kiri);
        $foto_kanan    = $encodeImage($ruangan->foto_kanan);

        $pdf = Pdf::loadView('ruangan_pdf', compact(
            'ruangan', 
            'barangs', 
            'foto_depan', 
            'foto_belakang', 
            'foto_kiri', 
            'foto_kanan'
        ));

        $pdf->setPaper('a4', 'portrait');

        return $pdf->stream('Laporan_Inventaris_' . $ruangan->kode_ruangan . '.pdf');
    }

    public function cetakPDF($id)
    {
        return $this->cetakRuangan($id);
    }

    public function cetakSemuaLaporan()
    {
        $ruangans = Ruangan::with(['barangs' => function($query) {
            $query->orderBy('nama_barang', 'asc');
        }])->orderBy('nama_ruangan', 'asc')->get();

        $pdf = Pdf::loadView('admin_laporan_semua_pdf', compact('ruangans'));
        $pdf->setPaper('A4', 'landscape'); 

        return $pdf->stream('Laporan_Inventaris_Keseluruhan_SMKN9.pdf');
    }

    public function userRuangan()
    {
        $ruangans = DB::table('ruangans')->get();
        return view('user_ruangan', compact('ruangans'));
    }

    public function userDetail($id)
    {
        $ruangan = DB::table('ruangans')->where('id', $id)->first();
        if (!$ruangan) {
            $ruangan = DB::table('ruangans')->where('kode_ruangan', $id)->first();
        }

        if (!$ruangan) {
            return redirect('/user/ruangan')->with('error', 'Ruangan tidak ditemukan.');
        }

        $barangs = DB::table('barangs')->where('ruangan_id', $ruangan->id)->get();
        return view('detail_ruangan', compact('ruangan', 'barangs'));
    }
}