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
                <li><a href="" class="hover:text-green-600">Home</a></li>
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
            <h3 class="text-green-700 font-semibold mb-2">Jadwal Bimbingan</h3>
            <p class="text-gray-600 text-sm mb-3">lihat dan atur jadwal bimbingan mahasiswa.
            </p>
            <a href="{{ route('dosen.jadwalbimbingan.index') }}"
                class="text-green-600 text-sm font-semibold hover:underline">Lihat Jadwal →</a>
        </div>

        <div class="bg-blue-50 p-4 rounded-lg shadow hover:shadow-md transition">
            <h3 class="text-blue-700 font-semibold mb-2">Review Proposal</h3>
            <p class="text-gray-600 text-sm mb-3">Review dan berikan catatan proposal/dokumen akhir yang di ajukan.</p>
            <a href="{{ route('dosen.proposals.index') }}"
                class="text-blue-600 text-sm font-semibold hover:underline">Review Proposal →</a>
        </div>

        <div class="bg-yellow-50 p-4 rounded-lg shadow hover:shadow-md transition">
            <h3 class="text-yellow-700 font-semibold mb-2">Nilai Proposal</h3>
            <p class="text-gray-600 text-sm mb-3">Nilai dan berikan catatan proposal/dokumen akhir yang di ajukan.</p>
            <a href="{{ route('dosen.nilai-proposal.index') }}"
                class="text-yellow-600 text-sm font-semibold hover:underline">Nilai Proposal →</a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-white p-4 rounded-lg shadow text-center">
            <h4 class="text-gray-600">Mahasiswa Bimbingan</h4>
            <p class="text-3xl font-bold text-green-600">{{ $mahasiswaBimbingan }}</p>
        </div>
        <div class="bg-white p-4 rounded-lg shadow text-center">
            <h4 class="text-gray-600">Proposal Untuk Review</h4>
            <p class="text-3xl font-bold text-blue-600">{{ $proposalToReview }}</p>
        </div>
        <div class="bg-white p-4 rounded-lg shadow text-center">
            <h4 class="text-gray-600">Dokumen Untuk Diperiksa</h4>
            <p class="text-3xl font-bold text-yellow-600">{{ $dokumenToApprove }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white p-6 rounded-lg shadow">
            <h5 class="font-semibold mb-4">Proposal</h5>
            <ul class="space-y-2">
                <li>Diterima: <strong>{{ $proposalAccepted }}</strong></li>
                <li>Ditolak: <strong>{{ $proposalRejected }}</strong></li>
            </ul>
        </div>
        <div class="bg-white p-6 rounded-lg shadow">
            <h5 class="font-semibold mb-4">Dokumen Akhir</h5>
            <ul class="space-y-2">
                <li>Approved: <strong>{{ $dokumenApproved }}</strong></li>
                <li>Rejected: <strong>{{ $dokumenRejected }}</strong></li>
            </ul>
        </div>
    </div>

    <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-white p-4 rounded-lg shadow text-center">
            <h4 class="text-gray-600">Nilai Proposal</h4>
            <p class="text-3xl font-bold text-red-600">{{ $nilaiProposal }}</p>
        </div>
        <div class="bg-white p-4 rounded-lg shadow text-center">
            <h4 class="text-gray-600">Nilai Dokumen Akhir</h4>
            <p class="text-3xl font-bold text-purple-600">{{ $nilaiDokumenAkhir }}</p>
        </div>
        <div class="bg-white p-4 rounded-lg shadow text-center">
            <h4 class="text-gray-600">Bimbingan Total</h4>
            <p class="text-3xl font-bold text-indigo-600">{{ $bimbinganCount }}</p>
        </div>
    </div>
@endsection
