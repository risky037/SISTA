// ==========================================
// LOGIKA SIDEBAR YANG DIPERBAIKI
// ==========================================

function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('main-content');

    // Cek apakah kita di mode Desktop (layar >= 1024px)
    const isDesktop = window.innerWidth >= 1024;

    if (isDesktop) {
        // --- LOGIKA DESKTOP ---
        // Di desktop, defaultnya tampil (lg:translate-x-0).
        // Jika class ini ada, berarti sedang terbuka -> Kita harus menutupnya.

        if (sidebar.classList.contains('lg:translate-x-0')) {
            // Tutup Sidebar Desktop
            sidebar.classList.remove('lg:translate-x-0'); // Hapus pemaksa tampil
            sidebar.classList.add('-translate-x-full');   // Paksa sembunyi

            // Sesuaikan margin konten utama
            mainContent.classList.remove('lg:ml-64');
            mainContent.classList.add('lg:ml-0');

            localStorage.setItem('sidebarCollapsed', 'true');
        } else {
            // Buka Sidebar Desktop
            sidebar.classList.add('lg:translate-x-0');
            sidebar.classList.remove('-translate-x-full');

            mainContent.classList.add('lg:ml-64');
            mainContent.classList.remove('lg:ml-0');

            localStorage.setItem('sidebarCollapsed', 'false');
        }
    } else {
        // --- LOGIKA MOBILE ---
        // Di mobile, defaultnya sembunyi (-translate-x-full).
        // Kita cukup toggle class tersebut.

        sidebar.classList.toggle('-translate-x-full');

        // Di mobile biasanya mainContent tertutup overlay, jadi margin tidak perlu diubah
        // atau biarkan default. Overlay akan menangani fokus user.
    }
}

// ==========================================
// INISIALISASI SAAT LOAD (MEMUAT STATUS TERAKHIR)
// ==========================================

document.addEventListener('DOMContentLoaded', () => {
    // 1. Setup User Dropdown
    const profileMenuButton = document.getElementById('profile-menu-button');
    const profileMenu = document.getElementById('profile-menu');

    if (profileMenuButton && profileMenu) {
        profileMenuButton.addEventListener('click', () => {
            profileMenu.classList.toggle('hidden');
        });

        document.addEventListener('click', (event) => {
            if (!profileMenuButton.contains(event.target) && !profileMenu.contains(event.target)) {
                profileMenu.classList.add('hidden');
            }
        });
    }

    // 2. Setup Sidebar State (Hanya untuk Desktop)
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('main-content');

    // Cek status simpanan user (hanya relevan jika user di desktop)
    const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
    const isDesktop = window.innerWidth >= 1024;

    if (isDesktop && isCollapsed && sidebar && mainContent) {
        // Terapkan status tertutup jika user sebelumnya menutupnya
        sidebar.classList.remove('lg:translate-x-0');
        sidebar.classList.add('-translate-x-full');

        mainContent.classList.remove('lg:ml-64');
        mainContent.classList.add('lg:ml-0');
    }
});

// ==========================================
// SISA KODE LAINNYA (MODAL, NOTIFIKASI, DLL)
// ==========================================

function openLogoutModal() {
    const modal = document.getElementById("logoutModal");
    if (modal) {
        modal.classList.remove("hidden");
        modal.classList.add("flex");
        setTimeout(() => {
            modal.querySelector('.bg-white').classList.add('fade-in');
        }, 10);
    }
}

function closeModal() {
    const modal = document.getElementById("logoutModal");
    if (modal) {
        modal.classList.add("hidden");
        modal.classList.remove("flex");
        modal.querySelector('.bg-white').classList.remove('fade-in');
    }
}

function toggleNotificationSidebar() {
    const notifSidebar = document.getElementById('notification-sidebar');
    if (notifSidebar) {
        notifSidebar.classList.toggle('translate-x-full');
    }
}

// Tutup notifikasi jika klik di luar
document.addEventListener('click', (event) => {
    const notifSidebar = document.getElementById('notification-sidebar');
    const notifButton = document.getElementById('notif-button');

    if (notifSidebar && notifButton) {
        const isNotifSidebarOpen = !notifSidebar.classList.contains('translate-x-full');
        if (isNotifSidebarOpen && !notifSidebar.contains(event.target) && !notifButton.contains(event.target)) {
            notifSidebar.classList.add('translate-x-full');
        }
    }
});

document.addEventListener('DOMContentLoaded', function () {
    const preloader = document.getElementById('preloader');
    if (preloader) {
        setTimeout(() => {
            preloader.classList.add('preloader-fade-out');
            preloader.addEventListener('animationend', () => {
                preloader.style.display = 'none';
            }, {
                once: true
            });
        }, 500);
    }
});
