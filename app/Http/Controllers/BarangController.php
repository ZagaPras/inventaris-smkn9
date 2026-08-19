<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\BarangImport;
use Barryvdh\DomPDF\Facade\Pdf;

class BarangController extends Controller
{
    public function index()
    {
        $barangs = DB::table('barangs')
            ->leftJoin('ruangans', 'barangs.ruangan_id', '=', 'ruangans.id')
            ->select('barangs.*', 'ruangans.nama_ruangan')
            ->orderBy('barangs.kode_barang', 'asc')
            ->get();
            
        $ruangans = DB::table('ruangans')->get(); 
        
        return view('admin_barang', compact('barangs', 'ruangans'));
    }

    public function store(Request $request)
    {
        DB::table('barangs')->insert([
            'ruangan_id'  => $request->ruangan_id,
            'nama_barang' => $request->nama_barang,
            'kode_barang' => $request->kode_barang,
            'jumlah'      => $request->jumlah,
            'kondisi'     => $request->kondisi,
            'merk'        => $request->merk, 
            'spesifikasi' => $request->spesifikasi,
            'keterangan'  => $request->keterangan,
            'created_at'  => now(), 
            'updated_at'  => now()
        ]);

        return redirect('/admin/barang')->with('success', 'Aset baru berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $barang = DB::table('barangs')->where('id', $id)->first();
        $ruangans = DB::table('ruangans')->get();

        return view('admin_barang_edit', compact('barang', 'ruangans'));
    }

    public function update(Request $request, $id)
    {
        DB::table('barangs')->where('id', $id)->update([
            'ruangan_id'  => $request->ruangan_id,
            'nama_barang' => $request->nama_barang,
            'kode_barang' => $request->kode_barang,
            'jumlah'      => $request->jumlah,
            'kondisi'     => $request->kondisi,
            'merk'        => $request->merk,
            'spesifikasi' => $request->spesifikasi,
            'keterangan'  => $request->keterangan,
            'updated_at'  => now()
        ]);

        return redirect('/admin/barang')->with('success', 'Data aset berhasil diperbarui!');
    }

    public function destroy($id)
    {
        DB::table('keluhans')->where('barang_id', $id)->delete();
        DB::table('barangs')->where('id', $id)->delete();

        return redirect()->back()->with('success', 'Aset berhasil dihapus dari sistem!');
    }

    public function userBarang()
    {
        $barangs = DB::table('barangs')
            ->leftJoin('ruangans', 'barangs.ruangan_id', '=', 'ruangans.id')
            ->select('barangs.*', 'ruangans.nama_ruangan')
            ->orderBy('barangs.kode_barang', 'asc')
            ->get();
            
        return view('user_barang', compact('barangs'));
    }

    public function importExcel(Request $request)
    {
        $request->validate([
            'file_excel' => 'required|mimes:xlsx,xls,csv|max:10240',
        ], [
            'file_excel.required' => 'Pilih file Excel terlebih dahulu!',
            'file_excel.mimes'    => 'Format file harus .xlsx, .xls, atau .csv!',
            'file_excel.max'      => 'Ukuran file maksimal 10MB!',
        ]);

        try {
            Excel::import(new BarangImport, $request->file('file_excel'));
            return redirect()->back()->with('success', 'Data inventaris berhasil diimpor dari Excel!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengimpor data: ' . $e->getMessage());
        }
    }

    public function cetakPdf(Request $request)
    {
        $ruangan_id = $request->get('ruangan_id');

        $query = DB::table('barangs')
            ->leftJoin('ruangans', 'barangs.ruangan_id', '=', 'ruangans.id')
            ->select('barangs.*', 'ruangans.nama_ruangan');

        $infoRuangan = null;

        if ($ruangan_id) {
            $query->where('barangs.ruangan_id', $ruangan_id);
            $infoRuangan = DB::table('ruangans')->where('id', $ruangan_id)->first();
        }

        $barangs = $query->orderBy('ruangans.nama_ruangan', 'asc')
                        ->orderBy('barangs.nama_barang', 'asc')
                        ->get();

        $pdf = Pdf::loadView('barang_pdf', compact('barangs', 'infoRuangan'))
                  ->setPaper('a4', 'portrait');

        $filename = $infoRuangan 
            ? 'Laporan_Aset_' . str_replace(' ', '_', $infoRuangan->nama_ruangan) . '.pdf'
            : 'Laporan_Aset_Keseluruhan_SMKN9.pdf';

        return $pdf->stream($filename);
    }
}