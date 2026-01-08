<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', 'Sista') - SIA UICI</title>
    <link rel="apple-touch-icon" href="https://sia.uici.ac.id/images/uici/logo-uici-baru.png">
    <link rel="shortcut icon" type="image/x-icon" href="https://sia.uici.ac.id/images/uici/logo-uici-baru.png">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    @stack('styles')
</head>

<body class="bg-gray-100 font-sans text-gray-900">
    <x-preloader></x-preloader>
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
    <x-logout-modal></x-logout-modal>
    @include('layouts.partials.warning-modal')
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('js/script.js') }}"></script>
    @stack('scripts')
</body>

</html>
