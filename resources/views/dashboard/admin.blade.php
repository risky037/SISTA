@extends('layouts.app')

@section('title', 'Beranda')

@section('content')

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

    <div class="bg-white p-6 rounded-lg shadow mb-6">
        <h2 class="text-lg font-semibold text-gray-700 mb-2">
            Halo, {{ Auth::user()->name ?? 'User' }} 👋
        </h2>
        <p class="text-gray-600">
            Selamat datang di <strong>Sistem Informasi Tugas Akhir & Skripsi</strong>.
            Gunakan menu di sebelah kiri untuk mengelola data mahasiswa, bimbingan, jadwal seminar, dan laporan akhir.
        </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-green-50 p-4 rounded-lg shadow hover:shadow-md transition">
            <h3 class="text-green-700 font-semibold mb-2">Data Mahasiswa</h3>
            <p class="text-gray-600 text-sm mb-3">Kelola informasi mahasiswa yang sedang mengerjakan Tugas Akhir & Skripsi.
            </p>
            <a href="{{ route('admin.management.mahasiswa.index') }}"
                class="text-green-600 text-sm font-semibold hover:underline">Lihat Data →</a>
        </div>

        <div class="bg-blue-50 p-4 rounded-lg shadow hover:shadow-md transition">
            <h3 class="text-blue-700 font-semibold mb-2">Jadwal Sidang</h3>
            <p class="text-gray-600 text-sm mb-3">Kelola dan pantau jadwal sidang setiap mahasiswa.</p>
            <a href="{{ route('admin.jadwal.index') }}" class="text-blue-600 text-sm font-semibold hover:underline">Kelola
                Bimbingan →</a>
        </div>

        <div class="bg-yellow-50 p-4 rounded-lg shadow hover:shadow-md transition">
            <h3 class="text-yellow-700 font-semibold mb-2">Proposal</h3>
            <p class="text-gray-600 text-sm mb-3">Kelola dan review proposal dan sidang akhir.</p>
            <a href="{{ route('admin.proposal.index') }}" class="text-yellow-600 text-sm font-semibold hover:underline">Atur
                Jadwal →</a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-white p-4 rounded-lg shadow text-center">
            <h4 class="text-gray-600">Total Mahasiswa</h4>
            <p class="text-3xl font-bold text-green-600">{{ $totalMahasiswa }}</p>
        </div>
        <div class="bg-white p-4 rounded-lg shadow text-center">
            <h4 class="text-gray-600">Total Dosen</h4>
            <p class="text-3xl font-bold text-blue-600">{{ $totalDosen }}</p>
        </div>
        <div class="bg-white p-4 rounded-lg shadow text-center">
            <h4 class="text-gray-600">Proposal Masuk</h4>
            <p class="text-3xl font-bold text-yellow-600">{{ $totalProposal }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white p-6 rounded-lg shadow">
            <h5 class="font-semibold mb-4">Status Proposal</h5>
            <ul class="space-y-2">
                <li>Pending: <strong>{{ $proposalPending }}</strong></li>
                <li>Diterima: <strong>{{ $proposalAccepted }}</strong></li>
                <li>Ditolak: <strong>{{ $proposalRejected }}</strong></li>
            </ul>
        </div>
        <div class="bg-white p-6 rounded-lg shadow">
            <h5 class="font-semibold mb-4">Status Dokumen Akhir</h5>
            <ul class="space-y-2">
                <li>Pending: <strong>{{ $dokumenPending }}</strong></li>
                <li>Approved: <strong>{{ $dokumenApproved }}</strong></li>
                <li>Rejected: <strong>{{ $dokumenRejected }}</strong></li>
            </ul>
        </div>
    </div>
@endsection
