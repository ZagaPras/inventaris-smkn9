<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect('/dashboard');
        }
        return view('login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if ($credentials['email'] === 'admin@gmail.com') {
            $adminUser = DB::table('users')->where('email', 'admin@gmail.com')->first();
            if (!$adminUser) {
                DB::table('users')->insert([
                    'name' => 'Admin',
                    'email' => 'admin@gmail.com',
                    'password' => Hash::make('admin'),
                    'role' => 'admin',
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }

            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();
                $user = Auth::user();
                if ($user->role !== 'admin') {
                    DB::table('users')->where('id', $user->id)->update(['role' => 'admin']);
                    $user->role = 'admin';
                }
                return redirect()->intended('/dashboard')->with('success', 'Selamat datang kembali, Admin!');
            }
            return back()->with('error', 'Password untuk Admin salah.')->onlyInput('email');
        }

        $user = DB::table('users')->where('email', $credentials['email'])->first();

        if (!$user) {
            DB::table('users')->insert([
                'name' => explode('@', $credentials['email'])[0],
                'email' => $credentials['email'],
                'password' => Hash::make($credentials['password']),
                'role' => 'user', 
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $authUser = Auth::user();
            if ($authUser->role === 'admin' || $authUser->email === 'admin@gmail.com') {
                if ($authUser->role !== 'admin') {
                    DB::table('users')->where('id', $authUser->id)->update(['role' => 'admin']);
                    $authUser->role = 'admin';
                }
            } else if ($authUser->role !== 'user') {
                session([
                    'guest_name' => $authUser->name,
                    'guest_status' => $authUser->role
                ]);
            }
            return redirect()->intended('/dashboard');
        }

        return back()->with('error', 'Email sudah terdaftar, tetapi password salah.')->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/')->with('success', 'Anda telah berhasil logout.');
    }

    public function showDataDiriForm()
    {
        $user = Auth::user();

        if ($user->role === 'admin' || $user->email === 'admin@gmail.com') {
            return redirect('/dashboard');
        }

        if (session()->has('guest_name') || $user->role !== 'user') {
            if (!session()->has('guest_name')) {
                session([
                    'guest_name' => $user->name,
                    'guest_status' => $user->role
                ]);
            }
            return redirect('/dashboard');
        }

        return view('buku_tamu');
    }

    public function submitDataDiri(Request $request)
    {
        $request->validate([
            'nama'   => 'required|string|max:255',
            'status' => 'required|string', 
        ]);

        session([
            'guest_name'   => $request->nama,
            'guest_status' => $request->status,
        ]);

        DB::table('users')->where('id', Auth::id())->update([
            'name' => $request->nama,
            'role' => $request->status, 
        ]);

        return redirect()->to('/dashboard')->with('success', 'Data diri berhasil disimpan!');
    }
}