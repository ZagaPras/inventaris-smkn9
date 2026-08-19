<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Ruangan - {{ $ruangan->nama_ruangan }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-slate-50 min-h-screen font-sans">
    @if(session('success'))
        <div id="toast-success" class="fixed top-5 right-5 z-[100] flex items-center w-full max-w-sm p-4 space-x-3 text-emerald-600 bg-white border-l-4 border-emerald-500 rounded-xl shadow-[0_10px_40px_-10px_rgba(0,0,0,0.1)] transition-all duration-500 translate-x-0" role="alert">
            <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 bg-emerald-100 rounded-lg">
                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            </div>
            <div class="text-sm font-bold flex-1">{{ session('success') }}</div>
            <button type="button" onclick="tutupToast('toast-success')" class="bg-white text-slate-400 hover:text-slate-900 rounded-lg p-1.5 hover:bg-slate-100 inline-flex h-8 w-8 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
    @endif

    @if(session('error') || $errors->any())
        <div id="toast-error" class="fixed top-5 right-5 z-[100] flex flex-col w-full max-w-md p-4 space-y-3 text-rose-600 bg-white border-l-4 border-rose-500 rounded-xl shadow-[0_10px_40px_-10px_rgba(0,0,0,0.1)] transition-all duration-500 translate-x-0" role="alert">
            <div class="flex items-center space-x-3">
                <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 bg-rose-100 rounded-lg">
                    <svg class="w-5 h-5 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div class="text-sm font-black flex-1 uppercase tracking-wider">Oops! Gagal Disimpan</div>
                <button type="button" onclick="tutupToast('toast-error')" class="bg-white text-slate-400 hover:text-slate-900 rounded-lg p-1.5 hover:bg-slate-100 inline-flex h-8 w-8 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            
            <div class="text-sm font-medium text-slate-600 pl-11">
                @if(session('error'))
                    <p>{{ session('error') }}</p>
                @endif
                
                @if($errors->any())
                    <ul class="list-disc space-y-1 ml-4 mt-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    @endif

    @php
        $user = Auth::user();
        $isAdmin = $user && ($user->role === 'admin' || $user->email === 'admin@gmail.com');
        $backUrl = $isAdmin ? url('/admin/ruangan') : url('/user/ruangan');
    @endphp

    <div class="max-w-7xl mx-auto px-4 sm:px-6 py-6 sm:py-8">
        
        <a href="{{ $backUrl }}" class="group inline-flex items-center gap-2 px-4 sm:px-5 py-2.5 bg-white border border-slate-200 rounded-xl text-xs sm:text-sm font-bold text-slate-600 hover:text-indigo-600 hover:border-indigo-300 hover:shadow-[0_5px_15px_rgba(99,102,241,0.15)] hover:-translate-y-0.5 transition-all duration-300 mb-6 sm:mb-8">
            <svg class="w-4 h-4 text-slate-400 group-hover:text-indigo-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            <span>Kembali ke {{ $isAdmin ? 'Kelola Ruangan' : 'Daftar Ruangan' }}</span>
        </a>

        <div class="bg-white rounded-2xl sm:rounded-[2rem] p-5 sm:p-8 border border-slate-100 shadow-sm mb-6 sm:mb-8 relative overflow-hidden">
            <div class="absolute top-0 right-0 -mt-4 -mr-4 w-32 h-32 bg-indigo-50 rounded-full blur-3xl opacity-60 pointer-events-none"></div>
            
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 relative z-10">
                <div>
                    <span class="px-3.5 py-1.5 bg-indigo-50 text-indigo-700 rounded-full text-xs font-black uppercase tracking-widest shadow-sm inline-block">
                        {{ $ruangan->kode_ruangan }}
                    </span>
                    <div class="mt-3 sm:mt-4 flex flex-wrap items-center gap-3 sm:gap-4">
                        <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">{{ $ruangan->nama_ruangan }}</h1>
                        
                        <a href="{{ route('admin.ruangan.cetak', $ruangan->id) }}" target="_blank" class="inline-flex items-center gap-2 px-3.5 py-2 bg-rose-600 hover:bg-rose-700 text-white text-xs sm:text-sm font-bold rounded-xl shadow-sm hover:shadow-md transition-all">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                            <span>Cetak PDF</span>
                        </a>
                    </div>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-4 gap-2 sm:gap-3 w-full md:w-auto">
                    <div class="bg-slate-50 px-3 sm:px-4 py-2.5 sm:py-3 rounded-2xl border border-slate-100 text-center">
                        <span class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-0.5">Panjang</span>
                        <span class="text-base sm:text-lg font-black text-slate-800">{{ $ruangan->panjang ?? '-' }}<span class="text-xs text-slate-500 font-medium ml-0.5">m</span></span>
                    </div>
                    <div class="bg-slate-50 px-3 sm:px-4 py-2.5 sm:py-3 rounded-2xl border border-slate-100 text-center">
                        <span class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-0.5">Lebar</span>
                        <span class="text-base sm:text-lg font-black text-slate-800">{{ $ruangan->lebar ?? '-' }}<span class="text-xs text-slate-500 font-medium ml-0.5">m</span></span>
                    </div>
                    <div class="bg-slate-50 px-3 sm:px-4 py-2.5 sm:py-3 rounded-2xl border border-slate-100 text-center">
                        <span class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-0.5">Tinggi</span>
                        <span class="text-base sm:text-lg font-black text-slate-800">{{ $ruangan->tinggi ?? '-' }}<span class="text-xs text-slate-500 font-medium ml-0.5">m</span></span>
                    </div>
                    <div class="bg-indigo-50 px-3 sm:px-5 py-2.5 sm:py-3 rounded-2xl border border-indigo-100 text-center shadow-sm">
                        <span class="block text-[10px] font-bold text-indigo-400 uppercase tracking-wider mb-0.5">Luas</span>
                        <span class="text-base sm:text-lg font-black text-indigo-700">{{ $ruangan->luas ?? '-' }}<span class="text-xs text-indigo-500 font-medium ml-0.5">m²</span></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex border-b border-slate-200 mb-6 gap-2 overflow-x-auto">
            <button onclick="switchTab('dokumentasi')" id="btn-dokumentasi" 
                    class="py-3 px-4 sm:px-6 text-xs sm:text-sm font-bold border-b-2 border-indigo-600 text-indigo-600 focus:outline-none transition whitespace-nowrap">
                📸 Dokumentasi Ruangan
            </button>
            <button onclick="switchTab('aset')" id="btn-aset" 
                    class="py-3 px-4 sm:px-6 text-xs sm:text-sm font-bold border-b-2 border-transparent text-slate-500 hover:text-slate-800 focus:outline-none transition whitespace-nowrap">
                📦 Daftar Aset Barang ({{ $barangs->count() }})
            </button>
        </div>

        <div id="tab-dokumentasi" class="block space-y-6">
            <div class="bg-white rounded-2xl sm:rounded-3xl p-5 sm:p-8 border border-slate-100 shadow-sm">
                <h3 class="text-base sm:text-lg font-bold text-slate-800 mb-4 sm:mb-6">Foto Kondisi Fisik 4 Sisi</h3>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
                    <div class="bg-slate-50 rounded-2xl p-3 border border-slate-100 text-center">
                        <span class="block text-xs font-bold text-slate-500 mb-2 sm:mb-3 tracking-wide">TAMPAK DEPAN</span>
                        <img src="{{ !empty($ruangan->foto_depan) ? asset('ruangan/' . basename($ruangan->foto_depan)) : 'https://via.placeholder.com/400x300?text=Tidak+Ada+Foto' }}" 
                             onerror="this.onerror=null; this.src='https://via.placeholder.com/400x300?text=Gambar+Tidak+Ditemukan';"
                             alt="Foto Depan" 
                             class="w-full h-40 sm:h-48 object-cover rounded-xl shadow-inner bg-slate-200">
                    </div>
                    <div class="bg-slate-50 rounded-2xl p-3 border border-slate-100 text-center">
                        <span class="block text-xs font-bold text-slate-500 mb-2 sm:mb-3 tracking-wide">TAMPAK BELAKANG</span>
                        <img src="{{ !empty($ruangan->foto_belakang) ? asset('ruangan/' . basename($ruangan->foto_belakang)) : 'https://via.placeholder.com/400x300?text=Tidak+Ada+Foto' }}" 
                             onerror="this.onerror=null; this.src='https://via.placeholder.com/400x300?text=Gambar+Tidak+Ditemukan';"
                             alt="Foto Belakang" 
                             class="w-full h-40 sm:h-48 object-cover rounded-xl shadow-inner bg-slate-200">
                    </div>
                    <div class="bg-slate-50 rounded-2xl p-3 border border-slate-100 text-center">
                        <span class="block text-xs font-bold text-slate-500 mb-2 sm:mb-3 tracking-wide">SAMPING KIRI</span>
                        <img src="{{ !empty($ruangan->foto_kiri) ? asset('ruangan/' . basename($ruangan->foto_kiri)) : 'https://via.placeholder.com/400x300?text=Tidak+Ada+Foto' }}" 
                             onerror="this.onerror=null; this.src='https://via.placeholder.com/400x300?text=Gambar+Tidak+Ditemukan';"
                             alt="Foto Kiri" 
                             class="w-full h-40 sm:h-48 object-cover rounded-xl shadow-inner bg-slate-200">
                    </div>
                    <div class="bg-slate-50 rounded-2xl p-3 border border-slate-100 text-center">
                        <span class="block text-xs font-bold text-slate-500 mb-2 sm:mb-3 tracking-wide">SAMPING KANAN</span>
                        <img src="{{ !empty($ruangan->foto_kanan) ? asset('ruangan/' . basename($ruangan->foto_kanan)) : 'https://via.placeholder.com/400x300?text=Tidak+Ada+Foto' }}" 
                             onerror="this.onerror=null; this.src='https://via.placeholder.com/400x300?text=Gambar+Tidak+Ditemukan';"
                             alt="Foto Kanan" 
                             class="w-full h-40 sm:h-48 object-cover rounded-xl shadow-inner bg-slate-200">
                    </div>
                </div>
            </div>
        </div>

        <div id="tab-aset" class="hidden">
            <div class="bg-white rounded-2xl sm:rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
                <div class="p-4 sm:p-6 border-b border-slate-50 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
                    <h3 class="text-base sm:text-lg font-bold text-slate-800">Barang Inventaris di Ruangan Ini</h3>
                    @if($isAdmin)
                    <button onclick="toggleModal('modalTambahBarang')" class="w-full sm:w-auto px-4 py-2.5 bg-indigo-600 text-white text-xs sm:text-sm font-bold rounded-xl hover:bg-indigo-700 shadow-sm hover:-translate-y-0.5 transition-all">
                        + Tambah Aset Sekaligus
                    </button>
                    @endif
                </div>

                {{-- Mobile View: Cards Layout --}}
                <div class="grid grid-cols-1 gap-3 md:hidden p-4">
                    @forelse($barangs as $b)
                    <div class="bg-slate-50 p-4 rounded-2xl border border-slate-200 flex flex-col justify-between gap-3">
                        <div>
                            <div class="flex justify-between items-start gap-2 mb-1.5">
                                <span class="font-mono text-xs font-bold text-indigo-600 bg-indigo-50 px-2 py-0.5 rounded border border-indigo-100">{{ $b->kode_barang }}</span>
                                <span class="px-2.5 py-1 rounded-lg text-xs font-bold border inline-block
                                    {{ $b->kondisi == 'Baik' ? 'bg-green-50 text-green-700 border-green-200' : '' }}
                                    {{ $b->kondisi == 'Rusak Ringan' ? 'bg-amber-50 text-amber-700 border-amber-200' : '' }}
                                    {{ $b->kondisi == 'Rusak Berat' ? 'bg-red-50 text-red-700 border-red-200' : '' }}
                                ">
                                    {{ $b->kondisi }}
                                </span>
                            </div>
                            <h4 class="font-bold text-slate-900 text-base capitalize">{{ $b->nama_barang }}</h4>
                            <p class="text-xs text-slate-500 mt-1">Jumlah: <strong class="text-slate-900 font-bold text-sm">{{ $b->jumlah }}</strong></p>
                        </div>

                        <div class="flex items-center gap-2 pt-2 border-t border-slate-100">
                            <button type="button" onclick="toggleModal('modalDetail{{ $b->id }}')" class="{{ $isAdmin ? 'flex-1' : 'w-full' }} text-center bg-indigo-50 text-indigo-600 border border-indigo-200 py-2.5 rounded-xl text-xs font-bold hover:bg-indigo-100 transition flex items-center justify-center gap-1.5 shadow-sm">
                                <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                <span>Lihat Detail</span>
                            </button>
                            @if($isAdmin)
                            <a href="{{ url('/admin/barang/edit/' . $b->id) }}" class="flex-1 text-center bg-amber-50 text-amber-600 border border-amber-100 py-2 rounded-xl text-xs font-bold hover:bg-amber-100 transition">Edit</a>
                            <form action="{{ route('barang.destroy', $b->id) }}" method="POST" class="flex-1 form-hapus">
                                @csrf
                                @method('DELETE')
                                <button type="button" onclick="konfirmasiHapus(event, this)" class="w-full text-center bg-red-50 text-red-600 border border-red-100 py-2 rounded-xl text-xs font-bold hover:bg-red-100 transition">Hapus</button>
                            </form>
                            @endif
                        </div>
                    </div>
                    @empty
                    <div class="p-8 text-center text-slate-400 font-medium text-sm">
                        📭 Belum ada aset barang yang terdaftar di ruangan ini.
                    </div>
                    @endforelse
                </div>

                {{-- Desktop View: Table Layout --}}
                <div class="hidden md:block overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-900 text-white text-xs font-bold uppercase tracking-wider">
                                <th class="p-4 pl-6">Kode Barang</th>
                                <th class="p-4">Nama Barang</th>
                                <th class="p-4 text-center">Jumlah</th>
                                <th class="p-4 text-center">Kondisi</th>
                                <th class="p-4 text-center pr-6">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm text-slate-700 divide-y divide-slate-100">
                            @forelse($barangs as $b)
                            <tr class="hover:bg-blue-50/50 transition-colors duration-200">
                                <td class="p-4 pl-6 font-semibold text-indigo-600">{{ $b->kode_barang }}</td>
                                <td class="p-4 font-bold text-slate-800 capitalize">{{ $b->nama_barang }}</td>
                                <td class="p-4 text-center font-bold text-lg">{{ $b->jumlah }}</td>
                                <td class="p-4 text-center whitespace-nowrap">
                                    <span class="px-3 py-1.5 rounded-lg text-xs font-bold border inline-block
                                        {{ $b->kondisi == 'Baik' ? 'bg-green-50 text-green-700 border-green-200' : '' }}
                                        {{ $b->kondisi == 'Rusak Ringan' ? 'bg-amber-50 text-amber-700 border-amber-200' : '' }}
                                        {{ $b->kondisi == 'Rusak Berat' ? 'bg-red-50 text-red-700 border-red-200' : '' }}
                                    ">
                                        {{ $b->kondisi }}
                                    </span>
                                </td>
                                <td class="p-4 text-center pr-6 whitespace-nowrap">
                                    <button type="button" onclick="toggleModal('modalDetail{{ $b->id }}')" class="inline-block bg-white text-indigo-500 border border-slate-200 hover:border-indigo-400 hover:bg-indigo-50 hover:text-indigo-600 px-4 py-2 rounded-lg font-bold text-xs hover:shadow-[0_5px_15px_rgba(99,102,241,0.3)] hover:-translate-y-0.5 transition-all duration-300 mr-1">Detail</button>
                                    @if($isAdmin)
                                    <a href="{{ url('/admin/barang/edit/' . $b->id) }}" class="inline-block bg-white text-amber-500 border border-slate-200 hover:border-amber-400 hover:bg-amber-50 hover:text-amber-600 px-4 py-2 rounded-lg font-bold text-xs hover:shadow-[0_5px_15px_rgba(251,191,36,0.3)] hover:-translate-y-0.5 transition-all duration-300 mr-1">Edit</a>
                                    <form action="{{ route('barang.destroy', $b->id) }}" method="POST" class="inline-block form-hapus">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" onclick="konfirmasiHapus(event, this)" class="inline-block bg-white text-red-500 border border-slate-200 hover:border-red-400 hover:bg-red-50 hover:text-red-600 px-4 py-2 rounded-lg font-bold text-xs hover:shadow-[0_5px_15px_rgba(248,113,113,0.3)] hover:-translate-y-0.5 transition-all duration-300">Hapus</button>
                                    </form>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="p-10 text-center text-slate-400 bg-slate-50 font-medium">
                                    📭 Belum ada aset barang yang terdaftar di ruangan ini.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div id="modalTambahBarang" class="fixed inset-0 z-50 hidden bg-slate-900/50 backdrop-blur-sm flex items-center justify-center p-4 overflow-y-auto">
        <div class="bg-white w-full max-w-5xl rounded-3xl shadow-xl flex flex-col max-h-[90vh]">
            
            <div class="p-6 border-b border-slate-100 flex justify-between items-center">
                <h2 class="text-xl font-black text-slate-800">Tambah Aset Barang</h2>
                <button onclick="toggleModal('modalTambahBarang')" class="text-slate-400 hover:text-rose-500 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <form action="/admin/ruangan/{{ $ruangan->id }}/tambah-barang" method="POST" class="flex flex-col flex-1 overflow-hidden">
                @csrf
                <div class="p-6 overflow-y-auto flex-1 bg-slate-50/50">
                    <div id="wadah-form-barang" class="space-y-4">
                        
                        <div class="baris-input-barang bg-white p-5 rounded-2xl border border-slate-200 shadow-sm relative transition-all duration-300">
                            <div class="grid grid-cols-12 gap-4 items-start mb-4">
                                <div class="col-span-12 md:col-span-3">
                                    <label class="block text-xs font-bold text-slate-500 mb-1.5">Kode Barang</label>
                                    <input type="text" name="kode_barang[]" required class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:bg-white outline-none transition">
                                </div>
                                <div class="col-span-12 md:col-span-4">
                                    <label class="block text-xs font-bold text-slate-500 mb-1.5">Nama Barang</label>
                                    <input type="text" name="nama_barang[]" required class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:bg-white outline-none transition">
                                </div>
                                <div class="col-span-12 md:col-span-3">
                                    <label class="block text-xs font-bold text-slate-500 mb-1.5">Merk <span class="font-normal text-slate-400">(Opsional)</span></label>
                                    <input type="text" name="merk[]" class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:bg-white outline-none transition">
                                </div>
                                <div class="col-span-12 md:col-span-2">
                                    <label class="block text-xs font-bold text-slate-500 mb-1.5">Jumlah</label>
                                    <input type="number" name="jumlah[]" min="1" value="1" required class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:bg-white outline-none transition">
                                </div>
                            </div>

                            <div class="grid grid-cols-12 gap-4 items-end">
                                <div class="col-span-12 md:col-span-3">
                                    <label class="block text-xs font-bold text-slate-500 mb-1.5">Kondisi</label>
                                    <select name="kondisi[]" required class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:bg-white outline-none transition cursor-pointer">
                                        <option value="Baik">Baik</option>
                                        <option value="Rusak Ringan">Rusak Ringan</option>
                                        <option value="Rusak Berat">Rusak Berat</option>
                                    </select>
                                </div>
                                <div class="col-span-12 md:col-span-4">
                                    <label class="block text-xs font-bold text-slate-500 mb-1.5">Spesifikasi (Wajib)</label>
                                    <input type="text" name="spesifikasi[]" required placeholder="Cth: Core i5, RAM 8GB" class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:bg-white outline-none transition">
                                </div>
                                <div class="col-span-12 md:col-span-4">
                                    <label class="block text-xs font-bold text-slate-500 mb-1.5">Keterangan (Opsional)</label>
                                    <input type="text" name="keterangan[]" placeholder="Tambahkan keterangan opsional..." class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:bg-white outline-none transition">
                                </div>
                                <div class="col-span-12 md:col-span-1 flex justify-center pb-1">
                                    <button type="button" onclick="hapusBaris(this)" class="p-2 text-rose-400 hover:text-rose-600 hover:bg-rose-50 rounded-xl transition" title="Hapus Baris">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    
                    <button type="button" onclick="tambahBaris()" class="mt-4 w-full py-3 border-2 border-dashed border-slate-300 text-slate-500 font-bold text-sm rounded-2xl hover:border-indigo-400 hover:text-indigo-600 hover:bg-indigo-50/50 transition flex justify-center items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Tambah Baris Barang Lain
                    </button>
                </div>

                <div class="p-6 border-t border-slate-100 bg-white flex justify-end gap-3 rounded-b-3xl">
                    <button type="button" onclick="toggleModal('modalTambahBarang')" class="px-6 py-2.5 bg-slate-100 text-slate-600 text-sm font-bold rounded-xl hover:bg-slate-200 transition">
                        Batal
                    </button>
                    <button type="submit" class="px-6 py-2.5 bg-indigo-600 text-white text-sm font-bold rounded-xl hover:bg-indigo-700 shadow-sm transition">
                        Simpan Semua Barang
                    </button>
                </div>
            </form>
        </div>
    </div>

    @foreach($barangs as $b)
    <div id="modalDetail{{ $b->id }}" class="fixed inset-0 z-[60] hidden bg-slate-900/50 backdrop-blur-sm flex items-center justify-center p-4 overflow-y-auto">
        <div class="bg-white w-full max-w-md rounded-3xl shadow-xl flex flex-col overflow-hidden">
            <div class="p-5 border-b border-slate-100 flex justify-between items-center bg-slate-50">
                <h2 class="text-lg font-black text-slate-800">👁️ Detail Aset</h2>
                <button onclick="toggleModal('modalDetail{{ $b->id }}')" class="text-slate-400 hover:text-rose-500 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <div class="p-6 space-y-5">
                <div>
                    <span class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">NAMA BARANG</span>
                    <strong class="text-xl text-slate-800 capitalize">{{ $b->nama_barang }}</strong>
                </div>
                
                <div class="flex gap-4 p-4 bg-slate-50 rounded-2xl border border-slate-100">
                    <div class="flex-1 border-r border-slate-200">
                        <span class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">KODE ASET</span>
                        <strong class="text-slate-700">{{ $b->kode_barang }}</strong>
                    </div>
                    <div class="flex-1 pl-2">
                        <span class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">MERK / BRAND</span>
                        <strong class="text-slate-700">{{ $b->merk ?? '-' }}</strong>
                    </div>
                </div>

                <div class="mb-5">
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">
                        Spesifikasi Lengkap
                    </label>
                    {{-- Tuliskan {{ trim(...) }} persis menempel pada tag div (tanpa enter/spasi) --}}
                    <div class="w-full bg-slate-50 border border-slate-100 rounded-xl px-4 py-3 text-sm font-medium text-slate-700 whitespace-pre-line leading-normal break-words">{{ trim($b->spesifikasi ?? '-') }}</div>
                </div>

                <div class="mb-5">
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">
                        Keterangan Tambahan
                    </label>
                    <div class="w-full bg-slate-50 border border-slate-100 rounded-xl px-4 py-3 text-sm font-medium text-slate-700 whitespace-pre-line leading-normal break-words">{{ trim($b->keterangan ?? '-') }}</div>
                </div>

                <div class="pt-4 mt-2 border-t border-slate-100 flex items-center justify-between text-xs text-slate-400">
                    <div class="flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>Terakhir diperbarui:</span>
                    </div>
                    <span class="font-semibold text-slate-500">{{ \Carbon\Carbon::parse($b->updated_at)->translatedFormat('d F Y, H:i') }} WIB</span>
                </div>
            </div>
            
            <div class="p-5 border-t border-slate-100 bg-white flex justify-end">
                <button onclick="toggleModal('modalDetail{{ $b->id }}')" class="px-5 py-2 bg-slate-100 text-slate-600 text-sm font-bold rounded-xl hover:bg-slate-200 transition">
                    Tutup
                </button>
            </div>
        </div>
    </div>
    @endforeach

    <script>
        // --- SCRIPT UNTUK TAB NAVIGASI ---
        function switchTab(tabName) {
            const tabDokumen = document.getElementById('tab-dokumentasi');
            const tabAset = document.getElementById('tab-aset');
            const btnDokumen = document.getElementById('btn-dokumentasi');
            const btnAset = document.getElementById('btn-aset');

            if(tabName === 'dokumentasi') {
                tabDokumen.classList.remove('hidden');
                tabAset.classList.add('hidden');
                btnDokumen.className = "py-3 px-6 text-sm font-bold border-b-2 border-indigo-600 text-indigo-600 focus:outline-none transition";
                btnAset.className = "py-3 px-6 text-sm font-bold border-b-2 border-transparent text-slate-500 hover:text-slate-800 focus:outline-none transition";
            } else {
                tabDokumen.classList.add('hidden');
                tabAset.classList.remove('hidden');
                btnAset.className = "py-3 px-6 text-sm font-bold border-b-2 border-indigo-600 text-indigo-600 focus:outline-none transition";
                btnDokumen.className = "py-3 px-6 text-sm font-bold border-b-2 border-transparent text-slate-500 hover:text-slate-800 focus:outline-none transition";
            }
        }

        // --- SCRIPT UNTUK MODAL & DYNAMIC FORM ---
        function toggleModal(modalId) {
            const modal = document.getElementById(modalId);
            modal.classList.toggle('hidden');
        }

        function tambahBaris() {
            const wadah = document.getElementById('wadah-form-barang');
            const template = wadah.querySelector('.baris-input-barang');
            const barisBaru = template.cloneNode(true);
            
            const inputs = barisBaru.querySelectorAll('input');
            inputs.forEach(input => {
                if(input.type === 'number') {
                    input.value = 1;
                } else {
                    input.value = '';
                }
            });

            barisBaru.classList.add('opacity-0');
            wadah.appendChild(barisBaru);
            
            setTimeout(() => {
                barisBaru.classList.remove('opacity-0');
                barisBaru.classList.add('transition-opacity', 'duration-300');
            }, 10);
        }

        function hapusBaris(btn) {
            const wadah = document.getElementById('wadah-form-barang');
            if (wadah.querySelectorAll('.baris-input-barang').length > 1) {
                const baris = btn.closest('.baris-input-barang');
                baris.remove();
            } else {
                alert('Minimal harus ada 1 baris barang yang diinput!');
            }
        }

        // --- SCRIPT UNTUK NOTIFIKASI TOAST ---
        function tutupToast(id) {
            const toast = document.getElementById(id);
            if (toast) {
                toast.classList.add('opacity-0', 'translate-x-full');
                setTimeout(() => toast.remove(), 500);
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            setTimeout(() => {
                tutupToast('toast-success');
                tutupToast('toast-error');
            }, 6000);
        });

        // --- SCRIPT UNTUK KONFIRMASI HAPUS SWEETALERT2 ---
        function konfirmasiHapus(event, button) {
            event.preventDefault(); 
            const form = button.closest('.form-hapus'); 

            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data aset barang ini akan dihapus permanen dari ruangan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#EF4444', 
                cancelButtonColor: '#94A3B8',  
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                customClass: {
                    popup: 'rounded-2xl'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit(); 
                }
            });
        }
    </script>
</body>
</html>