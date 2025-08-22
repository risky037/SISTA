<aside id="sidebar"
    class="flex flex-col bg-white border-r border-gray-200 w-64 min-h-screen sticky top-0 transition-all duration-300 overflow-hidden">

    <!-- Header / Logo -->
    <div class="flex items-center gap-2 px-5 py-4 border-b border-gray-200">
        <img src="https://sia.uici.ac.id/images/uici/logo-uici-baru.png"
            class="w-10 h-10 sidebar-full-item" alt="Logo SIA" />
        <span class="text-lg font-normal text-gray-900 sidebar-full-item">
            Sistem Informasi Tugas Akhir & Skripsi
        </span>
        <img src="https://sia.uici.ac.id/images/uici/logo-uici-baru.png"
            class="w-10 h-10 hidden sidebar-mini-item mx-auto" alt="Logo Mini">
    </div>

    <!-- Navigasi -->
    <nav class="flex flex-col px-3 py-6 space-y-1 text-sm text-gray-600">
        @if (auth()->user()->role == 'admin')
            <span class="uppercase text-xs font-semibold mb-2 text-gray-400 sidebar-full-item">Navigasi</span>

            <!-- Beranda -->
            <a href="{{ route('admin.dashboard') }}"
                class="flex items-center gap-3 px-4 py-2 rounded-full transition-colors
                {{ request()->routeIs('admin.dashboard') ? 'bg-green-600 text-white font-semibold' : 'hover:bg-gray-100 text-gray-600' }}">
                <i class="fas fa-home"></i>
                <span class="sidebar-full-item">Beranda</span>
            </a>

            <!-- Admin -->
            <a href="{{ route('admin.management.admin.index') }}"
                class="flex items-center gap-3 px-4 py-2 rounded-full transition-colors
                {{ request()->routeIs('admin.management.admin.*') ? 'bg-green-600 text-white font-semibold' : 'hover:bg-gray-100 text-gray-600' }}">
                <i class="fas fa-user-plus"></i>
                <span class="sidebar-full-item">Admin</span>
            </a>

            <!-- Data Mahasiswa -->
            <a href="{{ route('users.index') }}"
                class="flex items-center gap-3 px-4 py-2 rounded-full hover:bg-gray-100 text-gray-600 transition-colors">
                <i class="fas fa-user-graduate"></i>
                <span class="sidebar-full-item">Data Mahasiswa</span>
            </a>

            <!-- Lainnya -->
            <a href="#" class="flex items-center gap-3 px-4 py-2 rounded hover:bg-gray-100 transition-colors">
                <i class="fas fa-user-tie"></i>
                <span class="sidebar-full-item">Dosen Pembimbing</span>
            </a>

            <a href="#" class="flex items-center gap-3 px-4 py-2 rounded hover:bg-gray-100 transition-colors">
                <i class="fas fa-calendar-alt"></i>
                <span class="sidebar-full-item">Jadwal Sidang</span>
            </a>

            <a href="#" class="flex items-center gap-3 px-4 py-2 rounded hover:bg-gray-100 transition-colors">
                <i class="fas fa-file-alt"></i>
                <span class="sidebar-full-item">Proposal</span>
            </a>

            <a href="#" class="flex items-center gap-6 px-4 py-4 rounded hover:bg-gray-100 transition-colors">
                <i class="fas fa-cogs"></i>
                <span class="sidebar-full-item">setting</span>
            </a>
        @endif
    </nav>
</aside>

<!-- CSS -->
<style>
    /* Default lebar normal */
    #sidebar {
        width: 25rem; /* w-64 */
    }

    /* Collapse jadi kecil */
    #sidebar.collapsed {
        width: 4rem; /* w-16 cukup utk ikon */
    }

    /* Hilangkan semua teks/logonya saat collapsed */
    #sidebar.collapsed .sidebar-full-item {
        display: none !important;
    }

    /* Tampilkan logo mini */
    #sidebar.collapsed .sidebar-mini-item {
        display: block !important;
    }

    /* Supaya ikon center saat collapsed */
    #sidebar.collapsed a {
        justify-content: center;
        gap: 0; /* hilangkan jarak agar hanya ikon */
    }
