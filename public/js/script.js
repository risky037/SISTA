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
