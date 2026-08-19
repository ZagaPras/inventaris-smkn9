@if(session('success'))
<div id="toast-success" class="fixed top-24 right-8 flex items-center w-full max-w-xs p-4 mb-4 text-slate-700 bg-white border-l-4 border-emerald-500 rounded-xl shadow-[0_10px_20px_rgba(16,185,129,0.2)] z-[60] transition-all duration-500 ease-out translate-x-0" role="alert">
    <div class="inline-flex items-center justify-center flex-shrink-0 w-10 h-10 bg-emerald-50 text-emerald-500 rounded-lg">
        <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
        </svg>
    </div>
    <div class="ms-3 text-sm font-bold text-slate-800">{{ session('success') }}</div>
</div>

<script>
    // Script untuk menghilangkan notifikasi secara otomatis setelah 3 detik
    setTimeout(() => {
        const toast = document.getElementById('toast-success');
        if(toast) {
            toast.classList.remove('translate-x-0');
            toast.classList.add('translate-x-full', 'opacity-0');
            setTimeout(() => toast.remove(), 500);
        }
    }, 3000);
</script>
@endif