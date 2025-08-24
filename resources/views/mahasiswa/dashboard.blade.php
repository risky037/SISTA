@extends('layouts.app')

@section('title', 'Beranda')

@section('content')

    {{-- Flash Message --}}
    @if (session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <div class="flex justify-between items-center mb-4">
        <div>
            <h1 class="text-gray-800 text-xl font-semibold">Beranda</h1>
            <p class="text-gray-500 text-sm">Selamat datang di Sistem Informasi Tugas Akhir & Skripsi</p>
        </div>
        <nav class="text-sm text-gray-500">
            <ol class="list-reset flex">
                <li><a href="" class="hover:text-green-600">Home</a></li>
                <li><span class="mx-2">/</span></li>
                <li class="text-gray-700">Beranda</li>
            </ol>
        </nav>
    </div>

    {{-- Card Utama --}}
    <div class="bg-white p-6 rounded-lg shadow mb-6">
        <h2 class="text-lg font-semibold text-gray-700 mb-2">
            Halo, {{ Auth::user()->name ?? 'User' }} 👋
        </h2>
        <p class="text-gray-600">
            Selamat datang di <strong>Sistem Informasi Tugas Akhir & Skripsi</strong>.
            Gunakan menu di sebelah kiri untuk mengelola data mahasiswa, bimbingan, jadwal seminar, dan laporan akhir.
        </p>
    </div>
@endsection
