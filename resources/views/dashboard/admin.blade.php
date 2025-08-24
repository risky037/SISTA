@extends('layout.app')

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
                <li><a href="{{ route('admin.dashboard') }}" class="hover:text-green-600">Home</a></li>
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

    {{-- Quick Actions --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-green-50 p-4 rounded-lg shadow hover:shadow-md transition">
            <h3 class="text-green-700 font-semibold mb-2">Data Mahasiswa</h3>
            <p class="text-gray-600 text-sm mb-3">Kelola informasi mahasiswa yang sedang mengerjakan Tugas Akhir & Skripsi.
            </p>
            <a href="{{ route('admin.management.mahasiswa.index') }}" class="text-green-600 text-sm font-semibold hover:underline">Lihat Data →</a>
        </div>

        <div class="bg-blue-50 p-4 rounded-lg shadow hover:shadow-md transition">
            <h3 class="text-blue-700 font-semibold mb-2">Bimbingan</h3>
            <p class="text-gray-600 text-sm mb-3">Catat dan pantau progres bimbingan setiap mahasiswa.</p>
            <a href="" class="text-blue-600 text-sm font-semibold hover:underline">Kelola Bimbingan →</a>
        </div>

        <div class="bg-yellow-50 p-4 rounded-lg shadow hover:shadow-md transition">
            <h3 class="text-yellow-700 font-semibold mb-2">Jadwal Seminar</h3>
            <p class="text-gray-600 text-sm mb-3">Atur jadwal seminar proposal dan sidang akhir.</p>
            <a href="" class="text-yellow-600 text-sm font-semibold hover:underline">Atur Jadwal →</a>
        </div>
    </div>

    {{-- Statistik --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6">
        <div class="bg-white rounded-lg shadow p-4 text-center">
            <h4 class="text-gray-600 text-sm mb-1">Total Mahasiswa</h4>
            <p class="text-2xl font-bold text-green-600"></p>
        </div>
        <div class="bg-white rounded-lg shadow p-4 text-center">
            <h4 class="text-gray-600 text-sm mb-1">Bimbingan Aktif</h4>
            <p class="text-2xl font-bold text-blue-600"></p>
        </div>
        <div class="bg-white rounded-lg shadow p-4 text-center">
            <h4 class="text-gray-600 text-sm mb-1">Jadwal Terdekat</h4>
            <p class="text-2xl font-bold text-yellow-600"></p>
        </div>
    </div>
@endsection
