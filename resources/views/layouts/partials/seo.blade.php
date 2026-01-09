    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="robots" content="index, follow">
    <meta name="revisit-after" content="7 days">
    <meta name="language" content="Indonesian">
    <meta name="author" content="Universitas Insan Cita Indonesia (UICI)">
    <meta name="keywords" content="sista uici, sistem informasi skripsi, tugas akhir uici, pengajuan proposal skripsi, bimbingan online, sidang skripsi, manajemen tugas akhir, universitas insan cita indonesia, digital university, akademik uici">
    <meta name="description" content="{{ $description ?? 'SISTA (Sistem Informasi Skripsi & Tugas Akhir) adalah platform digital resmi UICI untuk mempermudah proses pengajuan proposal, bimbingan dosen, hingga penilaian sidang secara terintegrasi, transparan, dan efisien.' }}">
    <meta name="theme-color" content="#16a34a">
    <meta name="msapplication-navbutton-color" content="#16a34a">
    <meta name="apple-mobile-web-app-status-bar-style" content="#16a34a">
    <meta property="og:type" content="website">
    <meta property="og:locale" content="id_ID">
    <meta property="og:site_name" content="SISTA - Universitas Insan Cita Indonesia">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="{{ $title ?? 'SISTA' }} - Sistem Informasi Skripsi & Tugas Akhir UICI">
    <meta property="og:description" content="{{ $description ?? 'Kelola tugas akhir dan skripsi Anda dengan mudah melalui platform digital SISTA UICI. Terintegrasi, Cepat, dan Paperless.' }}">
    <meta property="og:image" content="{{ asset('img/logo-uici.jpg') }}">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:image:alt" content="Logo SISTA UICI">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $title ?? 'SISTA' }} - Sistem Informasi Skripsi & Tugas Akhir UICI">
    <meta name="twitter:description" content="{{ $description ?? 'Platform digital manajemen skripsi dan tugas akhir mahasiswa Universitas Insan Cita Indonesia.' }}">
    <meta name="twitter:image" content="{{ asset('img/logo-uici.jpg') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon/favicon-16x16.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon/favicon-32x32.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('favicon/apple-touch-icon.png') }}">
    <link rel="manifest" href="{{ asset('favicon/site.webmanifest') }}">
