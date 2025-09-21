<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', 'Sista') - SIA UICI</title>
    <link rel="apple-touch-icon" href="https://sia.uici.ac.id/images/uici/logo-uici-baru.png">
    <link rel="shortcut icon" type="image/x-icon" href="https://sia.uici.ac.id/images/uici/logo-uici-baru.png">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        ::-webkit-scrollbar-thumb {
            background-color: #4a5568;
            border-radius: 10px;
        }

        .fade-in {
            animation: fadeIn 0.3s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: scale(0.95);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        @keyframes fadeOut {
            from {
                opacity: 1;
            }

            to {
                opacity: 0;
            }
        }

        .preloader-fade-out {
            animation: fadeOut 0.5s ease-out forwards;
        }
    </style>
    @stack('styles')
</head>

<body class="bg-gray-100 font-sans text-gray-900">
    <div id="preloader" class="fixed inset-0 z-50 flex items-center justify-center bg-gray-100/75 backdrop-blur-sm">
        <img src="{{ asset('img/loader.gif') }}" alt="Loading..." class="h-24 w-24">
    </div>
    <div class="flex min-h-screen">
        @include('layouts.partials.sidebar')

        <main id="main-content" class="flex-1 flex flex-col transition-all duration-300 lg:ml-64">
            @include('layouts.partials.topbar')
            <section class="flex-1 overflow-auto p-6">
                <div class="max-w-7xl mx-auto space-y-6">
                    @yield('content')
                </div>
            </section>
        </main>
    </div>

    <div id="logoutModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-sm">
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
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function openLogoutModal() {
            const modal = document.getElementById("logoutModal");
            modal.classList.remove("hidden");
            modal.classList.add("flex");
            setTimeout(() => {
                modal.querySelector('.bg-white').classList.add('fade-in');
            }, 10);
        }

        function closeModal() {
            const modal = document.getElementById("logoutModal");
            modal.classList.add("hidden");
            modal.classList.remove("flex");
            modal.querySelector('.bg-white').classList.remove('fade-in');
        }

        // Toggling Sidebar
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('main-content');
            const toggleButtonIcon = document.getElementById('sidebar-toggle-icon');

            // Toggle the classes to show/hide the sidebar
            sidebar.classList.toggle('-translate-x-full');
            mainContent.classList.toggle('lg:ml-64');
            mainContent.classList.toggle('lg:ml-0');

            // Check if the sidebar is currently collapsed and save the state
            const isCollapsed = sidebar.classList.contains('-translate-x-full');
            localStorage.setItem('sidebarCollapsed', isCollapsed);
        }

        // Toggling Notif Sidebar
        function toggleNotificationSidebar() {
            const notifSidebar = document.getElementById('notification-sidebar');
            notifSidebar.classList.toggle('translate-x-full');
        }
        document.addEventListener('click', (event) => {
            const notifSidebar = document.getElementById('notification-sidebar');
            const notifButton = document.getElementById(
                'notif-button');

            const isNotifSidebarOpen = !notifSidebar.classList.contains('translate-x-full');

            if (isNotifSidebarOpen && !notifSidebar.contains(event.target) && !notifButton.contains(event.target)) {
                notifSidebar.classList.add('translate-x-full');
            }
        });

        // Toggling User Dropdown
        document.addEventListener('DOMContentLoaded', () => {
            const profileMenuButton = document.getElementById('profile-menu-button');
            const profileMenu = document.getElementById('profile-menu');

            profileMenuButton.addEventListener('click', () => {
                profileMenu.classList.toggle('hidden');
            });

            // Close the dropdown when clicking outside
            document.addEventListener('click', (event) => {
                if (!profileMenuButton.contains(event.target) && !profileMenu.contains(event.target)) {
                    profileMenu.classList.add('hidden');
                }
            });

            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('main-content');

            // Get the saved state from localStorage
            const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';

            // Apply the saved state
            if (isCollapsed) {
                sidebar.classList.add('-translate-x-full');
                mainContent.classList.remove('lg:ml-64');
                mainContent.classList.add('lg:ml-0');
            } else {
                // Default behavior: if no state or 'false', ensure it's uncollapsed
                sidebar.classList.remove('-translate-x-full');
                mainContent.classList.add('lg:ml-64');
                mainContent.classList.remove('lg:ml-0');
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
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
    </script>
    @stack('scripts')
</body>

</html>
