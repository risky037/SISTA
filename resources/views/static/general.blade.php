@extends('layouts.app')

@section('title', ucfirst($page))

@section('content')

    <div class="flex flex-col sm:flex-row justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">
                {{ $page === 'bantuan' ? 'Pusat Bantuan' : 'Tentang Aplikasi' }}
            </h1>
            <p class="text-sm text-gray-500 mt-1">
                {{ $page === 'bantuan' ? 'Panduan penggunaan sistem.' : 'Informasi sistem SISTA.' }}
            </p>
        </div>
        <nav class="text-sm text-gray-500 mt-2 sm:mt-0">
            <a href="{{ route(auth()->user()->role . '.dashboard') }}" class="hover:text-green-600">Home</a>
            <span class="mx-2">/</span>
            <span class="capitalize text-gray-700 font-medium">{{ $page }}</span>
        </nav>
    </div>

    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 md:p-8">

        @if ($page === 'bantuan')
            <div class="space-y-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <h3 class="font-bold text-gray-800 border-b pb-2 mb-3">Mahasiswa</h3>
                        <ul class="text-sm text-gray-600 space-y-2 list-disc list-inside">
                            <li>Mengajukan Judul Proposal</li>
                            <li>Upload File Skripsi & Revisi</li>
                            <li>Cek Jadwal Seminar</li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-800 border-b pb-2 mb-3">Dosen</h3>
                        <ul class="text-sm text-gray-600 space-y-2 list-disc list-inside">
                            <li>Validasi & Review Proposal</li>
                            <li>Input Nilai Sidang</li>
                            <li>Pantau Progress Bimbingan</li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-800 border-b pb-2 mb-3">Admin</h3>
                        <ul class="text-sm text-gray-600 space-y-2 list-disc list-inside">
                            <li>Kelola User & Data Master</li>
                            <li>Atur Jadwal Sidang</li>
                            <li>Buat Pengumuman</li>
                        </ul>
                    </div>
                </div>


                <div
                    class="bg-gray-50 rounded p-4 border border-gray-200 flex flex-col md:flex-row justify-between items-center gap-4">
                    <div class="text-sm text-gray-600">
                        <span class="font-semibold text-gray-800">Butuh bantuan teknis?</span>
                        Silakan hubungi tim IT atau Admin Fakultas jika mengalami kendala.
                    </div>
                    <a href="mailto:support@uici.ac.id"
                        class="text-sm bg-white border border-gray-300 px-3 py-1.5 rounded hover:bg-gray-100 transition text-gray-700">
                        Hubungi Support
                    </a>
                </div>
            </div>
        @elseif ($page === 'tentang')
            <div class="max-w-3xl mx-auto text-center md:text-left">
                <div class="flex flex-col md:flex-row items-start gap-6">
                    <div class="bg-green-100 p-4 rounded-lg text-green-600 mx-auto md:mx-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>

                    <div class="flex-1">
                        <h2 class="text-xl font-bold text-gray-800">SISTA (Sistem Informasi Skripsi & Tugas Akhir)</h2>
                        <p class="text-gray-600 mt-2 leading-relaxed">
                            Aplikasi ini dirancang untuk mendigitalkan proses administrasi tugas akhir di lingkungan
                            Universitas Insan Cita Indonesia (UICI).
                            Tujuannya adalah mempermudah mahasiswa, dosen, dan admin dalam pengelolaan data akademik secara
                            efisien dan transparan.
                        </p>

                        <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 gap-4 text-left">
                            <div class="flex items-center gap-2 text-sm text-gray-700">
                                <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                Manajemen Proposal Digital
                            </div>
                            <div class="flex items-center gap-2 text-sm text-gray-700">
                                <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                Penjadwalan Sidang Otomatis
                            </div>
                            <div class="flex items-center gap-2 text-sm text-gray-700">
                                <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                Riwayat Bimbingan Terpadu
                            </div>
                            <div class="flex items-center gap-2 text-sm text-gray-700">
                                <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                Arsip Dokumen Akhir
                            </div>
                        </div>

                        <div
                            class="mt-8 pt-6 border-t border-gray-100 flex justify-between items-center text-xs text-gray-400">
                            <span>Versi 1.0.0</span>
                            <span>&copy; {{ date('Y') }} UICI Team</span>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
