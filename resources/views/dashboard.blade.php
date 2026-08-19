<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - SMKN 9</title>
    @vite('resources/css/app.css')
    <style>
        /* CSS Khusus agar Icon Excel menjadi hijau pekat & kotak latar menjadi putih saat Card di-hover */
        .card-excel:hover .icon-box {
            background-color: #ffffff !important;
            transform: scale(1.1);
        }
        .card-excel:hover .icon-svg {
            color: #059669 !important;
            stroke: #059669 !important;
        }

        /* Styling saat file sedang diseret di atas area (Drag Over) */
        .drag-over {
            border: 2px dashed #ffffff !important;
            background-color: rgba(4, 120, 87, 0.75) !important;
        }
    </style>
</head>
<body class="bg-slate-50 font-sans min-h-screen flex flex-col md:flex-row">

    @include('sidebar')

    <main class="flex-1 p-4 sm:p-6 md:p-10 overflow-y-auto w-full">
        
        <div class="flex justify-between items-center mb-6 md:mb-10">
            <div>
                <h1 class="text-2xl sm:text-3xl md:text-4xl font-black text-slate-900 tracking-tight">Ringkasan Sistem</h1>
                <p class="text-xs sm:text-sm text-slate-500 mt-1 sm:mt-2">Selamat datang di pusat kendali inventaris sekolah.</p>
            </div>
        </div>

        @if(session('success'))
            <div class="mb-6 bg-emerald-50 text-emerald-600 border border-emerald-200 px-4 sm:px-5 py-3.5 sm:py-4 rounded-xl text-xs sm:text-sm font-bold shadow-sm flex items-center gap-3">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error') || $errors->any())
            <div class="mb-6 bg-rose-50 text-rose-600 border border-rose-200 px-4 sm:px-5 py-3.5 sm:py-4 rounded-xl text-xs sm:text-sm font-bold shadow-sm flex items-center gap-3">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <div>
                    {{ session('error') }}
                    @if($errors->any())
                        <ul class="list-disc ml-4 mt-1 font-medium text-xs">
                            @foreach($errors->all() as $err) <li>{{ $err }}</li> @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        @endif

        {{-- Section 4 Card Statistik Utama --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 md:gap-8 mb-8 md:mb-10">
            <div class="bg-white p-5 sm:p-6 md:p-8 rounded-2xl shadow-sm border border-slate-200 border-l-4 border-l-blue-600 hover:shadow-[0_10px_20px_rgba(96,165,250,0.2)] hover:-translate-y-1 md:hover:-translate-y-2 transition-all duration-300">
                <h3 class="text-slate-400 font-bold text-[10px] sm:text-xs tracking-widest uppercase mb-1 sm:mb-2">Total Ruangan</h3>
                <p class="text-3xl sm:text-4xl md:text-5xl font-black text-slate-900">{{ $total_ruangan }}</p>
            </div>
            
            <div class="bg-white p-5 sm:p-6 md:p-8 rounded-2xl shadow-sm border border-slate-200 border-l-4 border-l-slate-800 hover:shadow-[0_10px_20px_rgba(96,165,250,0.2)] hover:-translate-y-1 md:hover:-translate-y-2 transition-all duration-300">
                <h3 class="text-slate-400 font-bold text-[10px] sm:text-xs tracking-widest uppercase mb-1 sm:mb-2">Total Aset Barang</h3>
                <p class="text-3xl sm:text-4xl md:text-5xl font-black text-slate-900">{{ $total_barang }}</p>
            </div>
            
            <div class="bg-white p-5 sm:p-6 md:p-8 rounded-2xl shadow-sm border border-slate-200 border-l-4 border-l-red-500 hover:shadow-[0_10px_20px_rgba(248,113,113,0.2)] hover:-translate-y-1 md:hover:-translate-y-2 transition-all duration-300">
                <h3 class="text-slate-400 font-bold text-[10px] sm:text-xs tracking-widest uppercase mb-1 sm:mb-2">Barang Rusak</h3>
                <p class="text-3xl sm:text-4xl md:text-5xl font-black text-slate-900">{{ $barang_rusak }}</p>
            </div>

            <div class="bg-white p-5 sm:p-6 md:p-8 rounded-2xl shadow-sm border border-slate-200 border-l-4 border-l-amber-500 hover:shadow-[0_10px_20px_rgba(245,158,11,0.2)] hover:-translate-y-1 md:hover:-translate-y-2 transition-all duration-300 relative overflow-hidden">
                @if(isset($keluhan_baru_count) && $keluhan_baru_count > 0)
                    <span class="absolute top-4 right-4 sm:top-6 sm:right-6 flex h-3 w-3">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-amber-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-3 w-3 bg-amber-500"></span>
                    </span>
                @endif
                <h3 class="text-slate-400 font-bold text-[10px] sm:text-xs tracking-widest uppercase mb-1 sm:mb-2">Keluhan Baru</h3>
                <p class="text-3xl sm:text-4xl md:text-5xl font-black text-slate-900">{{ $keluhan_baru_count ?? 0 }}</p>
            </div>
        </div>

        {{-- Section Aksi Cepat --}}
        <div class="mb-12">
            <h2 class="text-lg sm:text-xl font-bold text-slate-800 mb-4 sm:mb-5 flex items-center gap-2">
                <svg class="w-5 h-5 sm:w-6 sm:h-6 text-sky-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                </svg>
                Aksi Cepat
            </h2>
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-6 md:gap-8 w-full">
                
                {{-- Card Cetak Laporan --}}
                <a href="{{ url('/admin/laporan/cetak-semua') }}" target="_blank" class="group bg-sky-500 hover:bg-sky-600 p-5 sm:p-6 rounded-2xl sm:rounded-3xl shadow-md hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between">
                    <div class="flex items-center gap-4 sm:gap-5 text-left text-white my-auto">
                        <div class="shrink-0 bg-white/20 text-white group-hover:bg-white group-hover:text-sky-600 group-hover:scale-110 rounded-xl p-3 sm:p-3.5 transition-all">
                            <svg class="w-6 h-6 sm:w-7 sm:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h3 class="font-bold text-base sm:text-lg leading-tight truncate">Cetak Laporan Inventaris</h3>
                            <p class="text-sky-100 text-xs mt-1">Seluruh ruangan dan barang.</p>
                        </div>
                        <svg class="shrink-0 w-5 h-5 sm:w-6 sm:h-6 text-sky-200 group-hover:text-white transform group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                </a>

                {{-- Card Impor Data Excel --}}
                <form action="{{ url('/admin/barang/import') }}" method="POST" enctype="multipart/form-data" 
                      style="background-color: #10b981;" 
                      class="card-excel group hover:bg-emerald-600 p-5 sm:p-6 rounded-2xl sm:rounded-3xl shadow-md hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between overflow-hidden">
                    @csrf
                    <div class="flex items-center gap-4 sm:gap-5 text-left text-white mb-4">
                        <div class="icon-box shrink-0 bg-white/20 text-white rounded-xl p-3 sm:p-3.5 transition-all duration-300">
                            <svg class="icon-svg w-6 h-6 sm:w-7 sm:h-7 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h3 class="font-bold text-base sm:text-lg leading-tight truncate">Impor Data Excel</h3>
                            <p class="text-xs mt-1" style="color: #d1fae5;">Otomatisasi input aset barang.</p>
                        </div>
                    </div>
                    
                    <div id="drop-zone" class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2 p-2 rounded-xl w-full transition-all duration-200" style="background-color: rgba(4, 120, 87, 0.45);">
                        <label class="flex-1 flex items-center cursor-pointer min-w-0 overflow-hidden">
                            <span class="bg-white/20 hover:bg-white/30 text-white text-xs font-bold py-2 px-3 rounded-lg border-r-2 border-emerald-300/40 shrink-0 transition whitespace-nowrap">
                                Choose File
                            </span>
                            <span id="file-name-display" class="text-xs text-white font-medium px-3 truncate min-w-0 flex-1 block">
                                No file chosen
                            </span>
                            <input type="file" name="file_excel" id="file_excel" accept=".xlsx, .xls, .csv" required class="hidden" onchange="updateFileName(this)">
                        </label>
                        
                        <button type="submit" style="color: #059669;" class="shrink-0 bg-white hover:bg-emerald-50 px-4 py-2 rounded-lg text-xs font-bold transition shadow-sm flex items-center justify-center gap-1 mt-2 sm:mt-0">
                            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                            Upload
                        </button>
                    </div>
                </form>

            </div>
        </div>

    </main>

    <script>
        const dropZone = document.getElementById('drop-zone');
        const fileInput = document.getElementById('file_excel');
        const fileNameDisplay = document.getElementById('file-name-display');

        function updateFileName(input) {
            if (input.files && input.files[0]) {
                fileNameDisplay.innerText = input.files[0].name;
            } else {
                fileNameDisplay.innerText = 'No file chosen';
            }
        }

        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, preventDefaults, false);
            document.body.addEventListener(eventName, preventDefaults, false);
        });

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        ['dragenter', 'dragover'].forEach(eventName => {
            dropZone.addEventListener(eventName, () => dropZone.classList.add('drag-over'), false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, () => dropZone.classList.remove('drag-over'), false);
        });

        dropZone.addEventListener('drop', (e) => {
            const dt = e.dataTransfer;
            const files = dt.files;

            if (files && files.length > 0) {
                fileInput.files = files;
                updateFileName(fileInput);
            }
        }, false);
    </script>

</body>
</html>