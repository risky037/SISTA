<!-- original-sidebar -->
 
<aside id="sidebar"
    class="fixed inset-y-0 left-0 transform bg-white border-r border-gray-200 w-64 transition-transform duration-300 z-40">
    <div class="flex flex-col h-full">
        <div class="flex items-center gap-2 px-5 py-4 border-b border-gray-200">
            <a href="{{ route(Auth::user()->role . '.dashboard') }}" class="flex items-center gap-2">
                <img src="https://sia.uici.ac.id/images/uici/logo-uici-baru.png" class="w-10 h-10" alt="Logo SIA" />
                <span class="text-lg font-normal text-gray-900">Sistem Informasi Tugas Akhir & Skripsi</span>
            </a>
            <button onclick="toggleSidebar()" id="sidebar-toggle-button"
                class="lg:hidden p-2 rounded-full text-gray-600 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-green-500 ml-auto">
                <i class="fas fa-arrow-left"></i>
            </button>
        </div>
        <nav class="flex flex-col px-5 py-6 space-y-1 text-sm text-gray-600 overflow-y-auto">
            <span class="uppercase text-xs font-semibold mb-2 text-gray-400">Navigasi</span>
            <a href="{{ route(Auth::user()->role . '.dashboard') }}"
                class="flex items-center gap-3 px-4 py-2 rounded-full {{ request()->routeIs('admin.dashboard') ||
                request()->routeIs('mahasiswa.dashboard') ||
                request()->routeIs('dosen.dashboard')
                    ? 'bg-green-600 text-white font-semibold'
                    : 'hover:bg-gray-100 text-gray-600' }}">
                <i class="fas fa-home"></i>
                <span>Beranda</span>
            </a>
            @if (auth()->user()->role == 'admin')
                <div x-data="{ open: {{ request()->routeIs('admin.management.*') ? 'true' : 'false' }} }" class="space-y-1">
                    <button type="button" @click="open = !open"
                        class="flex items-center w-full gap-3 px-4 py-2 rounded-full transition-all duration-300 {{ request()->routeIs('admin.management.*') ? 'text-white bg-green-600' : 'hover:bg-gray-100 text-gray-600' }}">
                        <i class="fas fa-users"></i>
                        <span>Users</span>
                        <i class="fas fa-chevron-down ml-auto transition-transform duration-300"
                            :class="{ 'rotate-180': open }"></i>
                    </button>
                    <div x-show="open" x-collapse.duration.300ms class="space-y-1">
                        <a href="{{ route('admin.management.admin.index') }}"
                            class="flex items-center gap-3 px-8 py-2 rounded-full transition-all duration-300 {{ request()->routeIs('admin.management.admin.*') ? 'bg-green-500 text-white font-semibold' : 'hover:bg-gray-100 text-gray-600' }}">
                            <i class="fas fa-user-shield"></i>
                            <span>Admin</span>
                        </a>
                        <a href="{{ route('admin.management.mahasiswa.index') }}"
                            class="flex items-center gap-3 px-8 py-2 rounded-full transition-all duration-300 {{ request()->routeIs('admin.management.mahasiswa.*') ? 'bg-green-500 text-white font-semibold' : 'hover:bg-gray-100 text-gray-600' }}">
                            <i class="fas fa-user-graduate"></i>
                            <span>Mahasiswa</span>
                        </a>
                        <a href="{{ route('admin.management.dosen.index') }}"
                            class="flex items-center gap-3 px-8 py-2 rounded-full transition-all duration-300 {{ request()->routeIs('admin.management.dosen.*') ? 'bg-green-500 text-white font-semibold' : 'hover:bg-gray-100 text-gray-600' }}">
                            <i class="fas fa-user-tie"></i>
                            <span>Dosen Pembimbing</span>
                        </a>
                    </div>
                </div>
                <a href="{{ route('admin.jadwal.index') }}"
                    class="flex items-center gap-3 px-4 py-2 rounded-full {{ request()->routeIs('admin.jadwal.*') ? 'bg-green-600 text-white font-semibold' : 'hover:bg-gray-100 text-gray-600' }}">
                    <i class="fas fa-calendar-alt"></i>
                    <span>Jadwal Sidang</span>
                </a>
                <a href="{{ route('admin.proposal.index') }}"
                    class="flex items-center gap-3 px-4 py-2 rounded-full {{ request()->routeIs('admin.proposal.*') ? 'bg-green-600 text-white font-semibold' : 'hover:bg-gray-100 text-gray-600' }}">
                    <i class="fas fa-file-alt"></i>
                    <span>Proposal & Dokumen Akhir</span>
                </a>
                <a href="{{ route('admin.template.index') }}"
                    class="flex items-center gap-3 px-4 py-2 rounded-full {{ request()->routeIs('admin.template.*') ? 'bg-green-600 text-white font-semibold' : 'hover:bg-gray-100 text-gray-600' }}">
                    <i class="fas fa-file-word"></i>
                    <span>Template Skripsi</span>
                </a>
            @elseif (auth()->user()->role == 'dosen')
                <div x-data="{ openBimbingan: {{ request()->routeIs('dosen.bimbingan.*') || request()->routeIs('dosen.jadwalbimbingan.*') ? 'true' : 'false' }} }" class="space-y-1">
                    <button type="button" @click="openBimbingan = !openBimbingan"
                        class="flex items-center w-full gap-3 px-4 py-2 rounded-full transition-all duration-300 {{ request()->routeIs('dosen.bimbingan.*') || request()->routeIs('dosen.jadwalbimbingan.*') ? 'text-white bg-green-600' : 'hover:bg-gray-100 text-gray-600' }}">
                        <i class="fas fa-chalkboard-teacher"></i>
                        <span>Bimbingan</span>
                        <i class="fas fa-chevron-down ml-auto transition-transform duration-300"
                            :class="{ 'rotate-180': openBimbingan }"></i>
                    </button>
                    <div x-show="openBimbingan" x-collapse.duration.300ms class="space-y-1">
                        <a href="{{ route('dosen.bimbingan.index') }}"
                            class="flex items-center gap-3 px-8 py-2 rounded-full transition-all duration-300 {{ request()->routeIs('dosen.bimbingan.index') ? 'bg-green-500 text-white font-semibold' : 'hover:bg-gray-100 text-gray-600' }}">
                            <i class="fas fa-user-graduate"></i>
                            <span>Mahasiswa Bimbingan</span>
                        </a>
                        <a href="{{ route('dosen.jadwalbimbingan.index') }}"
                            class="flex items-center gap-3 px-8 py-2 rounded-full transition-all duration-300 {{ request()->routeIs('dosen.jadwalbimbingan.index') ? 'bg-green-500 text-white font-semibold' : 'hover:bg-gray-100 text-gray-600' }}">
                            <i class="fas fa-calendar-alt"></i>
                            <span>Jadwal Bimbingan</span>
                        </a>
                    </div>
                </div>
                <div x-data="{ openReview: {{ request()->routeIs('dosen.proposals.*') || request()->routeIs('dosen.dokumen-akhir.*') ? 'true' : 'false' }} }" class="space-y-1">
                    <button type="button" @click="openReview = !openReview"
                        class="flex items-center w-full gap-3 px-4 py-2 rounded-full transition-all duration-300 {{ request()->routeIs('dosen.proposals.*') || request()->routeIs('dosen.dokumen-akhir.*') ? 'text-white bg-green-600' : 'hover:bg-gray-100 text-gray-600' }}">
                        <i class="fas fa-file-signature"></i>
                        <span>Review</span>
                        <i class="fas fa-chevron-down ml-auto transition-transform duration-300"
                            :class="{ 'rotate-180': openReview }"></i>
                    </button>
                    <div x-show="openReview" x-collapse.duration.300ms class="space-y-1">
                        <a href="{{ route('dosen.proposals.index') }}"
                            class="flex items-center gap-3 px-8 py-2 rounded-full transition-all duration-300 {{ request()->routeIs('dosen.proposals.index') ? 'bg-green-500 text-white font-semibold' : 'hover:bg-gray-100 text-gray-600' }}">
                            <i class="fas fa-tasks"></i>
                            <span>Proposal/Skripsi</span>
                        </a>
                        <a href="{{ route('dosen.dokumen-akhir.index') }}"
                            class="flex items-center gap-3 px-8 py-2 rounded-full transition-all duration-300 {{ request()->routeIs('dosen.dokumen-akhir.index') ? 'bg-green-500 text-white font-semibold' : 'hover:bg-gray-100 text-gray-600' }}">
                            <i class="fas fa-file-alt"></i>
                            <span>Dokumen Akhir</span>
                        </a>
                    </div>
                </div>
                <div x-data="{ open: {{ request()->routeIs('dosen.nilai-proposal.*') || request()->routeIs('dosen.nilai-dokumen-akhir.*') ? 'true' : 'false' }} }" class="space-y-1">
                    <button type="button" @click="open = !open"
                        class="flex items-center w-full gap-3 px-4 py-2 rounded-full transition-all duration-300 {{ request()->routeIs('dosen.nilai-proposal.*') || request()->routeIs('dosen.nilai-dokumen-akhir.*') ? 'text-white bg-green-600' : 'hover:bg-gray-100 text-gray-600' }}">
                        <i class="fas fa-book"></i>
                        <span>Nilai Mahasiswa</span>
                        <i class="fas fa-chevron-down ml-auto transition-transform duration-300"
                            :class="{ 'rotate-180': open }"></i>
                    </button>
                    <div x-show="open" x-collapse.duration.300ms class="space-y-1">
                        <a href="{{ route('dosen.nilai-proposal.index') }}"
                            class="flex items-center gap-3 px-8 py-2 rounded-full transition-all duration-300 {{ request()->routeIs('dosen.nilai-proposal.index') ? 'bg-green-500 text-white font-semibold' : 'hover:bg-gray-100 text-gray-600' }}">
                            <i class="fas fa-clipboard"></i>
                            <span>Proposal</span>
                        </a>
                        <a href="{{ route('dosen.nilai-dokumen-akhir.index') }}"
                            class="flex items-center gap-3 px-8 py-2 rounded-full transition-all duration-300 {{ request()->routeIs('dosen.nilai-dokumen-akhir.index') ? 'bg-green-500 text-white font-semibold' : 'hover:bg-gray-100 text-gray-600' }}">
                            <i class="fas fa-graduation-cap"></i>
                            <span>Dokumen Akhir</span>
                        </a>
                    </div>
                </div>
                <a href="{{ route('dosen.laporan-progress.index') }}"
                    class="flex items-center gap-3 px-4 py-2 rounded-full {{ request()->routeIs('dosen.laporan-progress.*') ? 'bg-green-600 text-white font-semibold' : 'hover:bg-gray-100 text-gray-600' }}">
                    <i class="fas fa-chart-line"></i>
                    <span>Laporan Progres</span>
                </a>
            @elseif (auth()->user()->role == 'mahasiswa')
                <a href="{{ route('mahasiswa.jadwal-seminar') }}"
                    class="flex items-center gap-3 px-4 py-2 rounded-full {{ request()->routeIs('mahasiswa.jadwal-seminar') ? 'bg-green-600 text-white font-semibold' : 'hover:bg-gray-100 text-gray-600' }}">
                    <i class="fas fa-calendar-check"></i>
                    <span>Jadwal Seminar & Sidang</span>
                </a>
                <a href="{{ route('mahasiswa.proposals.index') }}"
                    class="flex items-center gap-3 px-4 py-2 rounded-full {{ request()->routeIs('mahasiswa.proposals.*') ? 'bg-green-600 text-white font-semibold' : 'hover:bg-gray-100 text-gray-600' }}">
                    <i class="fas fa-file-alt"></i>
                    <span>Proposal & Skripsi</span>
                </a>
                <a href="{{ route('mahasiswa.dokumen-akhir.index') }}"
                    class="flex items-center gap-3 px-4 py-2 rounded-full {{ request()->routeIs('mahasiswa.dokumen-akhir.*') ? 'bg-green-600 text-white font-semibold' : 'hover:bg-gray-100 text-gray-600' }}">
                    <i class="fas fa-file-upload"></i>
                    <span>Upload Dokumen Akhir</span>
                </a>
                <a href="{{ route('mahasiswa.nilai.index') }}"
                    class="flex items-center gap-3 px-4 py-2 rounded-full {{ request()->routeIs('mahasiswa.nilai.*') ? 'bg-green-600 text-white font-semibold' : 'hover:bg-gray-100 text-gray-600' }}">
                    <i class="fas fa-book"></i>
                    <span>Arsip & Nilai</span>
                </a>
                <a href="{{ route('mahasiswa.template.index') }}"
                    class="flex items-center gap-3 px-4 py-2 rounded-full {{ request()->routeIs('mahasiswa.template.*') ? 'bg-green-600 text-white font-semibold' : 'hover:bg-gray-100 text-gray-600' }}">
                    <i class="fas fa-file-word"></i>
                    <span>Download Template</span>
                </a>
            @endif
            <div class="border-t border-gray-200 my-2"></div>
            <a href="{{ route('bantuan') }}"
                class="flex items-center gap-3 px-4 py-2 rounded-full {{ request()->routeIs('bantuan') ? 'bg-green-600 text-white font-semibold' : 'hover:bg-gray-100 text-gray-600' }}">
                <i class="fas fa-question-circle"></i>
                <span>Bantuan</span>
            </a>
            <a href="{{ route('tentang') }}"
                class="flex items-center gap-3 px-4 py-2 rounded-full {{ request()->routeIs('tentang') ? 'bg-green-600 text-white font-semibold' : 'hover:bg-gray-100 text-gray-600' }}">
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

