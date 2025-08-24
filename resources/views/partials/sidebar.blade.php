<aside id="sidebar"
    class="flex flex-col bg-white border-r border-gray-200 w-64 min-h-screen sticky top-0 transition-all duration-300">
    <div class="flex items-center gap-2 px-5 py-4 border-b border-gray-200">
        <img src="https://sia.uici.ac.id/images/uici/logo-uici-baru.png" class="w-10 h-10 sidebar-full-item"
            alt="Logo SIA" />
        <span class="text-lg font-normal text-gray-900 sidebar-full-item">Sistem Informasi Tugas Akhir & Skripsi</span>
        <img src="https://sia.uici.ac.id/images/uici/logo-uici-baru.png"
            class="w-10 h-10 hidden sidebar-mini-item mx-auto" alt="Logo SIA Mini">
    <!DOCTYPE html>
<html>
<title>W3.CSS</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/5/w3.css">
<body>

<div class="w3-sidebar w3-bar-block w3-dark-white w3-animate-left" style="display:none" id="mySidebar">
  <button class="w3-bar-item w3-button w3-large"
  onclick="w3_close()">Close &times;</button>
 <a href="{{ route('admin.dashboard') }}"
                class="flex items-center gap-3 px-4 py-2 rounded-full hover:bg-green-100 text-gray-600">
                <i class="fas fa-question-circle"></i>
                <span class="sidebar-full-item">Bantuan</span>
                <span class="tooltip hidden sidebar">Bantuan</span>
  <a href="#" class="w3-bar-item w3-button">Link 2</a>
  <a href="#" class="w3-bar-item w3-button">Link 3</a>
</div>

<div>
  <button class="w3-button w3-white w3-xxlarge" onclick="w3_open()">&#9776;</button>
  <div class="w3-container">
    <h1>Animated Sidebar</h1>
    <p>Click on the "hamburger menu" to slide in the side navigation.</p>
    <p>W3.CSS provide the following animation classes if you want to experiment for yourself:</p>
    <p>w3-animate-left, w3-animate-top, w3-anite-bottom, w3-animate-right, w3-animate-opacity, w3-animate-zoom</p>
  </div>
</div>

<script>
function w3_open() {
    document.getElementById("mySidebar").style.display = "block";
}
function w3_close() {
    document.getElementById("mySidebar").style.display = "none";
}
</script>
     
