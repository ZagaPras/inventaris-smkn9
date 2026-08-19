<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $isAdmin = ($user->role === 'admin' || $user->email === 'admin@gmail.com');

        if (!$isAdmin) {
            if (!session()->has('guest_name')) {
                if ($user->role !== 'user') {
                    session([
                        'guest_name' => $user->name,
                        'guest_status' => $user->role
                    ]);
                } else {
                    return redirect('/isi-data-diri');
                }
            }
        }

        $total_ruangan = DB::table('ruangans')->count();
        $total_barang = DB::table('barangs')->count();
        $barang_rusak = DB::table('barangs')->where('kondisi', '!=', 'Baik')->count();

        $ruangans = DB::table('ruangans')->get();
        $barangs = DB::table('barangs')
            ->leftJoin('ruangans', 'barangs.ruangan_id', '=', 'ruangans.id')
            ->select('barangs.*', 'ruangans.nama_ruangan')
            ->get();

        if ($isAdmin) {
            $keluhans = DB::table('keluhans')
                ->join('barangs', 'keluhans.barang_id', '=', 'barangs.id')
                ->join('ruangans', 'keluhans.ruangan_id', '=', 'ruangans.id')
                ->select('keluhans.*', 'barangs.nama_barang', 'barangs.kode_barang', 'ruangans.nama_ruangan')
                ->orderBy('keluhans.created_at', 'desc')
                ->get();

            $keluhan_baru_count = DB::table('keluhans')->where('status', 'Menunggu')->count();

            return view('dashboard', compact(
                'total_ruangan', 
                'total_barang', 
                'barang_rusak', 
                'ruangans', 
                'barangs',
                'keluhans',
                'keluhan_baru_count'
            ));
        } else {
            return view('user_dashboard', compact('total_ruangan', 'total_barang', 'barang_rusak', 'ruangans', 'barangs'));
        }
    }
}