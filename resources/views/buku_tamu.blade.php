<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lengkapi Data Diri - Portal INV-9</title>
    @vite('resources/css/app.css')
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="min-h-screen bg-slate-900 flex flex-col justify-between relative overflow-hidden">

    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full max-w-3xl h-64 bg-blue-500/10 blur-[100px] rounded-full pointer-events-none"></div>

    <header class="w-full max-w-7xl mx-auto px-4 sm:px-8 py-4 sm:py-8 flex justify-between items-center relative z-10">
        <div class="flex items-center gap-2.5 sm:gap-3">
            <img src="{{ asset('images/logo_smk9.png') }}" alt="Logo" class="h-10 w-10 sm:h-12 sm:w-12 object-contain">
            <span class="text-lg sm:text-xl font-bold text-white tracking-wider">INV-9</span>
        </div>
        
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="text-xs font-semibold text-rose-400 hover:text-white bg-rose-500/10 hover:bg-rose-500 px-3 py-2 sm:px-4 sm:py-2.5 rounded-xl transition-all duration-300 border border-rose-500/20 hover:border-rose-500">
                Batalkan & Keluar
            </button>
        </form>
    </header>

    <main class="grow flex items-center justify-center px-4 py-6 sm:py-12 relative z-10">
        <div class="w-full max-w-md bg-white rounded-2xl sm:rounded-3xl p-5 sm:p-8 border border-slate-100 shadow-2xl relative overflow-hidden">
            
            <div class="text-center mb-8 relative">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-blue-50 rounded-2xl mb-4 text-blue-600 shadow-inner">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-slate-800">Lengkapi Data Diri</h2>
                <p class="text-xs text-slate-500 mt-1">Silakan isi nama dan status Anda untuk melanjutkan ke Dashboard</p>
            </div>

            <form action="{{ route('data_diri.submit') }}" method="POST" class="space-y-5 relative">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Nama Lengkap</label>
                    <input type="text" name="nama" placeholder="Masukkan nama Anda" required
                        class="w-full px-4 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl text-slate-800 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all duration-300">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Saya Sebagai</label>
                    <select name="status" 
                        class="w-full px-4 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl text-slate-800 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all duration-300 cursor-pointer">
                        <option value="Siswa">Siswa / Siswi</option>
                        <option value="Guru">Guru / Tenaga Pendidik</option>
                        <option value="Staf">Staf Sekolah</option>
                    </select>
                </div>

                <button type="submit" 
                    class="w-full py-4 bg-slate-900 hover:bg-blue-600 text-white rounded-2xl font-semibold text-sm transition-all duration-300 shadow-lg shadow-slate-900/20 hover:shadow-blue-500/30 transform hover:-translate-y-0.5">
                    Lanjutkan ke Dashboard
                </button>
            </form>
        </div>
    </main>

    <footer class="w-full py-6 text-center text-xs text-slate-400 relative z-10">
        © 2026 SMKN 9 Semarang. All rights reserved.
    </footer>

</body>
</html>