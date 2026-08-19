<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class KeluhanController extends Controller
{
    public function formKeluhan()
    {
        if (!session()->has('guest_name')) {
            return redirect('/isi-data-diri');
        }

        $ruangans = DB::table('ruangans')->get();
        $barangs = DB::table('barangs')->get();

        return view('lapor_keluhan', compact('ruangans', 'barangs'));
    }

    public function getBarangsByRuangan($ruangan_id)
    {
        $barangs = DB::table('barangs')->where('ruangan_id', $ruangan_id)->get();
        return response()->json($barangs);
    }

    public function submitKeluhan(Request $request)
    {
        $request->validate([
            'ruangan_id' => 'required',
            'barang_id'  => 'required',
            'deskripsi'  => 'required',
            'foto'       => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $nama_file = time() . "_" . $file->getClientOriginalName();
            $fotoPath = $file->storeAs('keluhan_foto', $nama_file, 'public');
        }

        DB::table('keluhans')->insert([
            'user_id'        => Auth::id(), 
            'pelapor_nama'   => session('guest_name'),
            'pelapor_status' => session('guest_status'),
            'ruangan_id'     => $request->ruangan_id,
            'barang_id'      => $request->barang_id,
            'deskripsi'      => $request->deskripsi,
            'foto'           => $fotoPath,
            'status'         => 'Menunggu',
            'created_at'     => now(),
            'updated_at'     => now(),
        ]);

        return redirect('/dashboard')->with('success', 'Laporan kerusakan berhasil dikirim! Admin akan segera mengeceknya.');
    } 

    public function riwayatKeluhan()
    {
        $user = Auth::user();
        $guestName = session('guest_name', $user->name);

        $keluhans = DB::table('keluhans')
            ->join('barangs', 'keluhans.barang_id', '=', 'barangs.id')
            ->join('ruangans', 'keluhans.ruangan_id', '=', 'ruangans.id')
            ->select('keluhans.*', 'barangs.nama_barang', 'barangs.kode_barang', 'ruangans.nama_ruangan')
            ->where(function($query) use ($user, $guestName) {
                $query->where('keluhans.user_id', $user->id)
                      ->orWhere('keluhans.pelapor_nama', $guestName);
            })
            ->orderBy('keluhans.created_at', 'desc')
            ->get();

        return view('user_riwayat_keluhan', compact('keluhans'));
    }

    public function updateStatusKeluhan(Request $request, $id)
    {
        DB::table('keluhans')->where('id', $id)->update([
            'status'     => $request->status,
            'updated_at' => now()
        ]);

        return redirect()->back()->with('success', 'Status laporan keluhan berhasil diperbarui!');
    }

    public function halamanKeluhan()
    {
        $keluhans = DB::table('keluhans')
            ->join('barangs', 'keluhans.barang_id', '=', 'barangs.id')
            ->join('ruangans', 'keluhans.ruangan_id', '=', 'ruangans.id')
            ->select('keluhans.*', 'barangs.nama_barang', 'barangs.kode_barang', 'ruangans.nama_ruangan')
            ->orderBy('keluhans.created_at', 'desc')
            ->get();
            
        $keluhan_baru_count = DB::table('keluhans')->where('status', 'Menunggu')->count();

        return view('admin_keluhan', compact('keluhans', 'keluhan_baru_count'));
    }

    public function destroy($id)
    {
        $keluhan = DB::table('keluhans')->where('id', $id)->first();
        if ($keluhan && $keluhan->foto) {
            Storage::disk('public')->delete($keluhan->foto);
        }

        DB::table('keluhans')->where('id', $id)->delete();
        return redirect()->back()->with('success', 'Data keluhan berhasil dihapus!');
    }
}