<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Ruangan - SMKN 9</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-slate-50 font-sans min-h-screen flex flex-col md:flex-row text-slate-800 relative">
    @include('alert')   
    @include('sidebar')
    
    <main class="flex-1 p-4 sm:p-6 md:p-10 overflow-y-auto w-full">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6 md:mb-8">
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-black text-slate-900 tracking-tight">Kelola Ruangan</h1>
        </div>
        
        <!-- Form Tambah Ruangan -->
        <div class="bg-white rounded-2xl md:rounded-3xl border border-slate-100 shadow-sm p-4 sm:p-6 mb-6">
            <h2 class="text-base sm:text-lg font-semibold text-slate-800 mb-4 flex items-center gap-2">
                <span class="p-2 bg-indigo-50 text-indigo-600 rounded-lg shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                </span>
                Tambah Data Ruangan Baru
            </h2>

            <form action="/admin/ruangan/store" method="POST" enctype="multipart/form-data">
                @csrf 
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-500 mb-1.5">Kode Ruangan</label>
                        <input type="text" name="kode_ruangan" placeholder="Contoh: LAB-01" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 text-sm font-mono">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-500 mb-1.5">Nama Ruangan</label>
                        <input type="text" name="nama_ruangan" placeholder="Nama Ruangan" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 text-sm">
                    </div>
                </div>

                <div class="bg-slate-50 p-4 sm:p-5 rounded-2xl border border-slate-200 mt-2 mb-4">
                    <label class="block text-xs sm:text-sm font-bold text-slate-700 mb-3">DETAIL DIMENSI RUANGAN</label>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 sm:gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-500 mb-1.5">Panjang (m)</label>
                            <input type="number" step="0.01" id="input-panjang" name="panjang" placeholder="Cth: 10" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 text-sm bg-white">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-500 mb-1.5">Lebar (m)</label>
                            <input type="number" step="0.01" id="input-lebar" name="lebar" placeholder="Cth: 8" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 text-sm bg-white">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-500 mb-1.5">Tinggi (m)</label>
                            <input type="number" step="0.01" name="tinggi" placeholder="Cth: 4" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 text-sm bg-white">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-500 mb-1.5">Luas (m²)</label>
                            <input type="number" step="0.01" id="input-luas" name="luas" placeholder="Otomatis" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 focus:outline-none text-sm bg-slate-100 text-slate-600 font-bold cursor-not-allowed" readonly>
                        </div>
                    </div>
                    <p id="info-luas-realtime" class="text-xs font-bold text-indigo-600 mt-3 flex items-center gap-1.5 hidden bg-indigo-50 p-2.5 rounded-xl border border-indigo-100 leading-tight">
                        <span>✨</span> <span id="text-luas-realtime"></span>
                    </p>
                </div>

                <div class="mb-4">
                    <label class="block text-xs font-semibold text-slate-500 mb-2 leading-snug">FOTO DOKUMENTASI RUANGAN <span class="text-slate-400 font-normal">(FORMAT: JPG/PNG, MAKS 2MB)</span></label>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4">
                        <div class="border border-dashed border-slate-200 rounded-2xl p-3.5 text-center hover:border-indigo-500 transition relative bg-slate-50/50">
                            <span class="block text-xs font-semibold text-slate-600 mb-2">📸 Tampak Depan</span>
                            <input type="file" name="foto_depan" accept="image/*" required class="block w-full text-xs text-slate-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 cursor-pointer"/>
                        </div>
                        <div class="border border-dashed border-slate-200 rounded-2xl p-3.5 text-center hover:border-indigo-500 transition relative bg-slate-50/50">
                            <span class="block text-xs font-semibold text-slate-600 mb-2">📸 Tampak Belakang</span>
                            <input type="file" name="foto_belakang" accept="image/*" required class="block w-full text-xs text-slate-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 cursor-pointer"/>
                        </div>
                        <div class="border border-dashed border-slate-200 rounded-2xl p-3.5 text-center hover:border-indigo-500 transition relative bg-slate-50/50">
                            <span class="block text-xs font-semibold text-slate-600 mb-2">📸 Samping Kiri</span>
                            <input type="file" name="foto_kiri" accept="image/*" required class="block w-full text-xs text-slate-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 cursor-pointer"/>
                        </div>
                        <div class="border border-dashed border-slate-200 rounded-2xl p-3.5 text-center hover:border-indigo-500 transition relative bg-slate-50/50">
                            <span class="block text-xs font-semibold text-slate-600 mb-2">📸 Samping Kanan</span>
                            <input type="file" name="foto_kanan" accept="image/*" required class="block w-full text-xs text-slate-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 cursor-pointer"/>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end pt-2">
                    <button type="submit" class="w-full md:w-auto px-6 py-3 rounded-xl bg-slate-900 hover:bg-slate-800 text-white font-semibold text-sm transition shadow-sm">
                        Simpan Ruangan
                    </button>
                </div>
            </form>
        </div>

        <!-- Card View (Khusus Layar HP/Mobile) -->
        <div class="grid grid-cols-1 gap-3 md:hidden mb-6">
            @foreach($ruangans as $r)
            <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm flex flex-col justify-between gap-3">
                <div class="flex justify-between items-start gap-2">
                    <div>
                        <span class="inline-block font-mono text-xs font-bold text-slate-500 bg-slate-100 px-2 py-1 rounded-lg mb-1">{{ $r->kode_ruangan }}</span>
                        <h3 class="font-bold text-slate-900 text-base leading-tight mb-2">{{ $r->nama_ruangan }}</h3>
                        <div class="flex items-center justify-between text-xs text-slate-500 bg-slate-50 p-2.5 rounded-xl border border-slate-100">
                            <span>Dimensi: <strong class="text-slate-700">{{ $r->panjang ? $r->panjang.'m' : '-' }} × {{ $r->lebar ? $r->lebar.'m' : '-' }}</strong></span>
                            <span>Luas: <strong class="text-indigo-600">{{ $r->luas ? $r->luas.' m²' : '-' }}</strong></span>
                        </div>
                    </div>
                </div>
                <div class="flex items-center gap-2 pt-2 border-t border-slate-100">
                    <a href="{{ url('/admin/ruangan/detail/' . $r->id) }}" class="flex-1 text-center bg-indigo-50 text-indigo-600 border border-indigo-100 py-2 rounded-xl text-xs font-bold hover:bg-indigo-100 transition">Detail</a>
                    <a href="{{ url('/admin/ruangan/edit/' . $r->id) }}" class="flex-1 text-center bg-amber-50 text-amber-600 border border-amber-100 py-2 rounded-xl text-xs font-bold hover:bg-amber-100 transition">Edit</a>
                    <a href="{{ url('/admin/ruangan/hapus/' . $r->id) }}" onclick="return confirm('Yakin ingin menghapus ruangan ini?')" class="flex-1 text-center bg-red-50 text-red-600 border border-red-100 py-2 rounded-xl text-xs font-bold hover:bg-red-100 transition">Hapus</a>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Table View (Layar Desktop / Tablet) -->
        <div class="hidden md:block bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-900 text-white text-xs font-bold uppercase tracking-widest border-b border-slate-800">
                        <th class="p-5 pl-8">Kode Ruangan</th>
                        <th class="p-5">Nama Ruangan</th>
                        <th class="p-5 text-center pr-8">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm">
                    @foreach($ruangans as $r)
                    <tr class="hover:bg-blue-50/50 transition-colors duration-200">
                        <td class="p-5 pl-8 font-mono text-sm text-slate-500 font-bold">{{ $r->kode_ruangan }}</td>
                        <td class="p-5 font-bold text-slate-900 text-base">{{ $r->nama_ruangan }}</td>
                        <td class="p-5 text-center pr-8">
                            <a href="{{ url('/admin/ruangan/detail/' . $r->id) }}" class="inline-block bg-white text-indigo-500 border border-slate-200 hover:border-indigo-400 hover:bg-indigo-50 hover:text-indigo-600 px-4 py-2 rounded-lg font-bold hover:shadow-[0_5px_15px_rgba(99,102,241,0.3)] hover:-translate-y-0.5 transition-all duration-300 mr-1">Detail</a>
                            
                            <a href="{{ url('/admin/ruangan/edit/' . $r->id) }}" class="inline-block bg-white text-amber-500 border border-slate-200 hover:border-amber-400 hover:bg-amber-50 hover:text-amber-600 px-4 py-2 rounded-lg font-bold hover:shadow-[0_5px_15px_rgba(251,191,36,0.3)] hover:-translate-y-0.5 transition-all duration-300 mr-1">Edit</a>
                            
                            <a href="{{ url('/admin/ruangan/hapus/' . $r->id) }}" onclick="return confirm('Yakin ingin menghapus ruangan ini?')" class="inline-block bg-white text-red-500 border border-slate-200 hover:border-red-400 hover:bg-red-50 hover:text-red-600 px-4 py-2 rounded-lg font-bold hover:shadow-[0_5px_15px_rgba(248,113,113,0.3)] hover:-translate-y-0.5 transition-all duration-300">Hapus</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const inputPanjang = document.getElementById('input-panjang');
            const inputLebar = document.getElementById('input-lebar');
            const inputLuas = document.getElementById('input-luas');
            const infoRealtime = document.getElementById('info-luas-realtime');
            const textRealtime = document.getElementById('text-luas-realtime');

            function hitungLuas() {
                const panjang = parseFloat(inputPanjang.value) || 0;
                const lebar = parseFloat(inputLebar.value) || 0;
                
                const luas = panjang * lebar;
                
                if (luas > 0) {
                    const formatLuas = luas.toFixed(2);
                    inputLuas.value = formatLuas;
                    if(infoRealtime && textRealtime) {
                        textRealtime.textContent = `Luas otomatis terhitung: ${panjang} m × ${lebar} m = ${formatLuas} m²`;
                        infoRealtime.classList.remove('hidden');
                    }
                } else {
                    inputLuas.value = '';
                    if(infoRealtime) {
                        infoRealtime.classList.add('hidden');
                    }
                }
            }

            if(inputPanjang && inputLebar) {
                inputPanjang.addEventListener('input', hitungLuas);
                inputLebar.addEventListener('input', hitungLuas);
            }
        });
    </script>
</body>
</html>