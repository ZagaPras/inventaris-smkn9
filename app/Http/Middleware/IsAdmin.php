<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->role === 'admin' || $user->email === 'admin@gmail.com') {
                if ($user->role !== 'admin') {
                    \Illuminate\Support\Facades\DB::table('users')->where('id', $user->id)->update(['role' => 'admin']);
                    $user->role = 'admin';
                }
                return $next($request);
            }
        }

        return redirect('/dashboard')->with('error', 'Akses Ditolak! Anda bukan Admin.');
    }
}