<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>@yield('title', 'Dashboard Mahasiswa – Sistem Informasi Tugas Akhir')</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
  <style>
    ::-webkit-scrollbar { width: 6px; height: 6px; }
    ::-webkit-scrollbar-thumb { background-color: #4a5568; border-radius: 3px; }
  </style>
  @stack('styles')
</head>
<body class="bg-gray-100 font-sans text-gray-800">
  <div class="flex min-h-screen">
    
    <!-- Sidebar -->
    <aside class="flex flex-col w-64 bg-white border-r border-gray-200">
      <div class="flex items-center gap-2 px-4 py-3 border-b border-gray-200">
        <i class="fas fa-user-graduate text-green-600 text-2xl"></i>
        <span class="text-lg font-normal text-gray-900">Dashboard Mahasiswa</span>
      </div>
      <nav class="flex-1 overflow-y-auto px-2 py-4 text-gray-600 text-sm">
        <div class="mb-4 uppercase text-xs font-semibold text-gray-400">Menu</div>
        <ul class="space-y-1">
          <li><button onclick="showContent('proposal')" class="w-full text-left flex items-center gap-2 px-4 py-2 rounded hover:bg-gray-100"><i class="fas fa-upload"></i> Ajukan Proposal</button></li>
          <li><button onclick="showContent('status')" class="w-full text-left flex items-center gap-2 px-4 py-2 rounded hover:bg-gray-100"><i class="fas fa-search"></i> Status Proposal</button></li>
          <li><button onclick="showContent('revisi')" class="w-full text-left flex items-center gap-2 px-4 py-2 rounded hover:bg-gray-100"><i class="fas fa-paperclip"></i> Upload Revisi</button></li>
          <li><button onclick="showContent('jadwal')" class="w-full text-left flex items-center gap-2 px-4 py-2 rounded hover:bg-gray-100"><i class="fas fa-calendar-alt"></i> Jadwal Bimbingan</button></li>
          <li><button onclick="showContent('template')" class="w-full text-left flex items-center gap-2 px-4 py-2 rounded hover:bg-gray-100"><i class="fas fa-download"></i> Download Template</button></li>
          <li><button onclick="showContent('profil')" class="w-full text-left flex items-center gap-2 px-4 py-2 rounded hover:bg-gray-100"><i class="fas fa-user"></i> Profil Mahasiswa</button></li>
        </ul>
      </nav>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col">
      <!-- Top bar -->
      <header class="flex items-center justify-between bg-green-700 px-6 py-3 text-white">
        <div class="flex items-center gap-2">
          <i class="fas fa-id-card"></i>
          <span class="font-mono text-sm">NIM: 12345678</span>
        </div>
        <span>Budi Mahasiswa</span>
      </header>

      <!-- Page Content -->
      <main class="flex-1 overflow-y-auto p-6 bg-gray-100">
        @yield('content')
      </main>
    </div>
  </div>

  @stack('scripts')
</body>
</html>
