<aside class="flex flex-col bg-white border-r border-gray-200 w-64 min-h-screen sticky top-0">
    <div class="flex items-center gap-2 px-5 py-4 border-b border-gray-200">
        <img src="https://storage.googleapis.com/a1aa/image/a311bc9c-5ee4-463e-152b-863ddb501014.jpg" class="w-6 h-6"
            alt="Logo SIA" />
        <span class="text-lg font-normal text-gray-900">Sistem Informasi Tugas Akhir & Skripsi</span>
    </div>
    <nav class="flex flex-col px-5 py-6 space-y-1 text-sm text-gray-600">
        <span class="uppercase text-xs font-semibold mb-2 text-gray-400">Navigasi</span>
        <a href="" class="flex items-center gap-3 px-4 py-2 rounded-full bg-green-600 text-white font-semibold">
            <i class="fas fa-home"></i> Beranda
        </a>
        <a href="" class="flex items-center gap-3 px-4 py-2 rounded hover:bg-gray-100"><i
                class="fas fa-file-alt"></i> Pendaftaran TA/Skripsi</a>
        <a href="" class="flex items-center gap-3 px-4 py-2 rounded hover:bg-gray-100"><i
                class="fas fa-users"></i> Dosen Pembimbing</a>
        <a href="" class="flex items-center gap-3 px-4 py-2 rounded hover:bg-gray-100"><i
                class="fas fa-calendar-check"></i> Jadwal Seminar & Sidang</a>
        <div class="flex flex-col w-full">
            <button id="btn-progres" onclick="toggleSubmenu()"
                class="flex items-center gap-3 px-4 py-2 rounded hover:bg-gray-100 justify-between w-full">
                <span class="flex items-center gap-3"><i class="fas fa-tasks"></i> Progres Tugas Akhir</span>
                <i class="fas fa-chevron-down text-gray-400" id="icon-progres"></i>
            </button>
            <div id="submenu-progres" class="flex flex-col pl-12 mt-1 space-y-1">
                <a href="" class="flex items-center gap-3 px-4 py-2 rounded hover:bg-gray-100">Laporan Bab</a>
                <a href="" class="flex items-center gap-3 px-4 py-2 rounded hover:bg-gray-100">Revisi &
                    Catatan</a>
            </div>
        </div>
        <a href="" class="flex items-center gap-3 px-4 py-2 rounded hover:bg-gray-100"><i
                class="fas fa-upload"></i> Upload Dokumen Akhir</a>
        <a href="" class="flex items-center gap-3 px-4 py-2 rounded hover:bg-gray-100"><i
                class="fas fa-book"></i> Arsip & Nilai</a>
        <a href="" class="flex items-center gap-3 px-4 py-2 rounded hover:bg-gray-100"><i
                class="fas fa-question-circle"></i> Bantuan</a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>

        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
            class="flex items-center gap-3 px-4 py-2 rounded hover:bg-gray-100">
            <i class="fas fa-sign-out-alt"></i> Logout
        </a>
    </nav>
</aside>