</style>

<!-- JS Toggle -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const sidebar = document.getElementById("sidebar");

        // contoh toggle pakai tombol "m"
        document.addEventListener("keydown", function (e) {
            if (e.key === "m") {
                sidebar.classList.toggle("collapsed");
            }
        });
    });
</script>

        @endif
        @if (auth()->user()->role == 'dosen')
            <span class="uppercase text-xs font-semibold mb-2 text-gray-400 sidebar-full-item">Navigasi</span>
            <a href="{{ route('admin.dashboard') }}"
                class="flex items-center gap-3 px-4 py-2 rounded-full bg-green-600 text-white font-semibold">
                <i class="fas fa-home"></i>
                <span class="sidebar-full-item">Beranda</span>
                <span class="tooltip hidden sidebar-mini-item">Beranda</span>
            </a>
            <a href="#" class="flex items-center gap-3 px-4 py-2 rounded hover:bg-gray-100"><i
                    class="fas fa-user-graduate"></i> Daftar Mahasiswa Bimbingan</a>
            <a href="#" class="flex items-center gap-3 px-4 py-2 rounded hover:bg-gray-100"><i
                    class="fas fa-calendar-check"></i> Jadwal Bimbingan</a>
            <a href="#" class="flex items-center gap-3 px-4 py-2 rounded hover:bg-gray-100"><i
                    class="fas fa-calendar-alt"></i> Jadwal Sidang</a>
            <a href="#" class="flex items-center gap-3 px-4 py-2 rounded hover:bg-gray-100"><i
                    class="fas fa-file-alt"></i> Review Proposal/Skripsi</a>
            <a href="#" class="flex items-center gap-3 px-4 py-2 rounded hover:bg-gray-100"><i
                    class="fas fa-chart-line"></i> Laporan Progres Mahasiswa</a>
        @endif
        @if (auth()->user()->role == 'mahasiswa')
            <span class="uppercase text-xs font-semibold mb-2 text-gray-400 sidebar-full-item">Navigasi</span>
            <a href="{{ route('admin.dashboard') }}"
                class="flex items-center gap-3 px-4 py-2 rounded-full bg-green-600 text-white font-semibold">
                <i class="fas fa-home"></i>
                <span class="sidebar-full-item">Beranda</span>
                <span class="tooltip hidden sidebar-mini-item">Beranda</span>
            </a>
            <a href="#" class="flex items-center gap-3 px-4 py-2 rounded hover:bg-gray-100">
                <i class="fas fa-calendar-check"></i>
                <span class="sidebar-full-item">Jadwal Seminar & Sidang</span>
                <span class="tooltip hidden sidebar-mini-item">Jadwal Seminar & Sidang</span>
            </a>
            <div class="flex flex-col w-full sidebar-full-item">
                <button id="btn-progres" onclick="toggleSubmenu()"
                    class="flex items-center gap-3 px-4 py-2 rounded hover:bg-gray-100 justify-between w-full">
                    <span class="flex items-center gap-3"><i class="fas fa-tasks"></i> Progres Tugas Akhir</span>
                    <i class="fas fa-chevron-down text-gray-400" id="icon-progres"></i>
                </button>
                <div id="submenu-progres" class="flex flex-col pl-12 mt-1 space-y-1">
                    <a href="#" class="flex items-center gap-3 px-4 py-2 rounded hover:bg-gray-100">Laporan
                        Bab</a>
                    <a href="#" class="flex items-center gap-3 px-4 py-2 rounded hover:bg-gray-100">Revisi &
                        Catatan</a>
                </div>
            </div>
            <a href="#" class="flex items-center gap-3 px-4 py-2 rounded hover:bg-gray-100"><i
                    class="fas fa-upload"></i> Upload Dokumen Akhir</a>
            <a href="#" class="flex items-center gap-3 px-4 py-2 rounded hover:bg-gray-100"><i
                    class="fas fa-book"></i> Arsip & Nilai</a>
            <a href="#" class="flex items-center gap-3 px-4 py-2 rounded hover:bg-gray-100"><i
                    class="fas fa-question-circle"></i> Bantuan</a>
        @endif
    </nav>
</aside>
