<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Ruangan - SMKN 9</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-slate-50 font-sans min-h-screen flex flex-col md:flex-row text-slate-800 relative">
    @include('sidebar')
    
    <main class="flex-1 p-4 sm:p-6 md:p-10 overflow-y-auto w-full">
        <h1 class="text-2xl sm:text-3xl md:text-4xl font-black text-slate-900 tracking-tight mb-6 md:mb-8">Edit Data Ruangan</h1>
        
        <div class="bg-white p-5 sm:p-6 md:p-8 rounded-2xl shadow-sm border border-slate-200">
            <form action="{{ url('/admin/ruangan/update/' . $ruangan->id) }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 gap-5 md:gap-6">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs sm:text-sm font-bold text-slate-700 mb-2">Kode Ruangan</label>
                        <input type="text" name="kode_ruangan" value="{{ $ruangan->kode_ruangan }}" class="w-full px-3.5 py-3 rounded-xl border border-slate-200 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 text-sm font-mono" required>
                    </div>
                    <div>
                        <label class="block text-xs sm:text-sm font-bold text-slate-700 mb-2">Nama Ruangan</label>
                        <input type="text" name="nama_ruangan" value="{{ $ruangan->nama_ruangan }}" class="w-full px-3.5 py-3 rounded-xl border border-slate-200 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 text-sm" required>
                    </div>
                </div>

                <div class="bg-slate-50 p-4 sm:p-5 rounded-2xl border border-slate-200">
                    <label class="block text-xs sm:text-sm font-bold text-slate-700 mb-3">DETAIL DIMENSI RUANGAN</label>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 sm:gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-500 mb-1.5">Panjang (m)</label>
                            <input type="number" step="0.01" id="input-panjang" name="panjang" value="{{ $ruangan->panjang }}" placeholder="Cth: 10" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 text-sm bg-white">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-500 mb-1.5">Lebar (m)</label>
                            <input type="number" step="0.01" id="input-lebar" name="lebar" value="{{ $ruangan->lebar }}" placeholder="Cth: 8" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 text-sm bg-white">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-500 mb-1.5">Tinggi (m)</label>
                            <input type="number" step="0.01" name="tinggi" value="{{ $ruangan->tinggi }}" placeholder="Cth: 4" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 text-sm bg-white">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-500 mb-1.5">Luas (m²)</label>
                            <input type="number" step="0.01" id="input-luas" name="luas" value="{{ $ruangan->luas }}" placeholder="Otomatis" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 focus:outline-none text-sm bg-slate-100 text-slate-600 font-bold cursor-not-allowed" readonly>
                        </div>
                    </div>
                    <p id="info-luas-realtime" class="text-xs font-bold text-indigo-600 mt-3 flex items-center gap-1.5 hidden bg-indigo-50 p-2.5 rounded-xl border border-indigo-100 leading-tight">
                        <span>✨</span> <span id="text-luas-realtime"></span>
                    </p>
                </div>

                <div>
                    <label class="block text-xs sm:text-sm font-bold text-slate-700 mb-3 leading-snug">FOTO DOKUMENTASI RUANGAN <span class="text-slate-400 font-normal">(OPSIONAL, KOSONGKAN JIKA TIDAK INGIN DIUBAH)</span></label>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
                        <!-- Tampak Depan -->
                        <div class="border border-dashed border-slate-200 rounded-2xl p-4 text-center hover:border-indigo-500 transition flex flex-col justify-between items-center gap-3 bg-slate-50/50">
                            <span class="block text-xs font-semibold text-slate-600">📸 Tampak Depan</span>
                            @if(!empty($ruangan->foto_depan))
                                <img src="{{ asset('ruangan/' . $ruangan->foto_depan) }}" alt="Tampak Depan" class="w-full h-28 object-cover rounded-lg shadow-sm">
                            @endif
                            <input type="file" name="foto_depan" accept="image/*" class="block w-full text-xs text-slate-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 cursor-pointer"/>
                        </div>

                        <!-- Tampak Belakang -->
                        <div class="border border-dashed border-slate-200 rounded-2xl p-4 text-center hover:border-indigo-500 transition flex flex-col justify-between items-center gap-3 bg-slate-50/50">
                            <span class="block text-xs font-semibold text-slate-600">📸 Tampak Belakang</span>
                            @if(!empty($ruangan->foto_belakang))
                                <img src="{{ asset('ruangan/' . $ruangan->foto_belakang) }}" alt="Tampak Belakang" class="w-full h-28 object-cover rounded-lg shadow-sm">
                            @endif
                            <input type="file" name="foto_belakang" accept="image/*" class="block w-full text-xs text-slate-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 cursor-pointer"/>
                        </div>

                        <!-- Samping Kiri -->
                        <div class="border border-dashed border-slate-200 rounded-2xl p-4 text-center hover:border-indigo-500 transition flex flex-col justify-between items-center gap-3 bg-slate-50/50">
                            <span class="block text-xs font-semibold text-slate-600">📸 Samping Kiri</span>
                            @if(!empty($ruangan->foto_kiri))
                                <img src="{{ asset('ruangan/' . $ruangan->foto_kiri) }}" alt="Samping Kiri" class="w-full h-28 object-cover rounded-lg shadow-sm">
                            @endif
                            <input type="file" name="foto_kiri" accept="image/*" class="block w-full text-xs text-slate-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 cursor-pointer"/>
                        </div>

                        <!-- Samping Kanan -->
                        <div class="border border-dashed border-slate-200 rounded-2xl p-4 text-center hover:border-indigo-500 transition flex flex-col justify-between items-center gap-3 bg-slate-50/50">
                            <span class="block text-xs font-semibold text-slate-600">📸 Samping Kanan</span>
                            @if(!empty($ruangan->foto_kanan))
                                <img src="{{ asset('ruangan/' . $ruangan->foto_kanan) }}" alt="Samping Kanan" class="w-full h-28 object-cover rounded-lg shadow-sm">
                            @endif
                            <input type="file" name="foto_kanan" accept="image/*" class="block w-full text-xs text-slate-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 cursor-pointer"/>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col gap-3 pt-2">
                    <button type="submit" class="w-full bg-slate-900 text-white font-bold rounded-xl py-3.5 sm:py-4 border border-slate-800 hover:bg-slate-800 hover:shadow-[0_0_20px_rgba(96,165,250,0.6)] hover:-translate-y-0.5 transition-all duration-300 text-sm sm:text-base">
                        Update Data Ruangan
                    </button>
                    <a href="{{ url('/admin/ruangan') }}" class="w-full text-center text-slate-500 font-bold hover:text-slate-800 py-2 transition-colors text-sm">
                        Batal & Kembali
                    </a>
                </div>
            </form>
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
                hitungLuas();
                inputPanjang.addEventListener('input', hitungLuas);
                inputLebar.addEventListener('input', hitungLuas);
            }
        });
    </script>
</body>
</html>