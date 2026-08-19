<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Ruangan - SMKN 9</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-slate-50 font-sans min-h-screen flex flex-col md:flex-row text-slate-800 relative">
    @include('alert')    
    @include('sidebar')
    
    <main class="flex-1 p-4 sm:p-6 md:p-10 overflow-y-auto w-full">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 sm:gap-4 mb-6 md:mb-8">
            <div>
                <h1 class="text-2xl sm:text-3xl md:text-4xl font-black text-slate-900 tracking-tight flex items-center gap-2">
                    <span>🚪</span> Daftar Ruangan
                </h1>
                <p class="text-xs sm:text-sm text-slate-500 mt-1">Daftar ruangan aktif dan fasilitas terdaftar di SMKN 9 Semarang</p>
            </div>
            
            <div class="flex items-center gap-2 w-full sm:w-auto justify-between sm:justify-end">
                <span class="bg-blue-50 text-blue-700 text-xs font-bold px-3 py-1.5 rounded-full border border-blue-200 shrink-0">
                    Mode Lihat (Read-Only)
                </span>
            </div>
        </div>

        {{-- Search Input Filter --}}
        <div class="mb-5 sm:mb-6">
            <div class="relative max-w-md w-full">
                <input type="text" id="searchRuangan" placeholder="Cari kode atau nama ruangan..." class="w-full pl-9 pr-4 py-2.5 bg-white border border-slate-200 rounded-xl text-xs sm:text-sm text-slate-700 outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all shadow-sm">
                <svg class="w-4 h-4 text-slate-400 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
        </div>

        {{-- Tampilan Card Khusus Mobile (Layar HP) --}}
        <div class="grid grid-cols-1 gap-3.5 md:hidden mb-8" id="ruanganCardsContainer">
            @forelse($ruangans as $r)
            <div class="ruangan-card bg-white p-4 sm:p-5 rounded-2xl border border-slate-200 shadow-sm flex flex-col justify-between gap-3 hover:border-indigo-300 transition-all" data-search="{{ strtolower(($r->kode_ruangan ?? '') . ' ' . $r->nama_ruangan) }}">
                <div>
                    <div class="flex justify-between items-start gap-2 mb-2">
                        <span class="font-mono text-xs font-bold text-slate-600 bg-slate-100 px-2.5 py-1 rounded-lg border border-slate-200">{{ $r->kode_ruangan ?? '-' }}</span>
                        <span class="text-xs font-bold text-indigo-700 bg-indigo-50 px-2.5 py-1 rounded-lg border border-indigo-100">
                            @if($r->luas)
                                {{ $r->luas }} m²
                            @elseif($r->panjang && $r->lebar)
                                {{ number_format((float)$r->panjang * (float)$r->lebar, 2) }} m²
                            @else
                                -
                            @endif
                        </span>
                    </div>

                    <h3 class="font-bold text-slate-900 text-base mb-2 leading-snug">{{ $r->nama_ruangan }}</h3>
                    
                    <div class="text-xs text-slate-600 bg-slate-50 p-2.5 rounded-xl border border-slate-100 flex items-center justify-between">
                        <span>Dimensi (P × L):</span>
                        <strong class="text-slate-800 font-semibold">{{ $r->panjang ? $r->panjang . ' m' : '-' }} × {{ $r->lebar ? $r->lebar . ' m' : '-' }}</strong>
                    </div>
                </div>

                <div class="pt-2 border-t border-slate-100">
                    <a href="{{ url('/user/ruangan/detail/' . $r->id) }}" class="w-full bg-indigo-50 hover:bg-indigo-100 text-indigo-700 border border-indigo-200 py-2.5 rounded-xl text-xs font-bold transition flex items-center justify-center gap-1.5 shadow-sm">
                        <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        <span>Lihat Detail & Aset</span>
                    </a>
                </div>
            </div>
            @empty
            <div class="bg-white p-8 rounded-2xl border border-slate-200 text-center text-slate-400 italic text-sm">
                Belum ada data ruangan yang diinput oleh Admin.
            </div>
            @endforelse
        </div>

        {{-- Tampilan Tabel untuk Tablet & Desktop --}}
        <div class="hidden md:block bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden mb-8">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-900 text-white text-xs font-bold uppercase tracking-widest border-b border-slate-800">
                        <th class="p-5 pl-8">Kode Ruangan</th>
                        <th class="p-5">Nama Ruangan</th>
                        <th class="p-5">Dimensi (P x L)</th>
                        <th class="p-5">Luas</th>
                        <th class="p-5 text-center pr-8">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm">
                    @forelse($ruangans as $r)
                    <tr class="ruangan-row hover:bg-slate-50 transition-colors duration-200" data-search="{{ strtolower(($r->kode_ruangan ?? '') . ' ' . $r->nama_ruangan) }}">
                        <td class="p-5 pl-8 font-mono font-bold text-slate-600">{{ $r->kode_ruangan ?? '-' }}</td>
                        <td class="p-5 font-bold text-slate-800 text-base">{{ $r->nama_ruangan }}</td>
                        <td class="p-5 text-slate-600 font-medium">{{ $r->panjang ? $r->panjang . ' m' : '-' }} x {{ $r->lebar ? $r->lebar . ' m' : '-' }}</td>
                        <td class="p-5 font-bold text-indigo-600">
                            @if($r->luas)
                                {{ $r->luas }} m²
                            @elseif($r->panjang && $r->lebar)
                                {{ number_format((float)$r->panjang * (float)$r->lebar, 2) }} m²
                            @else
                                -
                            @endif
                        </td>
                        <td class="p-5 text-center pr-8 whitespace-nowrap">
                            <a href="{{ url('/user/ruangan/detail/' . $r->id) }}" class="inline-flex items-center gap-1.5 bg-white text-indigo-600 border border-slate-200 hover:border-indigo-400 hover:bg-indigo-50 px-4 py-2 rounded-lg font-bold text-xs hover:shadow-md transition-all duration-300">
                                <svg class="w-3.5 h-3.5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                <span>Lihat Detail & Aset</span>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="p-8 text-center text-slate-400 italic">Belum ada data ruangan yang diinput oleh Admin.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </main>

    <script>
        document.getElementById('searchRuangan')?.addEventListener('input', function() {
            const val = this.value.toLowerCase();
            document.querySelectorAll('.ruangan-card').forEach(card => {
                const searchData = card.getAttribute('data-search') || '';
                card.style.display = searchData.includes(val) ? 'flex' : 'none';
            });
            document.querySelectorAll('.ruangan-row').forEach(row => {
                const searchData = row.getAttribute('data-search') || '';
                row.style.display = searchData.includes(val) ? '' : 'none';
            });
        });
    </script>
</body>
</html>