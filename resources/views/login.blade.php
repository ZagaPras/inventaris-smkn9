<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - INV-9 SMKN 9 Semarang</title>
    @vite('resources/css/app.css')
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: radial-gradient(circle at center, #0f172a 0%, #020617 100%);
        }
        .glow-border {
            box-shadow: 0 0 30px rgba(14, 165, 233, 0.15), inset 0 0 20px rgba(14, 165, 233, 0.05);
            border: 1px solid rgba(14, 165, 233, 0.25);
        }
        .glow-btn {
            box-shadow: 0 4px 20px rgba(14, 165, 233, 0.4);
            transition: all 0.3s ease;
        }
        .glow-btn:hover {
            box-shadow: 0 4px 30px rgba(14, 165, 233, 0.7);
            transform: translateY(-2px);
        }
        .glow-text {
            text-shadow: 0 0 15px rgba(14, 165, 233, 0.5);
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4 overflow-hidden relative">
    
    <div class="absolute w-125 h-125 bg-sky-500/10 rounded-full blur-3xl -top-40 -left-40 pointer-events-none"></div>
    <div class="absolute w-125 h-125 bg-indigo-500/10 rounded-full blur-3xl -bottom-40 -right-40 pointer-events-none"></div>

    <div class="w-full max-w-md z-10">
        <div class="bg-slate-900/60 backdrop-blur-xl rounded-2xl sm:rounded-3xl p-6 sm:p-8 md:p-10 glow-border text-white">
            
            <div class="flex flex-col items-center mb-8">
                <div class="relative p-1 rounded-full bg-slate-800/50 border border-sky-500/30 shadow-[0_0_30px_rgba(14,165,233,0.2)] mb-4 transition-transform hover:scale-105 duration-300">
                    <img src="{{ asset('images/logo_smk9.png') }}" alt="Logo SMKN 9" class="w-24 h-24 object-contain">
                </div>
                <h1 class="text-3xl font-extrabold tracking-wider text-sky-400 glow-text">INV-9</h1>
                <p class="text-xs text-slate-400 mt-1 uppercase tracking-widest font-semibold text-center">Sistem Inventaris SMKN 9 Semarang</p>
            </div>

            @if(session('error'))
                <div class="mb-5 p-4 bg-red-500/15 border border-red-500/30 text-red-300 text-sm rounded-2xl flex items-center gap-3 animate-pulse">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            <form action="/login" method="POST" class="space-y-6">
                @csrf

                <div>
                    <label for="email" class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">
                        Email / Username
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                            </svg>
                        </span>
                        <input type="email" name="email" id="email" required 
                            value="{{ old('email') }}" 
                            autocomplete="off"
                            class="w-full pl-11 pr-4 py-3.5 bg-slate-950/60 border border-slate-700/80 rounded-2xl text-white focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all placeholder:text-slate-500"
                            placeholder="masukkan email">
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">
                        Password
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                        </span>
                        <input type="password" name="password" id="password" required 
                            autocomplete="new-password"
                            class="w-full pl-11 pr-4 py-3.5 bg-slate-950/60 border border-slate-700/80 rounded-2xl text-white focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all placeholder:text-slate-500"
                            placeholder="masukkan password">
                    </div>
                </div>

                <button type="submit" class="w-full bg-linear-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 text-white font-bold py-3.5 px-4 rounded-2xl shadow-lg shadow-blue-500/30 transition-all duration-300 transform hover:-translate-y-0.5">
                    Masuk ke Sistem
                </button>
            </form>
        </div>
        
        <p class="text-center text-xs text-slate-500 mt-6 font-medium">
            &copy; 2026 SMKN 9 Semarang. All rights reserved.
        </p>
    </div> 

</body>
</html>