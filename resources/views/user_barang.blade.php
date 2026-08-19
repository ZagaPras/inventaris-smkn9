<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Aset Barang - SMKN 9</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-slate-50 font-sans min-h-screen flex flex-col md:flex-row text-slate-800 relative">
    @include('alert')    
    @include('sidebar')

    <main class="flex-1 p-4 sm:p-6 md:p-10 overflow-y-auto w-full">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 sm:gap-4 mb-6 md:mb-8">
            <div>
                <h1 class="text-2xl sm:text-3xl md:text-4xl font-black text-slate-900 tracking-tight flex items-center gap-2">
                    <span>📦</span> Daftar Aset Barang
                </h1>
                <p class="text-xs sm:text-sm text-slate-500 mt-1">Daftar fasilitas & aset barang terdaftar di SMKN 9 Semarang</p>
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
                <input type="text" id="searchUserBarang" placeholder="Cari nama, kode barang, merk, atau ruangan..." class="w-full pl-9 pr-4 py-2.5 bg-white border border-slate-200 rounded-xl text-xs sm:text-sm text-slate-700 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all shadow-sm">
                <svg class="w-4 h-4 text-slate-400 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
        </div>

        {{-- Tampilan Card Khusus Mobile (Layar HP) --}}
        <div class="grid grid-cols-1 gap-3.5 md:hidden mb-8" id="userBarangCardsContainer">
            @forelse($barangs as $b)
            <div class="user-barang-card bg-white p-4 sm:p-5 rounded-2xl border border-slate-200 shadow-sm flex flex-col justify-between gap-3 hover:border-blue-300 transition-all" data-search="{{ strtolower($b->nama_barang . ' ' . $b->kode_barang . ' ' . ($b->merk ?? '') . ' ' . ($b->nama_ruangan ?? '')) }}">
                <div>
                    <div class="flex justify-between items-start gap-2 mb-2">
                        <span class="font-mono text-xs font-bold text-slate-600 bg-slate-100 px-2.5 py-1 rounded-lg border border-slate-200">{{ $b->kode_barang }}</span>
                        <span class="px-2.5 py-1 rounded-lg text-xs font-bold border 
                            {{ $b->kondisi == 'Baik' ? 'bg-emerald-50 text-emerald-600 border-emerald-200' : '' }}
                            {{ $b->kondisi == 'Rusak Ringan' ? 'bg-amber-50 text-amber-600 border-amber-200' : '' }}
                            {{ $b->kondisi == 'Rusak Berat' ? 'bg-rose-50 text-rose-600 border-rose-200' : '' }}
                        ">
                            {{ $b->kondisi }}
                        </span>
                    </div>
                    <h3 class="font-bold text-slate-900 text-base capitalize mb-1.5 leading-snug">{{ $b->nama_barang }}</h3>
                    
                    <div class="bg-slate-50 p-2.5 rounded-xl border border-slate-100 space-y-1 text-xs mb-1">
                        <div class="flex justify-between text-slate-600">
                            <span>Lokasi Ruangan:</span>
                            <strong class="text-slate-800 font-semibold">{{ $b->nama_ruangan ?? '-' }}</strong>
                        </div>
                        <div class="flex justify-between text-slate-600">
                            <span>Merk:</span>
                            <strong class="text-slate-800 font-semibold">{{ $b->merk ?: '-' }}</strong>
                        </div>
                        <div class="flex justify-between text-slate-600">
                            <span>Jumlah:</span>
                            <strong class="text-slate-900 font-bold">{{ $b->jumlah }} unit</strong>
                        </div>
                    </div>
                </div>

                <div class="pt-2 border-t border-slate-100">
                    <button type="button" onclick="openModal('{{ $b->id }}')" class="w-full bg-blue-50 hover:bg-blue-100 text-blue-600 border border-blue-200 py-2.5 rounded-xl font-bold text-xs text-center flex items-center justify-center gap-1.5 transition-colors shadow-sm">
                        <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        <span>Lihat Detail Aset</span>
                    </button>
                </div>
            </div>
            @empty
            <div class="bg-white p-8 rounded-2xl border border-slate-200 text-center text-slate-400 italic text-sm">
                Belum ada data barang yang terdaftar.
            </div>
            @endforelse
        </div>

        {{-- Tampilan Tabel untuk Tablet & Desktop --}}
        <div class="hidden md:block bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden mb-8">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-900 text-white text-xs font-bold uppercase tracking-widest border-b border-slate-800">
                            <th class="p-5 pl-8">Kode Barang</th>
                            <th class="p-5">Nama Barang</th>
                            <th class="p-5">Lokasi Ruangan</th>
                            <th class="p-5">Merk</th>
                            <th class="p-5 text-center">Jumlah</th>
                            <th class="p-5">Kondisi</th>
                            <th class="p-5 text-center pr-8">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm">
                        @forelse($barangs as $b)
                        <tr class="user-barang-row hover:bg-slate-50 transition-colors duration-200" data-search="{{ strtolower($b->nama_barang . ' ' . $b->kode_barang . ' ' . ($b->merk ?? '') . ' ' . ($b->nama_ruangan ?? '')) }}">
                            <td class="p-5 pl-8 font-mono text-xs text-slate-600 font-bold">{{ $b->kode_barang }}</td>
                            
                            <td class="p-4">
                                <div class="font-bold text-slate-800 capitalize">{{ $b->nama_barang }}</div>
                            </td>

                            <td class="p-4 font-semibold text-slate-600">
                                {{ $b->nama_ruangan ?? '-' }}
                            </td>

                            <td class="p-4 font-semibold text-slate-600">
                                {{ $b->merk ?: '-' }}
                            </td>
                            
                            <td class="p-5 text-center text-base font-black text-slate-900">{{ $b->jumlah }}</td>
                            <td class="p-5">
                                <span class="px-3 py-1.5 rounded-lg text-xs font-bold border 
                                    {{ $b->kondisi == 'Baik' ? 'bg-emerald-50 text-emerald-600 border-emerald-200' : '' }}
                                    {{ $b->kondisi == 'Rusak Ringan' ? 'bg-amber-50 text-amber-600 border-amber-200' : '' }}
                                    {{ $b->kondisi == 'Rusak Berat' ? 'bg-rose-50 text-rose-600 border-rose-200' : '' }}
                                ">
                                    {{ $b->kondisi }}
                                </span>
                            </td>
                            <td class="p-5 text-center pr-8 whitespace-nowrap">
                                <button type="button" onclick="openModal('{{ $b->id }}')" class="inline-flex items-center justify-center gap-1.5 bg-white text-blue-600 border border-slate-200 hover:border-blue-400 hover:bg-blue-50 px-4 py-2 rounded-lg font-bold text-xs hover:shadow-md transition-all duration-300">
                                    <svg class="w-3.5 h-3.5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    <span>Lihat Detail</span>
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="p-8 text-center text-slate-400 italic">Belum ada data barang yang terdaftar.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Modal Detail Aset --}}
        @foreach($barangs as $b)
        <div id="modal-{{ $b->id }}" class="fixed inset-0 z-50 hidden items-center justify-center p-3 sm:p-4 overflow-x-hidden overflow-y-auto">
            <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" onclick="closeModal('{{ $b->id }}')"></div>

            <div class="relative bg-white rounded-2xl sm:rounded-3xl shadow-2xl max-w-md w-full p-5 sm:p-6 z-10 transform scale-95 opacity-0 transition-all duration-300 max-h-[90vh] flex flex-col" id="modal-content-{{ $b->id }}">
                
                <div class="flex items-center justify-between border-b border-slate-100 pb-3 mb-3 shrink-0">
                    <h3 class="text-base sm:text-lg font-bold text-slate-900 flex items-center gap-2">
                        <span class="bg-blue-100 text-blue-600 w-8 h-8 flex items-center justify-center rounded-xl text-sm">📦</span>
                        Detail Aset Barang
                    </h3>
                    <button type="button" onclick="closeModal('{{ $b->id }}')" class="text-slate-400 hover:text-red-500 hover:bg-red-50 transition p-1.5 rounded-xl">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <div class="space-y-3.5 text-left overflow-y-auto pr-1">
                    <div>
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Nama Barang</span>
                        <p class="text-base sm:text-lg font-black text-slate-800 leading-tight mt-0.5 capitalize">{{ $b->nama_barang }}</p>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-3 bg-slate-50 p-3 rounded-xl border border-slate-100">
                        <div>
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Kode Aset</span>
                            <p class="text-xs sm:text-sm font-bold text-slate-700 mt-0.5 font-mono">{{ $b->kode_barang }}</p>
                        </div>
                        <div>
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Merk / Brand</span>
                            <p class="text-xs sm:text-sm font-bold text-slate-700 mt-0.5">{{ $b->merk ?: '-' }}</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-3 bg-slate-50 p-3 rounded-xl border border-slate-100">
                        <div>
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Lokasi Ruangan</span>
                            <p class="text-xs sm:text-sm font-bold text-slate-700 mt-0.5">{{ $b->nama_ruangan ?? '-' }}</p>
                        </div>
                        <div>
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Jumlah</span>
                            <p class="text-xs sm:text-sm font-bold text-slate-700 mt-0.5">{{ $b->jumlah }} unit</p>
                        </div>
                    </div>

                    <div>
                        <span class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Spesifikasi Lengkap</span>
                        <div class="p-3 bg-slate-50 rounded-xl border border-slate-100 text-xs sm:text-sm text-slate-600 min-h-[50px] whitespace-pre-line leading-relaxed">
                            {{ $b->spesifikasi ?: '-' }}
                        </div>
                    </div>

                    <div>
                        <span class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Keterangan Tambahan</span>
                        <div class="p-3 bg-slate-50 rounded-xl border border-slate-100 text-xs sm:text-sm text-slate-600 min-h-[50px] whitespace-pre-line leading-relaxed">
                            {{ $b->keterangan ?: '-' }}
                        </div>
                    </div>

                    <div class="pt-3 mt-1 border-t border-slate-100 flex items-center justify-between text-[11px] text-slate-400">
                        <span>Terakhir diperbarui:</span>
                        <span class="font-semibold text-slate-500">{{ \Carbon\Carbon::parse($b->updated_at)->translatedFormat('d F Y, H:i') }} WIB</span>
                    </div>
                    
                </div>
            </div>
        </div>
        @endforeach
    </main>

    <script>
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

        document.getElementById('searchUserBarang')?.addEventListener('input', function() {
            const val = this.value.toLowerCase();
            document.querySelectorAll('.user-barang-card').forEach(card => {
                const searchData = card.getAttribute('data-search') || '';
                card.style.display = searchData.includes(val) ? 'flex' : 'none';
            });
            document.querySelectorAll('.user-barang-row').forEach(row => {
                const searchData = row.getAttribute('data-search') || '';
                row.style.display = searchData.includes(val) ? '' : 'none';
            });
        });
    </script>
</body>
</html>