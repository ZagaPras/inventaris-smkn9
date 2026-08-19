<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Keluhan - SMKN 9</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-slate-50 font-sans min-h-screen flex flex-col md:flex-row text-slate-800 relative">

    @include('alert')
    @include('sidebar')

    <main class="flex-1 p-4 sm:p-6 md:p-10 overflow-y-auto w-full">
        
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6 md:mb-8">
            <div>
                <h1 class="text-2xl sm:text-3xl md:text-4xl font-black text-slate-900 tracking-tight">Kelola Keluhan</h1>
                <p class="text-xs sm:text-sm text-slate-500 mt-1">Pantau dan tindak lanjuti laporan kerusakan dari pengguna.</p>
            </div>
        </div>

        @if(session('success'))
            <div class="mb-6 bg-emerald-50 text-emerald-600 border border-emerald-200 px-4 sm:px-5 py-3.5 sm:py-4 rounded-xl text-xs sm:text-sm font-bold shadow-sm flex items-center gap-3">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        {{-- Mobile View: Cards Layout --}}
        <div class="grid grid-cols-1 gap-4 md:hidden mb-8">
            @if(isset($keluhans) && $keluhans->count() > 0)
                @foreach($keluhans as $k)
                <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex flex-col justify-between gap-4">
                    <div>
                        <div class="flex justify-between items-start gap-2 mb-2">
                            <div>
                                <span class="font-bold text-slate-900 text-base leading-snug block">{{ $k->pelapor_nama }}</span>
                                <span class="inline-block text-[10px] bg-slate-100 text-slate-600 px-2 py-0.5 rounded font-semibold mt-0.5 border border-slate-200">{{ $k->pelapor_status }}</span>
                            </div>
                            <div class="text-right shrink-0">
                                <span class="font-bold text-xs text-slate-700 block">{{ \Carbon\Carbon::parse($k->created_at)->format('d/m/Y') }}</span>
                                <span class="text-[10px] text-slate-400 font-mono">{{ \Carbon\Carbon::parse($k->created_at)->format('H:i') }} WIB</span>
                            </div>
                        </div>

                        <div class="bg-slate-50 p-3 rounded-xl border border-slate-100 mb-3">
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-0.5">Barang & Lokasi</span>
                            <p class="text-xs font-bold text-slate-800">{{ $k->kode_barang ?? '-' }} - {{ $k->nama_barang }}</p>
                            <p class="text-xs text-slate-500">Ruang: <strong class="text-slate-700">{{ $k->nama_ruangan }}</strong></p>
                        </div>

                        <div class="mb-3">
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-1">Deskripsi Kerusakan</span>
                            <p class="text-xs text-slate-700 leading-relaxed bg-slate-50/50 p-3 rounded-xl border border-slate-100">{{ $k->deskripsi }}</p>
                        </div>

                        @if($k->foto)
                            <div class="mb-3">
                                <a href="{{ asset('storage/' . $k->foto) }}" target="_blank" class="inline-flex items-center gap-2 px-3 py-1.5 bg-blue-50 border border-blue-100 rounded-xl hover:bg-blue-100 transition-colors text-xs font-bold text-blue-600">
                                    <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    <span>Lihat Foto Bukti</span>
                                </a>
                            </div>
                        @endif

                        <div class="flex items-center justify-between pt-2 border-t border-slate-100">
                            <span class="text-xs font-semibold text-slate-500">Status Saat Ini:</span>
                            @if($k->status == 'Menunggu')
                                <span class="bg-red-100 text-red-700 border border-red-200 px-3 py-1 rounded-full text-xs font-bold inline-flex items-center gap-1.5 shadow-sm">
                                    <span class="w-1.5 h-1.5 bg-red-500 rounded-full animate-ping"></span> Menunggu
                                </span>
                            @elseif($k->status == 'Diproses')
                                <span class="bg-amber-100 text-amber-700 border border-amber-200 px-3 py-1 rounded-full text-xs font-bold shadow-sm">
                                    ⏳ Diproses
                                </span>
                            @else
                                <span class="bg-emerald-100 text-emerald-700 border border-emerald-200 px-3 py-1 rounded-full text-xs font-bold shadow-sm">
                                    ✅ Selesai
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="flex items-center gap-2 pt-3 border-t border-slate-100">
                        <form action="{{ url('/admin/keluhan/update-status/'.$k->id) }}" method="POST" class="flex-1">
                            @csrf
                            <select name="status" onchange="this.form.submit()" class="w-full text-xs bg-slate-50 border border-slate-300 rounded-xl px-3 py-2.5 font-bold text-slate-700 focus:outline-none focus:ring-2 focus:ring-sky-500 cursor-pointer shadow-sm">
                                <option value="Menunggu" {{ $k->status == 'Menunggu' ? 'selected' : '' }}>Set: Menunggu</option>
                                <option value="Diproses" {{ $k->status == 'Diproses' ? 'selected' : '' }}>Set: Diproses</option>
                                <option value="Selesai" {{ $k->status == 'Selesai' ? 'selected' : '' }}>Set: Selesai</option>
                            </select>
                        </form>

                        <form action="{{ url('/admin/keluhan/'.$k->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus keluhan ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-2.5 text-rose-500 bg-white border border-rose-200 hover:bg-rose-500 hover:text-white rounded-xl transition-all duration-200 shadow-sm flex items-center justify-center" title="Hapus Keluhan">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
                @endforeach
            @else
                <div class="bg-white p-8 rounded-2xl border border-slate-200 text-center text-slate-400 font-medium text-sm">
                    Yeay! Belum ada laporan keluhan yang masuk saat ini.
                </div>
            @endif
        </div>

        {{-- Tablet & Desktop View: Table Layout --}}
        <div class="hidden md:block bg-white p-6 sm:p-8 rounded-2xl shadow-sm border border-slate-200 mb-8">
            <div class="overflow-x-auto rounded-xl border border-slate-200">
                <table class="w-full text-left text-sm text-slate-600">
                    <thead class="bg-slate-900 text-white text-xs uppercase tracking-wider">
                        <tr>
                            <th class="py-4 px-5 font-semibold">TGL / WAKTU</th>
                            <th class="py-4 px-5 font-semibold">PELAPOR</th>
                            <th class="py-4 px-5 font-semibold">LOKASI & BARANG</th>
                            <th class="py-4 px-5 font-semibold">DESKRIPSI KERUSAKAN</th>
                            <th class="py-4 px-5 font-semibold">STATUS</th>
                            <th class="py-4 px-5 font-semibold text-center">TINDAKAN ADMIN</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        @if(isset($keluhans) && $keluhans->count() > 0)
                            @foreach($keluhans as $k)
                            <tr class="hover:bg-slate-50 transition">
                                <td class="py-4 px-5 whitespace-nowrap">
                                    <span class="font-bold text-slate-700">{{ \Carbon\Carbon::parse($k->created_at)->format('d/m/Y') }}</span>
                                    <div class="text-xs text-slate-400 mt-0.5">{{ \Carbon\Carbon::parse($k->created_at)->format('H:i') }} WIB</div>
                                </td>
                                <td class="py-4 px-5">
                                    <div class="font-bold text-slate-800">{{ $k->pelapor_nama }}</div>
                                    <span class="inline-block text-[10px] bg-slate-200 text-slate-600 px-2 py-0.5 rounded font-semibold mt-1">{{ $k->pelapor_status }}</span>
                                </td>
                                <td class="py-4 px-5">
                                    <div class="font-bold text-slate-800">{{ $k->kode_barang ?? '-' }} - {{ $k->nama_barang }}</div>
                                    <div class="text-xs text-slate-500 mt-0.5">Ruang: {{ $k->nama_ruangan }}</div>
                                </td>
                                <td class="py-4 px-5 max-w-xs">
                                    <p class="text-sm text-slate-700 line-clamp-2 mb-2" title="{{ $k->deskripsi }}">{{ $k->deskripsi }}</p>
                                    
                                    @if($k->foto)
                                        <a href="{{ asset('storage/' . $k->foto) }}" target="_blank" title="Klik untuk melihat foto penuh" class="inline-block mt-1">
                                            <div class="flex items-center gap-2 px-2 py-1 bg-blue-50 border border-blue-100 rounded-lg hover:bg-blue-100 transition-colors">
                                                <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                <span class="text-[11px] font-bold text-blue-600">Lihat Foto</span>
                                            </div>
                                        </a>
                                    @else
                                        <span class="inline-block mt-1 text-[11px] italic text-slate-400">
                                            *Tidak lampirkan foto
                                        </span>
                                    @endif
                                </td>
                                <td class="py-4 px-5">
                                    @if($k->status == 'Menunggu')
                                        <span class="bg-red-100 text-red-700 border border-red-200 px-3 py-1 rounded-full text-xs font-bold inline-flex items-center gap-1.5 shadow-sm">
                                            <span class="w-1.5 h-1.5 bg-red-500 rounded-full animate-ping"></span> Menunggu
                                        </span>
                                    @elseif($k->status == 'Diproses')
                                        <span class="bg-amber-100 text-amber-700 border border-amber-200 px-3 py-1 rounded-full text-xs font-bold shadow-sm">
                                            ⏳ Diproses
                                        </span>
                                    @else
                                        <span class="bg-emerald-100 text-emerald-700 border border-emerald-200 px-3 py-1 rounded-full text-xs font-bold shadow-sm">
                                            ✅ Selesai
                                        </span>
                                    @endif
                                </td>
                                <td class="py-4 px-5">
                                    <div class="flex items-center justify-center gap-2">
                                        <form action="{{ url('/admin/keluhan/update-status/'.$k->id) }}" method="POST" class="inline-block w-full max-w-[130px]">
                                            @csrf
                                            <select name="status" onchange="this.form.submit()" class="w-full text-xs bg-slate-50 border border-slate-300 rounded-lg px-2 py-2 font-bold text-slate-700 focus:outline-none focus:ring-2 focus:ring-sky-500 cursor-pointer shadow-sm">
                                                <option value="Menunggu" {{ $k->status == 'Menunggu' ? 'selected' : '' }}>Set: Menunggu</option>
                                                <option value="Diproses" {{ $k->status == 'Diproses' ? 'selected' : '' }}>Set: Diproses</option>
                                                <option value="Selesai" {{ $k->status == 'Selesai' ? 'selected' : '' }}>Set: Selesai</option>
                                            </select>
                                        </form>

                                        <form action="{{ url('/admin/keluhan/'.$k->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus keluhan ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 text-rose-500 bg-white border border-rose-200 hover:bg-rose-500 hover:text-white hover:border-rose-500 rounded-lg transition-all duration-200 shadow-sm flex items-center justify-center" title="Hapus Keluhan">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="6" class="py-12 text-center text-slate-400 font-medium">Yeay! Belum ada laporan keluhan yang masuk saat ini.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</body>
</html>