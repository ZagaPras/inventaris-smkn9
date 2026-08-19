@php
    $user = Auth::user();
    $isAdmin = $user && ($user->role === 'admin' || $user->email === 'admin@gmail.com');
@endphp

<!-- ================= 1. HEADER BAR KHUSUS MOBILE ================= -->
<div class="md:hidden bg-slate-950/95 backdrop-blur-md border-b border-slate-800 px-4 py-3 flex items-center justify-between sticky top-0 z-40 shadow-lg">
    <div class="flex items-center space-x-3">
        <!-- Tombol Hamburger (Dipindahkan ke Pojok Kiri) -->
        <button id="mobileMenuBtn" aria-label="Toggle Navigation Menu" class="p-2 text-slate-300 hover:text-white hover:bg-slate-900 rounded-xl focus:outline-none border border-slate-800 transition-all duration-200 active:scale-95 shadow-sm">
            <svg id="menuIconOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
            <svg id="menuIconClose" class="w-6 h-6 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>

        <!-- Logo & Title Header -->
        <div class="flex items-center space-x-3">
            <img src="{{ asset('images/logo_smk9.png') }}" alt="Logo SMKN 9" class="w-9 h-9 object-contain drop-shadow-[0_0_10px_rgba(96,165,250,0.4)] transition-transform duration-300 hover:scale-105">
            <div>
                <h2 class="text-base font-black text-white tracking-wider leading-none">INVENTARIS</h2>
                <p class="text-[11px] text-blue-400 font-mono font-semibold uppercase tracking-wide mt-0.5">SMKN 9 Semarang</p>
            </div>
        </div>
    </div>
</div>

<!-- ================= 2. OVERLAY BACKDROP MOBILE ================= -->
<div id="mobileBackdrop" class="fixed inset-0 bg-slate-950/80 backdrop-blur-sm z-40 hidden md:hidden transition-opacity"></div>

