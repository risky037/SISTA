<header class="bg-green-700 flex items-center justify-between gap-3 px-6 py-3 sticky top-0 z-10">
    <button onclick="toggleSidebar()" class="text-white text-lg focus:outline-none">
        <i class="fas fa-bars"></i>
    </button>

    <div class="relative">
        <button id="profile-menu-button"
            class="flex items-center gap-3 text-white text-sm font-semibold focus:outline-none">
            <i class="fas fa-user text-lg"></i>
            <span>310700012210123</span>
            <i class="fas fa-chevron-down text-xs"></i>
        </button>

        <div id="profile-menu" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 hidden z-20 fade-in">
            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                <i class="fas fa-user-circle mr-2"></i> Profil
            </a>
            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                <i class="fas fa-bell mr-2"></i> Notifikasi
            </a>
            <div class="border-t border-gray-100 my-1"></div>
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
