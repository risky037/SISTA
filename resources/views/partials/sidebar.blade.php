<aside class="flex flex-col bg-white border-r border-gray-200 w-64 min-h-screen sticky top-0">
    <div class="flex items-center gap-2 px-5 py-4 border-b border-gray-200">
        <img src="https://storage.googleapis.com/a1aa/image/a311bc9c-5ee4-463e-152b-863ddb501014.jpg" class="w-6 h-6"
            alt="Logo SIA" />
        <span class="text-lg font-normal text-gray-900">Sistem Informasi Tugas Akhir & Skripsi</span>
    </div>
    <nav class="flex flex-col px-5 py-6 space-y-1 text-sm text-gray-600">
        @if (auth()->user()->role == 'admin')
            <span class="uppercase text-xs font-semibold mb-2 text-gray-400">Navigasi</span>
            <a href="{{ route('admin.dashboard') }}"
                class="flex items-center gap-3 px-4 py-2 rounded-full {{ request()->routeIs('admin.dashboard') ? 'bg-green-600 text-white font-semibold' : 'hover:bg-gray-100 text-gray-600' }}">
                <i class="fas fa-home"></i> Beranda
            </a>
            <a href="{{ route('users.index') }}"
                class="flex items-center gap-3 px-4 py-2 rounded-full hover:bg-gray-100 text-gray-600">
                <i class="fas fa-user-plus"></i> Admin
            </a>
            <a href="{{ route('users.index') }}"
                class="flex items-center gap-3 px-4 py-2 rounded-full hover:bg-gray-100 text-gray-600">
                <i class="fas fa-user-graduate"></i> Data Mahasiswa
            </a>
            <a href="#" class="flex items-center gap-3 px-4 py-2 rounded hover:bg-gray-100"><i
                    class="fas fa-user-tie"></i>Dosen Pembimbing</a>
            <a href="#" class="flex items-center gap-3 px-4 py-2 rounded hover:bg-gray-100"><i
                    class="fas fa-calendar-alt"></i>Jadwal Sidang</a>
            <a href="#" class="flex items-center gap-3 px-4 py-2 rounded hover:bg-gray-100"><i
                    class="fas fa-file-alt"></i>Proposal</a>
            <a href="#" class="flex items-center gap-3 px-4 py-2 rounded hover:bg-gray-100"><i
                    class="fas fa-cogs"></i>Pengaturan</a>
        @endif
        @if (auth()->user()->role == 'dosen')
            <span class="uppercase text-xs font-semibold mb-2 text-gray-400">Navigasi</span>
            <a href="{{ route('admin.dashboard') }}"
                class="flex items-center gap-3 px-4 py-2 rounded-full bg-green-600 text-white font-semibold">
                <i class="fas fa-home"></i> Beranda
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
            <span class="uppercase text-xs font-semibold mb-2 text-gray-400">Navigasi</span>
            <a href="{{ route('admin.dashboard') }}"
                class="flex items-center gap-3 px-4 py-2 rounded-full bg-green-600 text-white font-semibold">
                <i class="fas fa-home"></i> Beranda
            </a>
            <a href="#" class="flex items-center gap-3 px-4 py-2 rounded hover:bg-gray-100"><i
                    class="fas fa-calendar-check"></i> Jadwal Seminar & Sidang</a>
            <div class="flex flex-col w-full">
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
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>

        <a href="#" onclick="event.preventDefault(); openLogoutModal();"
            class="flex items-center gap-3 px-4 py-2 rounded hover:bg-gray-100">
            <i class="fas fa-sign-out-alt"></i> Logout
        </a>
    </nav>
</aside>


<div id="logoutModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-sm fade-in">
        <h2 class="text-lg font-bold mb-4">Konfirmasi Logout</h2>
        <div class="mb-4 text-sm text-gray-700">
            Anda yakin ingin logout?
        </div>
        <div class="flex justify-end gap-3">
            <button onclick="closeModal()"
                class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded">Batal</button>
            <button onclick="document.getElementById('logout-form').submit();"
                class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded">Ya, Logout</button>
        </div>
    </div>
</div>


