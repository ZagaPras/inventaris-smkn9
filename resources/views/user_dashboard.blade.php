<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Aset Barang - SMKN 9</title>
    @vite('resources/css/app.css')
</head>
        
<body class="bg-slate-50 font-sans min-h-screen text-slate-800">
    @include('alert')    

    @if(session()->has('guest_name'))
    <header class="sticky top-0 z-50 w-full bg-gradient-to-r from-slate-900 via-slate-800 to-slate-900 border-b border-slate-700 shadow-md">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 py-4 flex flex-col md:flex-row items-center justify-between gap-4">
            
            <div class="flex items-center gap-4 w-full md:w-auto">
                <div class="w-11 h-11 sm:w-12 sm:h-12 bg-gradient-to-br from-blue-500 to-blue-600 text-white rounded-full flex items-center justify-center font-black text-lg sm:text-xl shadow-inner shrink-0 ring-2 ring-slate-800">
                    {{ strtoupper(substr(session('guest_name'), 0, 1)) }}
                </div>
                <div>
                    <p class="text-xs text-slate-400 font-medium mb-0.5">Selamat datang di sistem,</p>
                    <p class="text-base sm:text-lg font-black text-white tracking-tight flex items-center gap-2">
                        {{ session('guest_name') }} 
                        <span class="text-[10px] font-bold bg-slate-800 text-blue-400 border border-slate-600 px-2 py-0.5 rounded align-middle">
                            {{ session('guest_status') }}
                        </span>
                    </p>
                </div>
            </div>
            
            <div class="flex flex-wrap items-center gap-2.5 sm:gap-3 w-full md:w-auto">
                <a href="{{ url('/riwayat-keluhan') }}" class="inline-flex items-center justify-center gap-1.5 px-4 sm:px-6 py-2.5 bg-blue-500 hover:bg-blue-400 text-white text-xs sm:text-sm font-bold rounded-full shadow-lg shadow-blue-500/20 transition-all hover:-translate-y-0.5 flex-1 sm:flex-initial">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span>Riwayat Keluhan</span>
                </a>

                <a href="{{ url('/lapor-keluhan') }}" class="inline-flex items-center justify-center gap-1.5 px-4 sm:px-6 py-2.5 bg-orange-500 hover:bg-orange-400 text-white text-xs sm:text-sm font-bold rounded-full shadow-lg shadow-orange-500/20 transition-all hover:-translate-y-0.5 flex-1 sm:flex-initial">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    <span>Laporkan Keluhan</span>
                </a>

                <form action="{{ url('/logout') }}" method="POST" class="m-0 w-full sm:w-auto">
                    @csrf
                    <button type="submit" class="inline-flex items-center justify-center gap-1.5 px-4 sm:px-6 py-2.5 bg-rose-500 hover:bg-rose-400 text-white text-xs sm:text-sm font-bold rounded-full shadow-lg shadow-rose-500/20 transition-all hover:-translate-y-0.5 w-full">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        <span>Logout (Keluar)</span>
                    </button>
                </form>
            </div>

        </div>
    </header>
    @endif

    <main class="max-w-6xl mx-auto px-4 sm:px-6 py-6 sm:py-10">
        
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
            <h2 class="text-xl sm:text-2xl md:text-[1.65rem] font-black text-slate-900 tracking-tight">Daftar Aset Barang</h2>
            
            {{-- Searchbar Filter --}}
            <div class="w-full sm:w-72 relative">
                <input type="text" id="searchInput" placeholder="Cari barang atau ruangan..." class="w-full pl-9 pr-4 py-2.5 bg-white border border-slate-200 rounded-xl text-xs sm:text-sm text-slate-700 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all shadow-sm">
                <svg class="w-4 h-4 text-slate-400 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
        </div>
        
        {{-- Tampilan Card khusus Mobile (Layar HP) --}}
        <div class="grid grid-cols-1 gap-4 md:hidden mb-6" id="mobileCardsContainer">
            @forelse($barangs as $b)
            <div class="asset-card bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex flex-col justify-between gap-3" data-search="{{ strtolower($b->nama_barang . ' ' . $b->kode_barang . ' ' . ($b->nama_ruangan ?? '')) }}">
                <div>
                    <div class="flex justify-between items-start gap-2 mb-2">
                        <span class="font-mono text-xs font-bold text-slate-500 bg-slate-100 px-2.5 py-1 rounded-lg">{{ $b->kode_barang }}</span>
                        @php
                            $kondisi = strtolower($b->kondisi);
                        @endphp
                        @if($kondisi == 'baik')
                            <span class="px-2.5 py-1 rounded-lg text-xs font-bold bg-emerald-50 text-emerald-600 border border-emerald-200">
                                Baik
                            </span>
                        @elseif(str_contains($kondisi, 'rusak ringan'))
                            <span class="px-2.5 py-1 rounded-lg text-xs font-bold bg-amber-50 text-amber-600 border border-amber-200">
                                Rusak Ringan
                            </span>
                        @else
                            <span class="px-2.5 py-1 rounded-lg text-xs font-bold bg-rose-50 text-rose-600 border border-rose-200">
                                {{ $b->kondisi }}
                            </span>
                        @endif
                    </div>
                    <h3 class="font-bold text-slate-900 text-base capitalize mb-1">{{ $b->nama_barang }}</h3>
                    <p class="text-xs text-slate-500">Ruang: <strong class="text-slate-700 font-semibold">{{ $b->nama_ruangan ?? ($b->ruangan->nama_ruangan ?? '-') }}</strong></p>
                </div>

                <div class="pt-3 border-t border-slate-100">
                    <button type="button" onclick="openModal('{{ $b->id }}')" class="w-full bg-blue-50 text-blue-600 border border-blue-200 py-2.5 rounded-xl font-bold text-xs text-center flex items-center justify-center gap-1.5 hover:bg-blue-100 transition-colors">
                        <span>👁️</span> Lihat Detail Aset
                    </button>
                </div>
            </div>
            @empty
            <div class="bg-white p-8 rounded-2xl border border-slate-200 text-center text-slate-400 font-medium text-sm">
                Belum ada data aset barang yang tersedia.
            </div>
            @endforelse
        </div>

        {{-- Tampilan Tabel untuk Tablet & Desktop --}}
        <div class="hidden md:block bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse min-w-[700px] table-fixed">
                    <thead>
                        <tr class="bg-slate-900 text-white text-xs font-bold uppercase tracking-wider">
                            <th class="py-4 px-6 w-[15%]">Kode Barang</th>
                            <th class="py-4 px-6 w-[30%]">Nama Barang</th>
                            <th class="py-4 px-6 w-[25%]">Lokasi Ruangan</th>
                            <th class="py-4 px-6 w-[15%] text-center">Kondisi</th>
                            <th class="py-4 px-6 w-[15%] text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm">
                        @forelse($barangs as $b)
                        <tr class="asset-row hover:bg-slate-50 transition-colors duration-150" data-search="{{ strtolower($b->nama_barang . ' ' . $b->kode_barang . ' ' . ($b->nama_ruangan ?? '')) }}">
                            <td class="py-4 px-6 font-mono text-xs text-slate-500 font-bold whitespace-nowrap">
                                {{ $b->kode_barang }}
                            </td>
                            
                            <td class="py-4 px-6 font-bold text-slate-800 capitalize truncate" title="{{ $b->nama_barang }}">
                                {{ $b->nama_barang }}
                            </td>
                            
                            <td class="py-4 px-6 text-slate-600 font-medium truncate">
                                {{ $b->nama_ruangan ?? ($b->ruangan->nama_ruangan ?? '-') }}
                            </td>
                            
                            <td class="py-4 px-6 text-center whitespace-nowrap">
                                @php
                                    $kondisi = strtolower($b->kondisi);
                                @endphp
                                @if($kondisi == 'baik')
                                    <span class="inline-block px-3 py-1 rounded-md text-xs font-bold bg-emerald-50 text-emerald-600 border border-emerald-200">
                                        Baik
                                    </span>
                                @elseif(str_contains($kondisi, 'rusak ringan'))
                                    <span class="inline-block px-3 py-1 rounded-md text-xs font-bold bg-amber-50 text-amber-600 border border-amber-200">
                                        Rusak Ringan
                                    </span>
                                @else
                                    <span class="inline-block px-3 py-1 rounded-md text-xs font-bold bg-rose-50 text-rose-600 border border-rose-200">
                                        {{ $b->kondisi }}
                                    </span>
                                @endif
                            </td>

                            <td class="py-4 px-6 text-center whitespace-nowrap">
                                <button type="button" onclick="openModal('{{ $b->id }}')" class="inline-flex items-center justify-center gap-1.5 bg-white text-slate-600 hover:text-blue-600 border border-slate-200 hover:border-blue-300 px-3.5 py-1.5 rounded-lg font-bold text-xs shadow-sm hover:shadow transition-all">
                                    <span>👁️</span> Detail
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="py-12 text-center text-slate-400 font-medium text-sm">
                                Belum ada data aset barang yang tersedia.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @foreach($barangs as $b)
        <div id="modal-{{ $b->id }}" class="fixed inset-0 z-[99] hidden items-center justify-center p-4 overflow-x-hidden overflow-y-auto">
            <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" onclick="closeModal('{{ $b->id }}')"></div>

            <div class="relative bg-white rounded-3xl shadow-2xl max-w-md w-full p-5 sm:p-6 z-10 transform scale-95 opacity-0 transition-all duration-300 max-h-[90vh] flex flex-col" id="modal-content-{{ $b->id }}">
                
                <div class="flex items-center justify-between border-b border-slate-100 pb-4 mb-4 shrink-0">
                    <h3 class="text-lg font-bold text-slate-900 flex items-center gap-2">
                        <span class="bg-blue-100 text-blue-600 w-8 h-8 flex items-center justify-center rounded-full">👁️</span>
                        Detail Aset
                    </h3>
                    <button type="button" onclick="closeModal('{{ $b->id }}')" class="text-slate-400 hover:text-red-500 hover:bg-red-50 transition p-2 rounded-xl">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <div class="space-y-4 text-left overflow-y-auto pr-1">
                    <div>
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Nama Barang</span>
                        <p class="text-lg font-black text-slate-800 leading-tight mt-1">{{ $b->nama_barang }}</p>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4 bg-slate-50 p-3 rounded-2xl border border-slate-100">
                        <div>
                            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Kode Aset</span>
                            <p class="text-sm font-bold text-slate-700 mt-1 font-mono">{{ $b->kode_barang }}</p>
                        </div>
                        <div>
                            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Merk / Brand</span>
                            <p class="text-sm font-bold text-slate-700 mt-1">{{ $b->merk ?: '-' }}</p>
                        </div>
                    </div>

                    <div>
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Lokasi Ruangan</span>
                        <p class="text-sm font-bold text-slate-700 mt-1">{{ $b->nama_ruangan ?? '-' }}</p>
                    </div>

                    <div>
                        <span class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-2">SPESIFIKASI LENGKAP</span>
                        <div class="flex items-center p-4 bg-slate-50 rounded-2xl border border-slate-100 text-sm text-slate-600 min-h-[60px]">
                            {{ $b->spesifikasi ?? '-' }}
                        </div>
                    </div>

                    <div class="mt-4">
                        <span class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-2">KETERANGAN TAMBAHAN</span>
                        <div class="flex items-center p-4 bg-slate-50 rounded-2xl border border-slate-100 text-sm text-slate-600 min-h-[60px]">
                            {{ $b->keterangan ?? '-' }}
                        </div>
                    </div>

                    <div class="pt-4 mt-2 border-t border-slate-100 flex flex-col gap-2 text-xs text-slate-400">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>Terakhir diperbarui:</span>
                            </div>
                            <span class="font-semibold text-slate-500">
                                {{ $b->updated_at ? \Carbon\Carbon::parse($b->updated_at)->locale('id')->translatedFormat('d F Y, H:i') : '-' }} WIB
                            </span>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        @endforeach
    </main>

    <script>
        // Script untuk Modal
        function openModal(id) {
            const modal = document.getElementById('modal-' + id);
            const content = document.getElementById('modal-content-' + id);
            if (modal && content) {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
                setTimeout(() => {
                    content.classList.remove('scale-95', 'opacity-0');
                    content.classList.add('scale-100', 'opacity-100');
                }, 10);
            }
        }

        function closeModal(id) {
            const modal = document.getElementById('modal-' + id);
            const content = document.getElementById('modal-content-' + id);
            if (modal && content) {
                content.classList.remove('scale-100', 'opacity-100');
                content.classList.add('scale-95', 'opacity-0');
                setTimeout(() => {
                    modal.classList.remove('flex');
                    modal.classList.add('hidden');
                }, 300);
            }
        }

        // Live Search Filter Script
        document.getElementById('searchInput')?.addEventListener('input', function() {
            const val = this.value.toLowerCase();
            document.querySelectorAll('.asset-card').forEach(card => {
                const searchData = card.getAttribute('data-search') || '';
                card.style.display = searchData.includes(val) ? 'flex' : 'none';
            });
            document.querySelectorAll('.asset-row').forEach(row => {
                const searchData = row.getAttribute('data-search') || '';
                row.style.display = searchData.includes(val) ? '' : 'none';
            });
        });
    </script>
</body>
</html>