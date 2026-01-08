@if (session('show_mobile_warning'))
    <div id="mobile-warning-modal"
        class="md:hidden fixed inset-0 z-[9999] flex items-center justify-center px-6 transition-opacity duration-300 opacity-0 pointer-events-none">

        <div id="mobile-backdrop"
            class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity duration-300 ease-out">
        </div>

        <div id="mobile-card"
            class="relative bg-white rounded-3xl shadow-2xl w-full max-w-sm p-8 transform transition-all duration-300 ease-out scale-95 opacity-0"
            role="dialog" aria-modal="true">

            <div class="text-center">
                <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-2xl bg-green-50 mb-6">
                    <svg class="w-10 h-10 text-green-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64"
                        fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round"
                        stroke-linejoin="round">
                        <rect x="12" y="14" width="40" height="26" rx="3" />
                        <path d="M6 44h52" />
                    </svg>
                </div>

                <h2 class="text-xl font-bold text-gray-900 mb-3">
                    Optimalkan Pengalaman Anda
                </h2>

                <p class="text-sm text-gray-500 leading-relaxed mb-8">
                    Sistem <strong>SISTA</strong> memiliki fitur manajemen dokumen dan grafik progress yang lebih
                    optimal jika diakses melalui perangkat <strong>Desktop atau Laptop</strong>.
                    <br><br>
                    Beberapa fitur tampilan mungkin terbatas pada layar ponsel Anda.
                </p>

                <button id="close-mobile-btn" type="button"
                    class="w-full inline-flex justify-center items-center px-6 py-3.5 bg-green-600 border border-transparent rounded-2xl font-bold text-white text-xs uppercase tracking-widest hover:bg-green-700 active:bg-green-800 focus:outline-none transition-all duration-200 shadow-lg shadow-green-100">
                    Saya Mengerti
                </button>

                <p class="mt-4 text-[10px] text-gray-400 font-medium uppercase tracking-tighter">
                    Universitas Insan Cita Indonesia
                </p>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modalWrapper = document.getElementById('mobile-warning-modal');
            const modalCard = document.getElementById('mobile-card');
            const closeBtn = document.getElementById('close-mobile-btn');
            if (window.innerWidth < 768) {
                if (modalWrapper && modalCard && closeBtn) {
                    setTimeout(() => {
                        modalWrapper.classList.remove('opacity-0', 'pointer-events-none');
                        modalCard.classList.remove('scale-95', 'opacity-0');
                        modalCard.classList.add('scale-100', 'opacity-100');
                    }, 500);

                    closeBtn.addEventListener('click', function() {
                        modalCard.classList.remove('scale-100', 'opacity-100');
                        modalCard.classList.add('scale-95', 'opacity-0');
                        modalWrapper.classList.add('opacity-0');
                        modalWrapper.classList.add('pointer-events-none');

                        setTimeout(() => {
                            modalWrapper.remove();
                        }, 300);
                    });
                }
            }
        });
    </script>
@endif