<!-- notification-sidebar -->
<aside id="notification-sidebar"
    class="fixed inset-y-0 right-0 transform translate-x-full bg-white border-l border-gray-200 w-80 transition-transform duration-300 z-40">
    <div class="flex flex-col h-full">
        <div class="flex items-center justify-between gap-2 px-5 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900">Notifikasi</h2>
            <button onclick="toggleNotificationSidebar()"
                class="p-2 rounded-full text-gray-600 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-green-500">
                <i class="fas fa-arrow-right"></i>
            </button>
        </div>
        <div class="p-4 overflow-y-auto">
            <div class="space-y-4 text-sm text-gray-600">
                @php
                    $notifications = getCachedNotifications();
                @endphp

                @if (count($notifications) > 0)
                    @foreach ($notifications as $notif)
                        @php
                            $colorClasses = match ($notif['type']) {
                                'warning' => 'bg-yellow-50 text-yellow-800',
                                'info' => 'bg-blue-50 text-blue-800',
                                'success' => 'bg-green-50 text-green-800',
                                default => 'bg-gray-50 text-gray-800',
                            };

                            $readClass = $notif['is_read'] ? '' : 'border-l-4 border-blue-500';
                        @endphp

                        <a href="{{ is_numeric($notif['id']) ? route('notifications.markAsRead', $notif['id']) : $notif['link'] }}"
                            class="block p-3 rounded-lg shadow-sm {{ $colorClasses }} {{ $readClass }}">
                            <p class="font-bold">{{ $notif['title'] }}</p>
                            <p class="font-semibold text-sm">{{ $notif['message'] }}</p>
                            <p class="text-xs text-gray-500 mt-1">Klik untuk detail</p>
                        </a>
                    @endforeach
                @else
                    <p class="text-center text-gray-500">Tidak ada notifikasi</p>
                @endif
            </div>
        </div>
    </div>
</aside>
