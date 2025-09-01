<aside id="sidebar"
    class="fixed inset-y-0 left-0 transform bg-white border-r border-gray-200 w-64 transition-transform duration-300 z-40">
    <div class="flex flex-col h-full">
        <div class="flex items-center gap-2 px-5 py-4 border-b border-gray-200">
            <img src="https://sia.uici.ac.id/images/uici/logo-uici-baru.png" class="w-10 h-10" alt="Logo SIA" />
            <span class="text-lg font-normal text-gray-900">Sistem Informasi Tugas Akhir & Skripsi</span>
            <button onclick="toggleSidebar()" id="sidebar-toggle-button"
                class="lg:hidden p-2 rounded-full text-gray-600 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-green-500 ml-auto">
                <i class="fas fa-arrow-left"></i>
            </button>
        </div>
        <nav class="flex flex-col px-5 py-6 space-y-1 text-sm text-gray-600 overflow-y-auto">
            <span class="uppercase text-xs font-semibold mb-2 text-gray-400">Navigasi</span>
            <a href="{{ auth()->user()->role == 'admin'
                ? route('admin.dashboard')
                : (auth()->user()->role == 'mahasiswa'
                    ? route('mahasiswa.dashboard')
                    : route('dosen.dashboard')) }}"
                class="flex items-center gap-3 px-4 py-2 rounded-full {{ request()->routeIs('admin.dashboard') ||
                request()->routeIs('mahasiswa.dashboard') ||
                request()->routeIs('dosen.dashboard')
                    ? 'bg-green-600 text-white font-semibold'
                    : 'hover:bg-gray-100 text-gray-600' }}">
                <i class="fas fa-home"></i>
                <span>Beranda</span>
            </a>
            @if (auth()->user()->role == 'admin')
                <a href="{{ route('admin.management.admin.index') }}"
                    class="flex items-center gap-3 px-4 py-2 rounded-full {{ request()->routeIs('admin.management.admin.*') ? 'bg-green-600 text-white font-semibold' : 'hover:bg-gray-100 text-gray-600' }}">
                    <i class="fas fa-user-plus"></i>
                    <span>Admin</span>
                </a>
                <a href="{{ route('admin.management.mahasiswa.index') }}"
                    class="flex items-center gap-3 px-4 py-2 rounded-full {{ request()->routeIs('admin.management.mahasiswa.*') ? 'bg-green-600 text-white font-semibold' : 'hover:bg-gray-100 text-gray-600' }}">
                    <i class="fas fa-user-plus"></i>
                    <span>Mahasiswa</span>
                </a>
                <a href="{{ route('admin.management.dosen.index') }}"
                    class="flex items-center gap-3 px-4 py-2 rounded-full {{ request()->routeIs('admin.management.dosen.*') ? 'bg-green-600 text-white font-semibold' : 'hover:bg-gray-100 text-gray-600' }}">
                    <i class="fas fa-user-tie"></i>
                    <span>Dosen Pembimbing</span>
                </a>
                <a href="{{ route('admin.jadwal.index') }}"
                    class="flex items-center gap-3 px-4 py-2 rounded-full {{ request()->routeIs('admin.jadwal.*') ? 'bg-green-600 text-white font-semibold' : 'hover:bg-gray-100 text-gray-600' }}">
                    <i class="fas fa-calendar-alt"></i>
                    <span>Jadwal Sidang</span>
                </a>
                <a href="{{ route('admin.proposal.index') }}"
                    class="flex items-center gap-3 px-4 py-2 rounded-full {{ request()->routeIs('admin.proposal.*') ? 'bg-green-600 text-white font-semibold' : 'hover:bg-gray-100 text-gray-600' }}">
                    <i class="fas fa-file-alt"></i>
                    <span>Proposal</span>
                </a>
                <a href="#"
                    class="flex items-center gap-3 px-4 py-2 rounded-full hover:bg-green-100 text-gray-600">
                    <i class="fas fa-cogs"></i>
                    <span>Pengaturan</span>
                </a>
            @elseif (auth()->user()->role == 'dosen')
                <a href="{{ route('dosen.bimbingan.index') }}"
                    class="flex items-center gap-3 px-4 py-2 rounded-full {{ request()->routeIs('dosen.bimbingan.*') ? 'bg-green-600 text-white font-semibold' : 'hover:bg-gray-100 text-gray-600' }}">
                    <i class="fas fa-user-graduate"></i>
                    <span>Mahasiswa Bimbingan</span>
                </a>
                <a href="{{ route('dosen.jadwalbimbingan.index') }}"
                    class="flex items-center gap-3 px-4 py-2 rounded-full {{ request()->routeIs('dosen.jadwalbimbingan.*') ? 'bg-green-600 text-white font-semibold' : 'hover:bg-gray-100 text-gray-600' }}">
                    <i class="fas fa-calendar-check"></i>
                    <span>Jadwal Bimbingan</span>
                </a>
                <a href="{{ route('dosen.proposals.index') }}"
                    class="flex items-center gap-3 px-4 py-2 rounded-full {{ request()->routeIs('dosen.proposals.*') ? 'bg-green-600 text-white font-semibold' : 'hover:bg-gray-100 text-gray-600' }}">
                    <i class="fas fa-tasks"></i>
                    <span>Review Proposal/Skripsi</span>
                </a>
                <a href="{{ route('dosen.laporan-progress.index') }}"
                    class="flex items-center gap-3 px-4 py-2 rounded-full {{ request()->routeIs('dosen.laporan-progress.*') ? 'bg-green-600 text-white font-semibold' : 'hover:bg-gray-100 text-gray-600' }}">
                    <i class="fas fa-chart-line"></i>
                    <span>Laporan Progres</span>
                </a>
            @elseif (auth()->user()->role == 'mahasiswa')
                <a href="{{ route('mahasiswa.jadwal-seminar') }}" class="flex items-center gap-3 px-4 py-2 rounded-full {{ request()->routeIs('mahasiswa.jadwal-seminar') ? 'bg-green-600 text-white font-semibold' : 'hover:bg-gray-100 text-gray-600' }}">
                    <i class="fas fa-calendar-check"></i>
                    <span>Jadwal Seminar & Sidang</span>
                </a>
                <div class="flex flex-col w-full">
                    <button id="btn-progres" onclick="toggleSubmenu()"
                        class="flex items-center gap-3 px-4 py-2 rounded hover:bg-gray-100 justify-between w-full">
                        <span class="flex items-center gap-3"><i class="fas fa-tasks"></i> Progres Tugas Akhir</span>
                        <i class="fas fa-chevron-down text-gray-400" id="icon-progres"></i>
                    </button>
                    <div id="submenu-progres" class="hidden flex-col pl-12 mt-1 space-y-1">
                        <a href="#"
                            class="flex items-center gap-3 px-4 py-2 rounded-full hover:bg-gray-100">Laporan Bab</a>
                        <a href="#"
                            class="flex items-center gap-3 px-4 py-2 rounded-full hover:bg-gray-100">Revisi &
                            Catatan</a>
                    </div>
                </div>
                <a href="#" class="flex items-center gap-3 px-4 py-2 rounded-full hover:bg-gray-100">
                    <i class="fas fa-file-alt"></i>
                    <span>Proposal & Skripsi</span>
                </a>
                <a href="#" class="flex items-center gap-3 px-4 py-2 rounded-full hover:bg-gray-100">
                    <i class="fas fa-file-upload"></i>
                    <span>Upload Dokumen Akhir</span>
                </a>
                <a href="#" class="flex items-center gap-3 px-4 py-2 rounded-full hover:bg-gray-100">
                    <i class="fas fa-book"></i>
                    <span>Arsip & Nilai</span>
                </a>
            @endif
            <div class="border-t border-gray-200 my-2"></div>
            <a href="#" class="flex items-center gap-3 px-4 py-2 rounded-full hover:bg-green-100 text-gray-600">
                <i class="fas fa-question-circle"></i>
                <span>Bantuan</span>
            </a>
            <a href="#" class="flex items-center gap-3 px-4 py-2 rounded-full hover:bg-green-100 text-gray-600">
                <i class="fas fa-info-circle"></i>
                <span>Tentang</span>
            </a>
            <div class="border-t border-gray-200 my-2"></div>
            <a href="#" onclick="event.preventDefault(); openLogoutModal()"
                class="flex items-center gap-3 px-4 py-2 rounded-full hover:bg-red-100 text-red-600">
                <i class="fas fa-sign-out-alt"></i>
                <span>Keluar</span>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </nav>
    </div>
</aside>
