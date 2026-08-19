<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Keluhan - SMKN 9</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-slate-50 font-sans min-h-screen text-slate-800 flex flex-col justify-between">
    
    {{-- Header Bar --}}
    <header class="w-full bg-slate-950/95 backdrop-blur-md border-b border-slate-800 px-4 sm:px-8 py-3.5 flex items-center justify-between sticky top-0 z-40 shadow-lg">
        <div class="flex items-center gap-3">
            <img src="{{ asset('images/logo_smk9.png') }}" alt="Logo SMKN 9" class="w-8 h-8 sm:w-9 sm:h-9 object-contain drop-shadow-[0_0_10px_rgba(96,165,250,0.4)]">
            <div>
                <h1 class="text-sm sm:text-base font-black text-white tracking-wider leading-none">INVENTARIS</h1>
                <p class="text-[10px] text-blue-400 font-mono uppercase tracking-wide mt-0.5">SMKN 9 Semarang</p>
            </div>
        </div>

        <a href="{{ url('/dashboard') }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 sm:px-4 sm:py-2 bg-slate-900 hover:bg-slate-800 text-slate-300 hover:text-white border border-slate-800 hover:border-slate-700 text-xs font-bold rounded-xl transition-all">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            <span>Kembali</span>
        </a>
    </header>

    <main class="grow flex items-center justify-center p-4 sm:p-6 md:p-8">
        <div class="max-w-2xl w-full bg-white p-5 sm:p-8 rounded-2xl sm:rounded-3xl shadow-xl border border-slate-100 my-2 sm:my-6">
            <div class="mb-6 sm:mb-8 text-center">
                <div class="w-14 h-14 sm:w-16 sm:h-16 bg-amber-50 text-amber-500 rounded-2xl border border-amber-100 flex items-center justify-center mx-auto mb-3 sm:mb-4 shadow-sm">
                    <svg class="w-7 h-7 sm:w-8 sm:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                </div>
                <h2 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight">Form Laporan Keluhan</h2>
                <p class="text-slate-500 text-xs sm:text-sm mt-1">Silakan pilih ruangan dan barang yang mengalami kendala/kerusakan.</p>
            </div>

            <form action="{{ url('/lapor-keluhan') }}" method="POST" enctype="multipart/form-data" class="space-y-4 sm:space-y-6">
                @csrf
                
                {{-- Reporter Info Box --}}
                <div class="bg-blue-50/70 p-3.5 sm:p-4 rounded-2xl border border-blue-100/80 flex items-center gap-3">
                    <div class="w-10 h-10 bg-blue-600 text-white rounded-xl flex items-center justify-center font-black text-sm shrink-0 shadow-sm">
                        {{ strtoupper(substr(session('guest_name', 'U'), 0, 1)) }}
                    </div>
                    <div>
                        <span class="text-[10px] font-bold text-blue-500 uppercase tracking-wider block">Identitas Pelapor</span>
                        <p class="font-bold text-blue-900 text-xs sm:text-sm leading-snug">
                            {{ session('guest_name') }} 
                            <span class="font-normal text-xs text-blue-600">({{ session('guest_status') }})</span>
                        </p>
                    </div>
                </div>

                <div>
                    <label class="block text-xs sm:text-sm font-bold text-slate-700 mb-1.5">Lokasi Ruangan <span class="text-rose-500">*</span></label>
                    <select name="ruangan_id" id="ruangan_select" required class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-xs sm:text-sm rounded-xl px-3.5 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all cursor-pointer">
                        <option value="" disabled selected>-- Pilih Ruangan --</option>
                        @foreach($ruangans as $r)
                            <option value="{{ $r->id }}">{{ $r->nama_ruangan }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs sm:text-sm font-bold text-slate-700 mb-1.5">Barang yang Bermasalah <span class="text-rose-500">*</span></label>
                    <select name="barang_id" id="barang_select" required disabled class="w-full bg-slate-100 border border-slate-200 text-slate-400 text-xs sm:text-sm rounded-xl px-3.5 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all cursor-not-allowed">
                        <option value="" disabled selected>-- Pilih Ruangan Terlebih Dahulu --</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs sm:text-sm font-bold text-slate-700 mb-1.5">Deskripsi Kerusakan / Keluhan <span class="text-rose-500">*</span></label>
                    <textarea name="deskripsi" rows="4" required placeholder="Jelaskan detail kerusakan yang terjadi..." class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-xs sm:text-sm rounded-xl px-3.5 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all"></textarea>
                </div>

                <div>
                    <label class="block text-xs sm:text-sm font-bold text-slate-700 mb-1.5">Upload Foto Bukti (Opsional)</label>
                    <div class="relative bg-slate-50 border-2 border-dashed border-slate-200 rounded-2xl p-4 text-center hover:border-blue-400 transition-all">
                        <input type="file" name="foto" accept="image/jpeg, image/png, image/jpg" class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-blue-100 file:text-blue-700 hover:file:bg-blue-200 cursor-pointer">
                        <p class="text-[11px] text-slate-400 mt-2">Format: JPG, JPEG, PNG. Maksimal ukuran file 2MB.</p>
                    </div>
                </div>

                <div class="flex flex-col-reverse sm:flex-row gap-3 pt-4 border-t border-slate-100">
                    <a href="{{ url('/dashboard') }}" class="w-full sm:w-1/3 text-center bg-slate-100 text-slate-700 font-bold py-3 rounded-xl hover:bg-slate-200 transition-colors text-xs sm:text-sm">Batal</a>
                    <button type="submit" class="w-full sm:w-2/3 bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-xl shadow-md shadow-blue-600/20 hover:shadow-lg transition-all text-xs sm:text-sm flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                        <span>Kirim Laporan Keluhan</span>
                    </button>
                </div>
            </form>
        </div>
    </main>

    <footer class="w-full py-4 text-center text-xs text-slate-400 bg-slate-900 border-t border-slate-800">
        © 2026 SMKN 9 Semarang. All rights reserved.
    </footer>

    <script>
        document.getElementById('ruangan_select').addEventListener('change', function() {
            let ruanganId = this.value;
            let barangSelect = document.getElementById('barang_select');
            
            barangSelect.innerHTML = '<option value="" disabled selected>Memuat data barang...</option>';
            barangSelect.disabled = true;
            barangSelect.classList.add('bg-slate-100', 'text-slate-400', 'cursor-not-allowed');
            barangSelect.classList.remove('bg-slate-50', 'text-slate-800', 'focus:bg-white');

            fetch(`/get-barangs/${ruanganId}`)
                .then(response => response.json())
                .then(data => {
                    barangSelect.innerHTML = '<option value="" disabled selected>-- Pilih Barang --</option>';
                    
                    if(data.length === 0) {
                        barangSelect.innerHTML = '<option value="" disabled selected>Tidak ada barang di ruangan ini</option>';
                    } else {
                        data.forEach(barang => {
                            barangSelect.innerHTML += `<option value="${barang.id}">${barang.kode_barang} - ${barang.nama_barang}</option>`;
                        });
                        
                        barangSelect.disabled = false;
                        barangSelect.classList.remove('bg-slate-100', 'text-slate-400', 'cursor-not-allowed');
                        barangSelect.classList.add('bg-slate-50', 'text-slate-800', 'focus:bg-white');
                    }
                })
                .catch(error => {
                    console.error('Error fetching data:', error);
                    barangSelect.innerHTML = '<option value="" disabled selected>Gagal memuat barang</option>';
                });
        });
    </script>
</body>
</html>