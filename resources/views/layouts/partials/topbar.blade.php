<header class="bg-green-700 flex items-center justify-between gap-3 px-6 py-3 sticky top-0 z-10">
    <!-- Toggle Sidebar -->
    <button onclick="toggleSidebar()" class="text-white text-lg focus:outline-none">
        <i id="sidebar-toggle-icon" class="fas fa-bars"></i>
    </button>

    <!-- Profile Menu -->
    <div class="relative">
        <button id="profile-menu-button"
            class="flex items-center gap-3 text-white text-sm font-semibold focus:outline-none">
            <i class="fas fa-user text-lg"></i>
            <span>
                @auth
                    @if (Auth::user()->role === 'admin' || Auth::user()->role === 'dosen')
                        {{ Auth::user()->name }}
                    @elseif (Auth::user()->role === 'mahasiswa')
                        {{ Auth::user()->NIM }}
                    @endif
                @endauth
            </span>
            <i class="fas fa-chevron-down text-xs"></i>
        </button>

        <div id="profile-menu"
            class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 hidden z-20 fade-in">

            <!-- Profil -->
            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                <i class="fas fa-user-circle mr-2"></i> Profil
            </a>

            <!-- Notifikasi -->
            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                <i class="fas fa-bell mr-2"></i> Notifikasi
            </a>

            {{-- <!-- Dark Mode Toggle -->
            <button id="darkModeBtn" onclick="toggleDarkMode()" 
                class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-700">
                <i id="darkModeIcon" class="fas fa-moon mr-2"></i> 
                <span id="darkModeText">Mode Gelap</span>
            </button> --}}

            <div class="border-t border-gray-100 my-1"></div>

            <!-- Logout -->
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
            <a href="#" onclick="event.preventDefault(); openLogoutModal();"
                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                <i class="fas fa-sign-out-alt mr-2"></i> Logout
            </a>
        </div>
    </div>
</header>

<script>
    function toggleDarkMode() {
        const html = document.documentElement;
        const icon = document.getElementById('darkModeIcon');
        const text = document.getElementById('darkModeText');

        html.classList.toggle('dark');

        if (html.classList.contains('dark')) {
            localStorage.setItem('theme', 'dark');
            icon.classList.remove('fa-moon');
            icon.classList.add('fa-sun');
            text.textContent = 'Mode Terang';
        } else {
            localStorage.setItem('theme', 'light');
            icon.classList.remove('fa-sun');
            icon.classList.add('fa-moon');
            text.textContent = 'Mode Gelap';
        }
    }

    // Saat halaman dimuat, cek localStorage
    if (localStorage.getItem('theme') === 'dark') {
        document.documentElement.classList.add('dark');
        document.getElementById('darkModeIcon').classList.remove('fa-moon');
        document.getElementById('darkModeIcon').classList.add('fa-sun');
        document.getElementById('darkModeText').textContent = 'Mode Terang';
    }
</script>