<!-- ================= 3. SIDEBAR (DESKTOP & MOBILE DRAWER) ================= -->
<aside id="sidebarMenu" class="fixed md:sticky top-0 left-0 z-50 w-64 bg-slate-950 text-slate-300 h-screen p-4 flex flex-col justify-between shadow-2xl transition-transform duration-300 transform -translate-x-full md:translate-x-0">
    
    <div class="flex flex-col h-full">
        <!-- Brand Header -->
        <div class="border-b border-slate-800 pb-6 mb-6 mt-2 text-center relative">
            <div class="flex justify-center mx-auto mb-4">
                <img src="{{ asset('images/logo_smk9.png') }}" alt="Logo SMKN 9" class="w-20 h-20 object-contain drop-shadow-[0_0_15px_rgba(96,165,250,0.5)] hover:scale-105 transition-transform duration-300">
            </div>
            <h2 class="text-xl font-black tracking-widest text-white">INVENTARIS</h2>
            <p class="text-xs text-blue-400 font-mono mt-1 uppercase tracking-wider">SMKN 9 Semarang</p>
        </div>
        
        <!-- Navigation Menu -->
        <nav class="flex-1 space-y-3 overflow-y-auto">
            <a href="{{ url('/dashboard') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl font-semibold transition-all duration-300 {{ request()->is('dashboard') ? 'bg-slate-800 text-blue-400 border border-blue-500/30 shadow-[0_0_15px_rgba(96,165,250,0.3)]' : 'bg-slate-900 text-slate-300 border border-slate-800 hover:bg-slate-800 hover:text-white hover:border-blue-400' }}">
                <span>📊</span> <span>Dashboard Utama</span>
            </a>

            @if($isAdmin)
                <a href="{{ url('/admin/ruangan') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl font-semibold transition-all duration-300 {{ request()->is('admin/ruangan*') ? 'bg-slate-800 text-blue-400 border border-blue-500/30 shadow-[0_0_15px_rgba(96,165,250,0.3)]' : 'bg-slate-900 text-slate-300 border border-slate-800 hover:bg-slate-800 hover:text-white hover:border-blue-400' }}">
                    <span>🚪</span> <span>Kelola Ruangan</span>
                </a>
                <a href="{{ url('/admin/barang') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl font-semibold transition-all duration-300 {{ request()->is('admin/barang*') ? 'bg-slate-800 text-blue-400 border border-blue-500/30 shadow-[0_0_15px_rgba(96,165,250,0.3)]' : 'bg-slate-900 text-slate-300 border border-slate-800 hover:bg-slate-800 hover:text-white hover:border-blue-400' }}">
                    <span>📦</span> <span>Kelola Aset</span>
                </a>
                <a href="{{ url('/admin/keluhan') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl font-semibold transition-all duration-300 {{ request()->is('admin/keluhan*') ? 'bg-slate-800 text-sky-400 border border-sky-500/30' : 'bg-slate-900 text-slate-300 border border-slate-800 hover:bg-slate-800 hover:text-white hover:border-blue-400' }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                    <span class="text-sm">Kelola Keluhan</span>
                    
                    @if(isset($keluhan_baru_count) && $keluhan_baru_count > 0)
                        <span class="ml-auto bg-red-500 text-white text-[10px] font-black px-2 py-0.5 rounded-full animate-pulse">
                            {{ $keluhan_baru_count }}
                        </span>
                    @endif
                </a>
            @else
                <a href="{{ url('/user/ruangan') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl font-semibold transition-all duration-300 {{ request()->is('user/ruangan*') ? 'bg-slate-800 text-blue-400 border border-blue-500/30 shadow-[0_0_15px_rgba(96,165,250,0.3)]' : 'bg-slate-900 text-slate-300 border border-slate-800 hover:bg-slate-800 hover:text-white hover:border-blue-400' }}">
                    <span>🚪</span> <span>Daftar Ruangan</span>
                </a>
                <a href="{{ url('/user/barang') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl font-semibold transition-all duration-300 {{ request()->is('user/barang*') ? 'bg-slate-800 text-blue-400 border border-blue-500/30 shadow-[0_0_15px_rgba(96,165,250,0.3)]' : 'bg-slate-900 text-slate-300 border border-slate-800 hover:bg-slate-800 hover:text-white hover:border-blue-400' }}">
                    <span>📦</span> <span>Daftar Aset Barang</span>
                </a>
                <a href="{{ url('/lapor-keluhan') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl font-semibold transition-all duration-300 {{ request()->is('lapor-keluhan*') ? 'bg-slate-800 text-amber-400 border border-amber-500/30' : 'bg-slate-900 text-slate-300 border border-slate-800 hover:bg-slate-800 hover:text-white hover:border-amber-400' }}">
                    <span>⚠️</span> <span>Laporkan Keluhan</span>
                </a>
                <a href="{{ url('/riwayat-keluhan') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl font-semibold transition-all duration-300 {{ request()->is('riwayat-keluhan*') ? 'bg-slate-800 text-emerald-400 border border-emerald-500/30' : 'bg-slate-900 text-slate-300 border border-slate-800 hover:bg-slate-800 hover:text-white hover:border-emerald-400' }}">
                    <span>📋</span> <span>Riwayat Keluhan</span>
                </a>
            @endif
        </nav>

        <!-- Logout Action -->
        <div class="pt-4 mt-auto border-t border-slate-800">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full flex items-center justify-between text-xs font-semibold text-rose-400 hover:text-white bg-rose-500/10 hover:bg-rose-500 px-4 py-2.5 rounded-xl transition-all duration-300 border border-rose-500/20 hover:border-rose-500">
                    <span>{{ $isAdmin ? 'Logout Admin' : 'Logout (Keluar)' }}</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                    </svg>
                </button>
            </form>
        </div>
    </div>
</aside>

<!-- ================= 4. SCRIPT TOGGLE MOBILE MENU ================= -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const mobileMenuBtn = document.getElementById('mobileMenuBtn');
        const sidebarMenu = document.getElementById('sidebarMenu');
        const mobileBackdrop = document.getElementById('mobileBackdrop');
        const menuIconOpen = document.getElementById('menuIconOpen');
        const menuIconClose = document.getElementById('menuIconClose');

        function toggleMenu() {
            const isOpen = !sidebarMenu.classList.contains('-translate-x-full');
            
            if (isOpen) {
                sidebarMenu.classList.add('-translate-x-full');
                mobileBackdrop.classList.add('hidden');
                menuIconOpen.classList.remove('hidden');
                menuIconClose.classList.add('hidden');
            } else {
                sidebarMenu.classList.remove('-translate-x-full');
                mobileBackdrop.classList.remove('hidden');
                menuIconOpen.classList.add('hidden');
                menuIconClose.classList.remove('hidden');
            }
        }

        if (mobileMenuBtn) {
            mobileMenuBtn.addEventListener('click', toggleMenu);
            mobileBackdrop.addEventListener('click', toggleMenu);
        }
    });
</script>