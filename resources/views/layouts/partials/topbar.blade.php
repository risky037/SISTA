<header class="bg-green-700 flex items-center justify-between gap-3 px-6 py-3 sticky top-0 z-10">
    <!-- Toggle Sidebar -->
    <button onclick="toggleSidebar()" class="text-white text-lg focus:outline-none">
        <i id="sidebar-toggle-icon" class="fas fa-bars"></i>
    </button>

    @php
        $unreadCount = getUnreadNotificationCount();
    @endphp

    <!-- Profile Menu -->
    <div class="relative">
        <button id="profile-menu-button"
            class="flex items-center gap-3 text-white text-sm font-semibold focus:outline-none">
            <span>
                @auth
                    @if (Auth::user()->role === 'admin')
                        <i class="fas fa-user-shield text-lg"></i>
                    @elseif (Auth::user()->role === 'dosen')
                        <i class="fas fa-user-tie text-lg"></i>
                    @elseif (Auth::user()->role === 'mahasiswa')
                        <i class="fas fa-user-graduate text-lg"></i>
                    @else
                        <i class="fas fa-user text-lg"></i>
                    @endif
                @endauth
            </span>
            <span>
                @auth
                    @if (Auth::user()->role === 'admin' || Auth::user()->role === 'dosen')
                        {{ Auth::user()->name }}
                    @elseif (Auth::user()->role === 'mahasiswa')
                        @if (!empty(Auth::user()->NIM))
                            {{ Auth::user()->NIM }}
                        @else
                            NIM belum diisi
                        @endif
                    @endif
                @endauth
            </span>
            <i class="fas fa-chevron-down text-xs"></i>
            @if ($unreadCount > 0)
                <span class="absolute top-1 right-2 inline-block w-2 h-2 bg-red-500 rounded-full"></span>
            @endif
        </button>

        <div id="profile-menu"
            class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 hidden z-20 fade-in">

            <!-- Profil -->
            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                <i class="fas fa-user-circle mr-2"></i> Profil
            </a>

            <!-- Notifikasi -->
            <a href="#" id="notif-button" onclick="event.preventDefault(); toggleNotificationSidebar();"
                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 relative">
                <i class="fas fa-bell mr-2"></i> Notifikasi
                @if ($unreadCount > 0)
                    <span class="absolute top-1 right-2 inline-block w-2 h-2 bg-red-500 rounded-full"></span>
                @endif
            </a>

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
