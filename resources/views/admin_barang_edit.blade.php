<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Barang - SMKN 9</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-slate-50 font-sans min-h-screen flex flex-col md:flex-row text-slate-800 relative">
    @include('alert')
    @include('sidebar')
    
    <main class="flex-1 p-4 sm:p-6 md:p-10 overflow-y-auto w-full">
        <h1 class="text-2xl sm:text-3xl md:text-4xl font-black text-slate-900 tracking-tight mb-6 md:mb-8">Edit Aset Barang</h1>
        
        <div class="bg-white p-5 sm:p-6 md:p-8 rounded-2xl shadow-sm border border-slate-200">
            <form action="{{ url('/admin/barang/update/' . $barang->id) }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-5 md:gap-6">
                @csrf
                
                <div class="md:col-span-2">
                    <label class="block text-xs sm:text-sm font-bold text-slate-700 mb-1.5 sm:mb-2">Lokasi Ruangan</label>
                    <select name="ruangan_id" class="w-full p-3.5 sm:p-4 border border-slate-300 rounded-xl bg-slate-50 text-slate-900 text-sm outline-none focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all cursor-pointer" required>
                        @foreach($ruangans as $r)
                            <option value="{{ $r->id }}" {{ $r->id == $barang->ruangan_id ? 'selected' : '' }}>
                                {{ $r->nama_ruangan }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs sm:text-sm font-bold text-slate-700 mb-1.5 sm:mb-2">Nama Barang</label>
                    <input type="text" name="nama_barang" value="{{ $barang->nama_barang }}" placeholder="Nama Barang" class="w-full p-3.5 sm:p-4 border border-slate-300 rounded-xl bg-slate-50 text-slate-900 text-sm outline-none focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all" required>
                </div>
                <div>
                    <label class="block text-xs sm:text-sm font-bold text-slate-700 mb-1.5 sm:mb-2">Merk (Opsional)</label>
                    <input type="text" name="merk" value="{{ $barang->merk }}" placeholder="Merk Barang" class="w-full p-3.5 sm:p-4 border border-slate-300 rounded-xl bg-slate-50 text-slate-900 text-sm outline-none focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all">
                </div>

                <div>
                    <label class="block text-xs sm:text-sm font-bold text-slate-700 mb-1.5 sm:mb-2">Kode Aset</label>
                    <input type="text" name="kode_barang" value="{{ $barang->kode_barang }}" placeholder="Kode Aset" class="w-full p-3.5 sm:p-4 border border-slate-300 rounded-xl bg-slate-50 text-slate-900 text-sm outline-none focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all font-mono" required>
                </div>
                <div>
                    <label class="block text-xs sm:text-sm font-bold text-slate-700 mb-1.5 sm:mb-2">Jumlah</label>
                    <input type="number" name="jumlah" value="{{ $barang->jumlah }}" placeholder="Jumlah" class="w-full p-3.5 sm:p-4 border border-slate-300 rounded-xl bg-slate-50 text-slate-900 text-sm outline-none focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all" required>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-xs sm:text-sm font-bold text-slate-700 mb-1.5 sm:mb-2">Kondisi</label>
                    <select name="kondisi" class="w-full p-3.5 sm:p-4 border border-slate-300 rounded-xl bg-slate-50 text-slate-900 text-sm outline-none focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all cursor-pointer" required>
                        <option value="Baik" {{ $barang->kondisi == 'Baik' ? 'selected' : '' }}>Baik</option>
                        <option value="Rusak Ringan" {{ $barang->kondisi == 'Rusak Ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                        <option value="Rusak Berat" {{ $barang->kondisi == 'Rusak Berat' ? 'selected' : '' }}>Rusak Berat</option>
                    </select>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-xs sm:text-sm font-bold text-slate-700 mb-1.5 sm:mb-2">Spesifikasi</label>
                    <textarea name="spesifikasi" placeholder="Spesifikasi Lengkap" class="w-full p-3.5 sm:p-4 border border-slate-300 rounded-xl bg-slate-50 text-slate-900 text-sm outline-none focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all" rows="3" required>{{ $barang->spesifikasi }}</textarea>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-xs sm:text-sm font-bold text-slate-700 mb-1.5 sm:mb-2">Keterangan (Opsional)</label>
                    <textarea name="keterangan" placeholder="Keterangan Tambahan (Opsional)" class="w-full p-3.5 sm:p-4 border border-slate-300 rounded-xl bg-slate-50 text-slate-900 text-sm outline-none focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all" rows="2">{{ $barang->keterangan }}</textarea>
                </div>

                <button type="submit" class="md:col-span-2 mt-2 bg-slate-900 text-white font-bold rounded-xl py-3.5 sm:py-4 border border-slate-800 hover:bg-slate-800 hover:border-blue-400 hover:shadow-[0_0_20px_rgba(96,165,250,0.6)] hover:-translate-y-0.5 transition-all duration-300 text-sm sm:text-base">
                    Simpan Perubahan Data Aset
                </button>  
                <a href="{{ url('/admin/barang') }}" class="md:col-span-2 text-center text-slate-500 font-bold hover:text-slate-800 py-2 transition-colors text-sm sm:text-base">
                    Batal & Kembali
                </a>
            </form>
        </div>
    </main>
</body>
</html>