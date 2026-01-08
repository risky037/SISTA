function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('main-content');

    const isDesktop = window.innerWidth >= 1024;

    if (isDesktop) {

        if (sidebar.classList.contains('lg:translate-x-0')) {
            sidebar.classList.remove('lg:translate-x-0');
            sidebar.classList.add('-translate-x-full');

            mainContent.classList.remove('lg:ml-64');
            mainContent.classList.add('lg:ml-0');

            localStorage.setItem('sidebarCollapsed', 'true');
        } else {
            sidebar.classList.add('lg:translate-x-0');
            sidebar.classList.remove('-translate-x-full');

            mainContent.classList.add('lg:ml-64');
            mainContent.classList.remove('lg:ml-0');

            localStorage.setItem('sidebarCollapsed', 'false');
        }
    } else {
        sidebar.classList.toggle('-translate-x-full');
    }
}

document.addEventListener('DOMContentLoaded', () => {
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

    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('main-content');

    const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
    const isDesktop = window.innerWidth >= 1024;

    if (isDesktop && isCollapsed && sidebar && mainContent) {
        sidebar.classList.remove('lg:translate-x-0');
        sidebar.classList.add('-translate-x-full');

        mainContent.classList.remove('lg:ml-64');
        mainContent.classList.add('lg:ml-0');
    }
});

function openLogoutModal() {
    const modal = document.getElementById('logoutModal');
    const card = document.getElementById('logoutCard');

    modal.classList.remove('pointer-events-none', 'opacity-0');
    modal.classList.add('opacity-100');

    setTimeout(() => {
        card.classList.remove('scale-95', 'opacity-0');
        card.classList.add('scale-100', 'opacity-100');
    }, 10);
}

function closeLogoutModal() {
    const modal = document.getElementById('logoutModal');
    const card = document.getElementById('logoutCard');

    card.classList.remove('scale-100', 'opacity-100');
    card.classList.add('scale-95', 'opacity-0');

    setTimeout(() => {
        modal.classList.add('opacity-0', 'pointer-events-none');
        modal.classList.remove('opacity-100');
    }, 200);
}

document.getElementById('logoutBackdrop').addEventListener('click', closeLogoutModal);

function toggleNotificationSidebar() {
    const notifSidebar = document.getElementById('notification-sidebar');
    if (notifSidebar) {
        notifSidebar.classList.toggle('translate-x-full');
    }
}

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
