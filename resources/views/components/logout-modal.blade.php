<div id="logoutModal"
    class="fixed inset-0 z-[999] flex items-center justify-center px-4 transition-all duration-300 opacity-0 pointer-events-none">
    <div id="logoutBackdrop" class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity duration-300">
    </div>
    <div id="logoutCard"
        class="relative bg-white rounded-3xl shadow-2xl w-full max-w-sm p-8 transform transition-all duration-300 scale-95 opacity-0">

        <div class="text-center">
            <div class="mx-auto flex items-center justify-center h-20 w-20 rounded-full bg-red-50 mb-6">
                <div class="h-14 w-14 rounded-full bg-red-100 flex items-center justify-center text-red-600">
                    <svg class="w-7 h-7" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64" fill="none"
                        stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 12v40" />
                        <path d="M24 32h24" />
                        <path d="M38 20l12 12-12 12" />
                    </svg>
                </div>
            </div>
            <h2 class="text-xl font-bold text-gray-900 mb-2">Konfirmasi Keluar</h2>
            <p class="text-sm text-gray-500 leading-relaxed mb-8">
                Apakah Anda yakin ingin mengakhiri sesi ini? Perubahan yang belum disimpan mungkin akan hilang.
            </p>

            <div class="flex flex-col gap-3">
                <button onclick="localStorage.clear();document.getElementById('logout-form').submit();"
                    class="w-full py-3.5 bg-red-600 hover:bg-red-700 text-white rounded-2xl font-bold text-xs uppercase tracking-widest transition-all duration-200 shadow-lg shadow-red-200">
                    Ya, Logout Sekarang
                </button>
                <button onclick="closeLogoutModal()"
                    class="w-full py-3.5 bg-gray-50 hover:bg-gray-100 text-gray-600 rounded-2xl font-bold text-xs uppercase tracking-widest transition-all duration-200">
                    Batalkan
                </button>
            </div>

            <p class="mt-6 text-[10px] text-gray-300 font-bold uppercase tracking-widest">
                SISTA &copy; {{ date('Y') }}
            </p>
        </div>
    </div>
</div>