</body>
</html> 

    <nav class="flex flex-col px-5 py-6 space-y-1 text-sm text-gray-600">
        @if (auth()->user()->role == 'admin')
            <span class="uppercase text-xs font-semibold mb-2 text-gray-400 sidebar-full-item">Navigasi</span>
            <a href="{{ route('admin.dashboard') }}"
                class="flex items-center gap-3 px-4 py-2 rounded-full {{ request()->routeIs('admin.dashboard') ? 'bg-green-600 text-white font-semibold' : 'hover:bg-gray-100 text-gray-600' }}">
                <i class="fas fa-home"></i>
                <span class="sidebar-full-item">Beranda</span>
            </a>
            <a href="{{ route('admin.management.admin.index') }}"
                class="flex items-center gap-3 px-4 py-2 rounded-full {{ request()->routeIs('admin.management.admin.*') ? 'bg-green-600 text-white font-semibold' : 'hover:bg-gray-100 text-gray-600' }}">
                <i class="fas fa-user-plus"></i>
                <span class="sidebar-full-item">Admin</span>
                <span class="tooltip hidden sidebar">Admin</span>
            </a>
            <a href="{{ route('admin.management.mahasiswa.index') }}"
                class="flex items-center gap-3 px-4 py-2 rounded-full  {{ request()->routeIs('admin.management.mahasiswa.*') ? 'bg-green-600 text-white font-semibold' : 'hover:bg-gray-100 text-gray-600' }}">
                <i class="fas fa-user-graduate"></i>
                <span class="sidebar-full-item">Data Mahasiswa</span>
                <span class="tooltip hidden sidebar">Data Mahasiswa</span>
                
            
            <a href="{{ route('admin.management.dosen.index') }}"
                class="flex items-center gap-3 px-4 py-2 rounded-full {{ request()->routeIs('admin.management.dosen.*') ? 'bg-green-600 text-white font-semibold' : 'hover:bg-gray-100 text-gray-600' }}">
                <i class="fas fa-user-tie"></i>
                <span class="sidebar-full-item">Dosen Pembimbing</span>
                <span class="tooltip hidden sidebar">Dosen Pembimbing</span>

            <a href="{{ route('users.index') }}"
                class="flex items-center gap-3 px-4 py-2 rounded-full hover:bg-green-100 text-gray-600">
                <i class="fas fa-calendar-alt"></i>
                <span class="sidebar-full-item">Jadwal Sidang</span>
                <span class="tooltip hidden sidebar">Jadwal Sidang</span>

            <a href="{{ route('users.index') }}"
                class="flex items-center gap-3 px-4 py-2 rounded-full hover:bg-green-100 text-gray-600">
                <i class="fas fa-file-alt"></i>
                <span class="sidebar-full-item">Proposal</span>
                <span class="tooltip hidden sidebar">Proposal</span>

            <a href="{{ route('users.index') }}"
                class="flex items-center gap-3 px-4 py-2 rounded-full hover:bg-green-100 text-gray-600">
                <i class="fas fa-cogs"></i>
                <span class="sidebar-full-item">Pengaturan</span>
                <span class="tooltip hidden sidebar">Pengaturan</span>
            <div class="border-t border-gray-200 my-2"></div>

            <a href="{{ route('admin.dashboard') }}"
                class="flex items-center gap-3 px-4 py-2 rounded-full hover:bg-green-100 text-gray-600">
                <i class="fas fa-question-circle"></i>
                <span class="sidebar-full-item">Bantuan</span>
                <span class="tooltip hidden sidebar">Bantuan</span>
            <a href="{{ route('admin.dashboard') }}"
                class="flex items-center gap-3 px-4 py-2 rounded-full hover:bg-green-100 text-gray-600">
                <i class="fas fa-info-circle"></i>
                <span class="sidebar-full-item">Tentang</span>
                <span class="tooltip hidden sidebar">Tentang</span>
            <div class="border-t border-gray-200 my-2"></div>
            <a href="#" onclick="event.preventDefault(); openLogoutModal()"     
                class="flex items-center gap-3 px-4 py-2 rounded-full hover:bg-red-100 text-red-600">
                
                
                <span class="tooltip hidden sidebar">Keluar</span>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        @else           
            <span class="uppercase text-xs font-semibold mb-2 text-gray-400 sidebar-full-item">Navigasi</span>
            <a href="{{ route('admin.dashboard') }}"
                class="flex items-center gap-3 px-4 py-2 rounded-full bg-green-600 text-white font-semibold">
                <i class="fas fa-home"></i>
                <span class="sidebar-full-item">Beranda</span>
                <span class="tooltip hidden sidebar">Beranda</span>
            </a>
            
        @endif
        @if (auth()->user()->role == 'superadmin')
            
            </a>
            <a href="{{ route('admin.management.admin.index') }}"
                class="flex items-center gap-3 px-4 py-2 rounded-full {{ request()->routeIs('admin.management.admin.*') ? 'bg-green-600 text-white font-semibold' : 'hover:bg-gray-100 text-gray-600' }}">
                <i class="fas fa-user-plus"></i>
                <span class="sidebar-full-item">Admin</span>
                <span class="tooltip hidden sidebar">Admin</span>
            </a>

            <a href="{{ route('users.index') }}"
                class="flex items-center gap-3 px-4 py-2 rounded-full hover:bg-green-100 text-gray-600">
                <i class="fas fa-question-circle"></i>
                <span class="sidebar-full-item">Bantuan</span>
                <span class="tooltip hidden sidebar">Bantuan</span>
            
        @endif
        @if (auth()->user()->role == 'dosen')

         <a href="{{ route('users.index') }}"
                class="flex items-center gap-3 px-4 py-2 rounded-full hover:bg-green-100 text-gray-600">
                <i class="fas fa-user-graduate"></i>
                <span class="sidebar-full-item">Daftar Mahasiswa Bimbingan</span>
                <span class="tooltip hidden sidebar">Daftar Mahasiswa Bimbingan</span>

        <a href="{{ route('users.index') }}"
                class="flex items-center gap-3 px-4 py-2 rounded-full hover:bg-green-100 text-gray-600">
                <i class="fas fa-calendar-check"></i>
                <span class="sidebar-full-item">Jadwal Bimbingan</span>
                <span class="tooltip hidden sidebar">Jadwal Bimbingan</span>
        
        <a href="{{ route('users.index') }}"
                class="flex items-center gap-3 px-4 py-2 rounded-full hover:bg-green-100 text-gray-600">
                <i class="fas fa-tasks"></i>
                <span class="sidebar-full-item">Review Proposal/Skripsi</span>
                <span class="tooltip hidden sidebar">Review Proposal/Skripsi</span>

         <a href="{{ route('users.index') }}"
                class="flex items-center gap-3 px-4 py-2 rounded-full hover:bg-green-100 text-gray-600">
                <i class="fas fa-chart-line"></i>
                <span class="sidebar-full-item">Laporan Progres Mahasiswa</span>
                <span class="tooltip hidden sidebar">Laporan Progres Mahasiswa</span>
        <a href="{{ route('users.index') }}"
                class="flex items-center gap-3 px-4 py-2 rounded-full hover:bg-green-100 text-gray-600">
                <i class="fas fa-question-circle"></i>
                <span class="sidebar-full-item">Bantuan</span>
                <span class="tooltip hidden sidebar">Bantuan</span>
        <a href="{{ route('users.index') }}"
                class="flex items-center gap-3 px-4 py-2 rounded-full hover:bg-green-100 text-gray-600">
                <i class="fas fa-info-circle"></i>
                <span class="sidebar-full-item">Tentang</span>
                <span class="tooltip hidden sidebar">Tentang</span>
        <div class="border-t border-gray-200 my-2"></div>
        <a href="#" onclick="event.preventDefault(); openLogoutModal()"
            class="flex items-center gap-3 px-4 py-2 rounded-full hover:bg-red-100 text-red-600">
            <i class="fas fa-sign-out-alt"></i>
            <span class="sidebar-full-item">Keluar</span>
            <span class="tooltip hidden sidebar">Keluar</span>
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
            

        @endif
        @if (auth()->user()->role == 'mahasiswa')
            
            </a>
            <a href="#" class="flex items-center gap-3 px-4 py-2 rounded hover:bg-gray-100">
                <i class="fas fa-calendar-check"></i>
                <span class="sidebar-full-item">Jadwal Seminar & Sidang</span>
                <span class="tooltip hidden">Jadwal Seminar & Sidang</span>
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

            <a href="#" class="flex items-center gap-3 px-4 py-2 rounded hover:bg-gray-100">
                <i class="fas fa-file-alt"></i>
                <span class="sidebar-full-item">Proposal & Skripsi</span>
                <span class="tooltip hidden">Proposal & Skripsi</span>
            </a>

            <a href="#" class="flex items-center gap-3 px-4 py-2 rounded hover:bg-gray-100">
                <i class="fas fa-file-upload"></i>
                <span class="sidebar-full-item">Upload Dokumen Akhir</span>
                <span class="tooltip hidden">Upload Dokumen Akhir</span>
            </a>

            <a href="#" class="flex items-center gap-3 px-4 py-2 rounded hover:bg-gray-100">
                <i class="fas fa-book"></i>
                <span class="sidebar-full-item">Arsip & Nilai</span>
                <span class="tooltip hidden">Arsip & Nilai</span>
            </a>

            <a href="#" class="flex items-center gap-3 px-4 py-2 rounded hover:bg-gray-100">
                <i class="fas fa-question-circle"></i>
                <span class="sidebar-full-item">Bantuan</span>
                <span class="tooltip hidden">Bantuan</span>
            </a>
            <a href="#" class="flex items-center gap-3 px-4 py-2 rounded hover:bg-gray-100">
                <i class="fas fa-info-circle"></i>
                <span class="sidebar-full-item">Tentang</span>
                <span class="tooltip hidden">Tentang</span>
            </a>
            <div class="border-t border-gray-200 my-2"></div>
            <a href="#" onclick="event.preventDefault(); openLogoutModal()"
                class="flex items-center gap-3 px-4 py-2 rounded hover:bg-red-100 text-red-600">
                <i class="fas fa-sign-out-alt"></i>
                <span class="sidebar-full-item">Keluar</span>
                <span class="tooltip hidden">Keluar</span>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        @else   

           
            </form>
        @endif
    </nav>
</aside>
