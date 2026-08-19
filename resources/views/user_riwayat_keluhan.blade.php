<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Keluhan Saya - SMKN 9</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-slate-50 font-sans min-h-screen text-slate-800 flex flex-col justify-between">
    @include('alert')

    {{-- Top Header Bar --}}
    <header class="w-full bg-slate-950/95 backdrop-blur-md border-b border-slate-800 px-4 sm:px-8 py-3.5 flex items-center justify-between sticky top-0 z-40 shadow-lg">
        <div class="flex items-center gap-3">
            <img src="{{ asset('images/logo_smk9.png') }}" alt="Logo SMKN 9" class="w-8 h-8 sm:w-9 sm:h-9 object-contain drop-shadow-[0_0_10px_rgba(96,165,250,0.4)]">
            <div>
                <h1 class="text-sm sm:text-base font-black text-white tracking-wider leading-none">INVENTARIS</h1>
                <p class="text-[10px] text-blue-400 font-mono uppercase tracking-wide mt-0.5">SMKN 9 Semarang</p>
            </div>
        </div>

        <a href="{{ url('/dashboard') }}" class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-slate-900 hover:bg-slate-800 text-slate-300 hover:text-white border border-slate-800 hover:border-slate-700 text-xs font-bold rounded-xl transition-all">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            <span>Dashboard</span>
        </a>
    </header>

    <main class="grow max-w-6xl w-full mx-auto px-4 sm:px-6 py-6 sm:py-8">
        
        {{-- Section Header --}}
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 mb-6 sm:mb-8">
            <div>
                <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight flex items-center gap-2">
                    <span>📋</span> Riwayat Keluhan Saya
                </h1>
                <p class="text-xs sm:text-sm text-slate-500 mt-1">Pantau perkembangan status laporan kerusakan fasilitas yang telah Anda kirimkan.</p>
            </div>

            <a href="{{ url('/lapor-keluhan') }}" class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-amber-500 hover:bg-amber-400 text-white text-xs font-bold rounded-xl shadow-md shadow-amber-500/20 transition-all w-full sm:w-auto">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                <span>+ Buat Laporan Baru</span>
            </a>
        </div>

        {{-- Cards Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
            @forelse($keluhans as $k)
                @php
                    $progressWidth = '0%';
                    $lineColor = 'bg-blue-600';
                    if($k->status == 'Diproses') {
                        $progressWidth = '50%';
                        $lineColor = 'bg-amber-500';
                    } elseif($k->status == 'Selesai') {
                        $progressWidth = '100%';
                        $lineColor = 'bg-emerald-500';
                    }
                @endphp

                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition-all duration-300 flex flex-col justify-between overflow-hidden">
                    
                    {{-- Card Body --}}
                    <div class="p-4 sm:p-5 flex-1 flex flex-col justify-between gap-3">
                        <div>
                            {{-- Header Card --}}
                            <div class="flex justify-between items-start gap-2 mb-3">
                                <div>
                                    <h3 class="font-bold text-slate-900 text-base leading-snug capitalize">{{ $k->nama_barang }}</h3>
                                    <span class="inline-block font-mono text-[11px] font-bold text-slate-600 bg-slate-100 px-2 py-0.5 rounded border border-slate-200 mt-1">
                                        Kode: {{ $k->kode_barang }}
                                    </span>
                                </div>

                                {{-- Status Badge --}}
                                @if($k->status == 'Menunggu')
                                    <span class="bg-rose-50 text-rose-700 border border-rose-200 px-2.5 py-1 rounded-full text-xs font-bold shrink-0 inline-flex items-center gap-1.5">
                                        <span class="w-1.5 h-1.5 bg-rose-500 rounded-full animate-ping"></span> Menunggu
                                    </span>
                                @elseif($k->status == 'Diproses')
                                    <span class="bg-amber-50 text-amber-700 border border-amber-200 px-2.5 py-1 rounded-full text-xs font-bold shrink-0 inline-flex items-center gap-1">
                                        ⏳ Diproses
                                    </span>
                                @elseif($k->status == 'Selesai')
                                    <span class="bg-emerald-50 text-emerald-700 border border-emerald-200 px-2.5 py-1 rounded-full text-xs font-bold shrink-0 inline-flex items-center gap-1">
                                        ✅ Selesai
                                    </span>
                                @else
                                    <span class="bg-slate-100 text-slate-700 border border-slate-200 px-2.5 py-1 rounded-full text-xs font-bold shrink-0">
                                        {{ $k->status }}
                                    </span>
                                @endif
                            </div>

                            {{-- Metadata --}}
                            <div class="space-y-1.5 text-xs text-slate-500 mb-3 bg-slate-50 p-2.5 rounded-xl border border-slate-100">
                                <div class="flex items-center justify-between">
                                    <span>Tanggal Lapor:</span>
                                    <span class="font-semibold text-slate-700">{{ date('d/m/Y', strtotime($k->created_at)) }} <span class="text-slate-400">({{ date('H:i', strtotime($k->created_at)) }} WIB)</span></span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span>Lokasi Ruang:</span>
                                    <strong class="text-slate-800 font-semibold">{{ $k->nama_ruangan }}</strong>
                                </div>
                            </div>

                            {{-- Description & Photo --}}
                            <div class="bg-slate-50/70 p-3 rounded-xl border border-slate-100 text-xs space-y-2">
                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Deskripsi Kerusakan</span>
                                <p class="text-slate-700 leading-relaxed line-clamp-3" title="{{ $k->deskripsi }}">
                                    {{ $k->deskripsi }}
                                </p>
                                
                                @if($k->foto)
                                    <a href="{{ asset('storage/' . $k->foto) }}" target="_blank" class="inline-flex items-center gap-1.5 px-2.5 py-1.5 bg-blue-50 border border-blue-100 hover:bg-blue-100 rounded-lg text-blue-600 font-bold text-[11px] transition-colors mt-1">
                                        <svg class="w-3.5 h-3.5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        <span>Lihat Foto Bukti</span>
                                    </a>
                                @else
                                    <span class="block text-[11px] text-slate-400 italic mt-1">
                                        *Tidak ada foto lampiran
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Card Footer Progress Stepper --}}
                    <div class="bg-slate-50/90 border-t border-slate-100 p-4 pt-3">
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block text-center mb-3">Status Progres Penanganan</span>
                        
                        <div class="relative px-4">
                            {{-- Background Track --}}
                            <div class="absolute top-3.5 left-6 right-6 h-1 bg-slate-200 rounded-full z-0"></div>
                            
                            {{-- Active Progress Line --}}
                            <div class="absolute top-3.5 left-6 h-1 {{ $lineColor }} rounded-full z-0 transition-all duration-500" style="width: calc({{ $progressWidth }} - 2rem);"></div>

                            {{-- Stepper Circles --}}
                            <div class="relative z-10 flex justify-between items-center text-center">
                                
                                {{-- Step 1 --}}
                                <div class="flex flex-col items-center">
                                    <div class="w-7 h-7 rounded-full bg-blue-600 text-white font-bold text-xs flex items-center justify-center shadow-sm">
                                        ✓
                                    </div>
                                    <span class="text-[10px] font-bold text-blue-600 mt-1 uppercase">Lapor</span>
                                </div>

                                {{-- Step 2 --}}
                                <div class="flex flex-col items-center">
                                    <div class="w-7 h-7 rounded-full text-xs font-bold flex items-center justify-center border-2 transition-all shadow-sm {{ in_array($k->status, ['Diproses', 'Selesai']) ? 'bg-amber-500 text-white border-amber-500' : 'bg-white text-slate-400 border-slate-300' }}">
                                        ⚙️
                                    </div>
                                    <span class="text-[10px] font-bold mt-1 uppercase {{ in_array($k->status, ['Diproses', 'Selesai']) ? 'text-amber-600' : 'text-slate-400' }}">Proses</span>
                                </div>

                                {{-- Step 3 --}}
                                <div class="flex flex-col items-center">
                                    <div class="w-7 h-7 rounded-full text-xs font-bold flex items-center justify-center border-2 transition-all shadow-sm {{ $k->status == 'Selesai' ? 'bg-emerald-500 text-white border-emerald-500' : 'bg-white text-slate-400 border-slate-300' }}">
                                        ✓
                                    </div>
                                    <span class="text-[10px] font-bold mt-1 uppercase {{ $k->status == 'Selesai' ? 'text-emerald-600' : 'text-slate-400' }}">Selesai</span>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
            @empty
                <div class="col-span-full bg-white rounded-3xl border border-slate-200 p-8 sm:p-12 text-center shadow-sm">
                    <div class="w-16 h-16 bg-blue-50 text-blue-500 rounded-2xl flex items-center justify-center mx-auto mb-4 text-2xl">
                        📥
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 mb-1">Belum Ada Riwayat Keluhan</h3>
                    <p class="text-xs sm:text-sm text-slate-500 max-w-md mx-auto mb-6">Anda belum pernah mengirimkan laporan kerusakan barang. Jika menemukan kendala pada fasilitas, laporan Anda akan tercatat di sini.</p>
                    <a href="{{ url('/lapor-keluhan') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-blue-600 hover:bg-blue-500 text-white font-bold text-xs sm:text-sm rounded-xl shadow-md transition-all">
                        <span>+ Buat Laporan Pertama</span>
                    </a>
                </div>
            @endforelse
        </div>
    </main>

    <footer class="w-full py-4 text-center text-xs text-slate-400 bg-slate-900 border-t border-slate-800 mt-8">
        © 2026 SMKN 9 Semarang. All rights reserved.
    </footer>
</body>
</html>