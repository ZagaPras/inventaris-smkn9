<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Barang - SMKN 9</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-slate-50 font-sans min-h-screen flex flex-col md:flex-row text-slate-800 relative">
    @include('alert')    
    @include('sidebar')
    
    <main class="flex-1 p-4 sm:p-6 md:p-10 overflow-y-auto w-full">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6 md:mb-8">
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-black text-slate-900 tracking-tight">Kelola Aset Barang</h1>
        </div>

        {{-- Form Input Aset Baru --}}
        <div class="bg-white p-5 sm:p-6 md:p-8 rounded-2xl shadow-sm border border-slate-200 mb-8 md:mb-10 transition duration-300">
            <h2 class="text-lg sm:text-xl font-bold text-slate-900 mb-5 sm:mb-6 flex items-center gap-2">
                <span class="bg-slate-900 text-white w-7 h-7 sm:w-8 sm:h-8 flex items-center justify-center rounded-lg text-xs sm:text-sm font-bold">+</span> Input Aset Baru
            </h2>
            
            <form action="{{ url('/admin/barang/tambah') }}" method="POST" class="grid grid-cols-1 md:grid-cols-3 gap-4 sm:gap-5">
                @csrf
                
                <select name="ruangan_id" class="p-3.5 sm:p-4 border border-slate-300 rounded-xl bg-slate-50 text-slate-900 text-sm outline-none focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all cursor-pointer" required>
                    <option value="">-- Pilih Ruangan --</option>
                    @foreach($ruangans as $r)
                        <option value="{{ $r->id }}">{{ $r->nama_ruangan }}</option>
                    @endforeach
                </select>
                <input type="text" name="nama_barang" placeholder="Nama Barang" class="p-3.5 sm:p-4 border border-slate-300 rounded-xl bg-slate-50 text-slate-900 text-sm outline-none focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all" required>
                
                <input type="text" name="merk" placeholder="Merk Barang (Opsional)" class="p-3.5 sm:p-4 border border-slate-300 rounded-xl bg-slate-50 text-slate-900 text-sm outline-none focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all">
                
                <input type="text" name="kode_barang" placeholder="Kode Aset" class="p-3.5 sm:p-4 border border-slate-300 rounded-xl bg-slate-50 text-slate-900 text-sm outline-none focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all font-mono" required>
                <input type="number" name="jumlah" placeholder="Jumlah" class="p-3.5 sm:p-4 border border-slate-300 rounded-xl bg-slate-50 text-slate-900 text-sm outline-none focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all" required>
                <select name="kondisi" class="p-3.5 sm:p-4 border border-slate-300 rounded-xl bg-slate-50 text-slate-900 text-sm outline-none focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all cursor-pointer" required>
                    <option value="Baik">Baik</option>
                    <option value="Rusak Ringan">Rusak Ringan</option>
                    <option value="Rusak Berat">Rusak Berat</option>
                </select>
                
                <div class="md:col-span-3">
                    <textarea name="spesifikasi" placeholder="Spesifikasi Lengkap (Wajib Diisi)" class="w-full p-3.5 sm:p-4 border border-slate-300 rounded-xl bg-slate-50 text-slate-900 text-sm outline-none focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all" rows="2" required></textarea>
                </div>

                <div class="md:col-span-3">
                    <textarea name="keterangan" placeholder="Keterangan Tambahan (Opsional)" class="w-full p-3.5 sm:p-4 border border-slate-300 rounded-xl bg-slate-50 text-slate-900 text-sm outline-none focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all" rows="2"></textarea>
                </div>
                
                <button type="submit" class="md:col-span-3 mt-2 bg-slate-900 text-white font-bold rounded-xl py-3.5 sm:py-4 border border-slate-800 hover:bg-slate-800 hover:border-blue-400 hover:shadow-[0_0_20px_rgba(96,165,250,0.6)] hover:-translate-y-0.5 transition-all duration-300 text-sm sm:text-base">
                    Simpan Data Aset
                </button>
            </form>
        </div>

        {{-- Tampilan Card khusus Mobile (Layar HP) --}}
        <div class="grid grid-cols-1 gap-4 md:hidden mb-8">
            @foreach($barangs as $b)
            <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex flex-col justify-between">
                <div>
                    <div class="flex justify-between items-start gap-2 mb-2">
                        <span class="font-mono text-xs font-bold text-slate-500 bg-slate-100 px-2 py-1 rounded">{{ $b->kode_barang }}</span>
                        <span class="px-2.5 py-1 rounded-lg text-xs font-bold border inline-block
                            {{ $b->kondisi == 'Baik' ? 'bg-green-50 text-green-700 border-green-200' : '' }}
                            {{ $b->kondisi == 'Rusak Ringan' ? 'bg-amber-50 text-amber-700 border-amber-200' : '' }}
                            {{ $b->kondisi == 'Rusak Berat' ? 'bg-red-50 text-red-700 border-red-200' : '' }}
                        ">
                            {{ $b->kondisi }}
                        </span>
                    </div>
                    <h3 class="font-bold text-slate-900 text-base capitalize mb-1">{{ $b->nama_barang }}</h3>
                    <p class="text-xs text-slate-500 mb-2">Ruang: <strong class="text-slate-700">{{ $b->nama_ruangan ?? '-' }}</strong></p>
                    <div class="text-xs text-slate-500 mb-4 flex items-center justify-between">
                        <span>Merk: <strong class="text-slate-700">{{ $b->merk ?: '-' }}</strong></span>
                        <span>Jumlah: <strong class="text-slate-900 text-sm">{{ $b->jumlah }}</strong></span>
                    </div>
                </div>

                <div class="flex items-center gap-2 pt-3 border-t border-slate-100">
                    <button type="button" onclick="openModal('{{ $b->id }}')" class="flex-1 bg-blue-50 text-blue-600 border border-blue-200 py-2 rounded-lg font-bold text-xs text-center">Detail</button>
                    <a href="{{ url('/admin/barang/edit/' . $b->id) }}" class="flex-1 bg-amber-50 text-amber-600 border border-amber-200 py-2 rounded-lg font-bold text-xs text-center">Edit</a>
                    <a href="{{ url('/admin/barang/hapus/' . $b->id) }}" onclick="return confirm('Apakah Anda yakin ingin menghapus aset barang ini?')" class="flex-1 bg-red-50 text-red-600 border border-red-200 py-2 rounded-lg font-bold text-xs text-center">Hapus</a>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Tampilan Tabel untuk Tablet & Desktop --}}
        <div class="hidden md:block bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse min-w-[900px]">
                    <thead>
                        <tr class="bg-slate-900 text-white text-xs font-bold uppercase tracking-widest border-b border-slate-800">
                            <th class="p-5 pl-8 w-[15%] whitespace-nowrap">Kode Barang</th>
                            <th class="p-5 w-[25%] whitespace-nowrap">Nama Barang</th>
                            <th class="p-5 w-[15%] whitespace-nowrap">Merk</th>
                            <th class="p-5 text-center w-[10%] whitespace-nowrap">Jumlah</th>
                            <th class="p-5 text-center w-[15%] whitespace-nowrap">Kondisi</th>
                            <th class="p-5 text-center pr-8 w-[20%] whitespace-nowrap">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm">
                        @foreach($barangs as $b)
                        <tr class="hover:bg-blue-50/50 transition-colors duration-200">
                            <td class="p-5 pl-8 font-mono text-sm text-slate-500 font-bold whitespace-nowrap">{{ $b->kode_barang }}</td>
                            
                            <td class="p-4">
                                <div class="font-bold text-slate-800 capitalize">{{ $b->nama_barang }}</div>
                            </td>

                            <td class="p-4 font-semibold text-slate-600">
                                {{ $b->merk ?: '-' }}
                            </td>
                            
                            <td class="p-5 text-center text-base font-black text-slate-900 whitespace-nowrap">{{ $b->jumlah }}</td>
                            
                            <td class="p-5 text-center whitespace-nowrap">
                                <span class="px-3 py-1.5 rounded-lg text-xs font-bold border inline-block
                                    {{ $b->kondisi == 'Baik' ? 'bg-green-50 text-green-700 border-green-200' : '' }}
                                    {{ $b->kondisi == 'Rusak Ringan' ? 'bg-amber-50 text-amber-700 border-amber-200' : '' }}
                                    {{ $b->kondisi == 'Rusak Berat' ? 'bg-red-50 text-red-700 border-red-200' : '' }}
                                ">
                                    {{ $b->kondisi }}
                                </span>
                            </td>

                            <td class="p-5 text-center pr-8 whitespace-nowrap">
                                <button type="button" onclick="openModal('{{ $b->id }}')" class="inline-block bg-white text-blue-500 border border-slate-200 hover:border-blue-400 hover:bg-blue-50 hover:text-blue-600 px-3 py-2 rounded-lg font-bold text-xs hover:shadow-[0_5px_15px_rgba(59,130,246,0.3)] hover:-translate-y-0.5 transition-all duration-300 mr-1">Detail</button>
                                
                                <a href="{{ url('/admin/barang/edit/' . $b->id) }}" class="inline-block bg-white text-amber-500 border border-slate-200 hover:border-amber-400 hover:bg-amber-50 hover:text-amber-600 px-3 py-2 rounded-lg font-bold text-xs hover:shadow-[0_5px_15px_rgba(251,191,36,0.3)] hover:-translate-y-0.5 transition-all duration-300 mr-1">Edit</a>
                                <a href="{{ url('/admin/barang/hapus/' . $b->id) }}" onclick="return confirm('Apakah Anda yakin ingin menghapus aset barang ini?')" class="inline-block bg-white text-red-500 border border-slate-200 hover:border-red-400 hover:bg-red-50 hover:text-red-600 px-3 py-2 rounded-lg font-bold text-xs hover:shadow-[0_5px_15px_rgba(248,113,113,0.3)] hover:-translate-y-0.5 transition-all duration-300">Hapus</a> 
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Modal Detail Aset --}}
        @foreach($barangs as $b)
        <div id="modal-{{ $b->id }}" class="fixed inset-0 z-[99] hidden items-center justify-center p-4 overflow-x-hidden overflow-y-auto">
            <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" onclick="closeModal('{{ $b->id }}')"></div>

            <div class="relative bg-white rounded-2xl shadow-2xl max-w-md w-full p-5 sm:p-6 z-10 transform scale-95 opacity-0 transition-all duration-300 max-h-[90vh] flex flex-col" id="modal-content-{{ $b->id }}">
                
                <div class="flex items-center justify-between border-b border-slate-100 pb-3 sm:pb-4 mb-4 shrink-0">
                    <h3 class="text-base sm:text-lg font-bold text-slate-900 flex items-center gap-2">
                        <span class="bg-blue-100 text-blue-600 w-7 h-7 sm:w-8 sm:h-8 flex items-center justify-center rounded-lg text-sm">👁️</span>
                        Detail Aset
                    </h3>
                    <button type="button" onclick="closeModal('{{ $b->id }}')" class="text-slate-400 hover:text-red-500 hover:bg-red-50 transition p-1.5 rounded-xl">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <div class="space-y-4 text-left overflow-y-auto pr-1 flex-1">
                    <div>
                        <span class="text-[10px] sm:text-xs font-bold text-slate-400 uppercase tracking-wider">Nama Barang</span>
                        <p class="text-base sm:text-lg font-black text-slate-800 leading-tight mt-0.5 capitalize">{{ $b->nama_barang }}</p>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-3 sm:gap-4 bg-slate-50 p-3 rounded-xl border border-slate-100">
                        <div>
                            <span class="text-[10px] sm:text-xs font-bold text-slate-400 uppercase tracking-wider">Kode Aset</span>
                            <p class="text-xs sm:text-sm font-bold text-slate-700 mt-0.5 font-mono break-all">{{ $b->kode_barang }}</p>
                        </div>
                        <div>
                            <span class="text-[10px] sm:text-xs font-bold text-slate-400 uppercase tracking-wider">Merk / Brand</span>
                            <p class="text-xs sm:text-sm font-bold text-slate-700 mt-0.5">{{ $b->merk ?: '-' }}</p>
                        </div>
                    </div>

                    <div>
                        <label class="block text-[10px] sm:text-xs font-bold text-slate-400 uppercase tracking-wider mb-1.5">
                            Spesifikasi Lengkap
                        </label>
                        <div class="w-full bg-slate-50 border border-slate-100 rounded-xl px-3.5 py-2.5 sm:px-4 sm:py-3 text-xs sm:text-sm font-medium text-slate-700 whitespace-pre-line leading-normal break-words h-auto overflow-visible">{{ trim($b->spesifikasi ?? '-') }}</div>
                    </div>

                    <div>
                        <label class="block text-[10px] sm:text-xs font-bold text-slate-400 uppercase tracking-wider mb-1.5">
                            Keterangan Tambahan
                        </label>
                        <div class="w-full bg-slate-50 border border-slate-100 rounded-xl px-3.5 py-2.5 sm:px-4 sm:py-3 text-xs sm:text-sm font-medium text-slate-700 whitespace-pre-line leading-normal break-words h-auto overflow-visible">{{ trim($b->keterangan ?? '-') }}</div>
                    </div>

                    <div class="pt-3 sm:pt-4 border-t border-slate-100 flex items-center justify-between text-[11px] sm:text-xs text-slate-400">
                        <div class="flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span>Terakhir diperbarui:</span>
                        </div>
                        <span class="font-semibold text-slate-500">{{ \Carbon\Carbon::parse($b->updated_at)->translatedFormat('d F Y, H:i') }} WIB</span>
                    </div>
                </div>

                <div class="pt-3 sm:pt-4 border-t border-slate-100 shrink-0 mt-3">
                    <button type="button" onclick="closeModal('{{ $b->id }}')" class="w-full bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold py-2.5 sm:py-3 px-4 rounded-xl text-xs sm:text-sm transition-colors text-center">
                        Tutup
                    </button>
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
    </script>
</body>
</html>