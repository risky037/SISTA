@extends('layouts.app')

@section('title', ucfirst($page))

@section('content')

    {{-- Breadcrumb --}}
    <div class="flex justify-between items-center mb-4">
        <div>
            <h1 class="text-gray-800 text-xl font-semibold">
                {{ $page === 'bantuan' ? 'Bantuan' : 'Tentang Aplikasi' }}
            </h1>
            <p class="text-gray-500 text-sm">
                {{ $page === 'bantuan' ? 'Informasi bantuan penggunaan sistem.' : 'Informasi tentang sistem ini.' }}
            </p>
        </div>
        <nav class="text-sm text-gray-500">
            <ol class="list-reset flex">
                <li><a href="{{ route(auth()->user()->role . '.dashboard') }}" class="hover:text-green-600">Home</a></li>
                <li><span class="mx-2">/</span></li>
                <li class="text-gray-700 capitalize">{{ $page }}</li>
            </ol>
        </nav>
    </div>

    <div class="bg-white p-6 rounded-lg shadow mb-6">
        <div class="prose max-w-none text-gray-700">
            @if ($page === 'bantuan')
                {{-- Halaman Bantuan --}}
                <h2 class="text-lg font-semibold text-gray-800">Panduan Penggunaan</h2>
                <p>Berikut beberapa panduan penggunaan sistem:</p>
                <ul>
                    <li>Login menggunakan akun SIA masing-masing.</li>
                    <li>Mahasiswa dapat mengunggah proposal dan dokumen akhir.</li>
                    <li>Dosen dapat memberikan catatan, penilaian, dan mengatur jadwal bimbingan.</li>
                    <li>Admin dapat mengelola data pengguna, jadwal sidang, dan template skripsi.</li>
                </ul>
                <p>Jika mengalami kendala, silakan hubungi admin fakultas.</p>
            @elseif ($page === 'tentang')
                {{-- Halaman Tentang --}}
                <h2 class="text-lg font-semibold text-gray-800">Tentang Aplikasi</h2>
                <p>
                    Sistem Informasi Tugas Akhir & Skripsi ini dikembangkan untuk memfasilitasi proses pengajuan,
                    bimbingan, penilaian, dan pengarsipan dokumen akhir mahasiswa di lingkungan UICI.
                </p>
                <p>
                    Fitur utama:
                <ul>
                    <li>Manajemen proposal dan skripsi</li>
                    <li>Bimbingan dosen</li>
                    <li>Jadwal seminar & sidang</li>
                    <li>Upload & review dokumen akhir</li>
                </ul>
                </p>
                <p class="mt-4 text-sm text-gray-500">Versi Aplikasi: <strong>1.0.0</strong></p>
                <p class="text-sm text-gray-500">Dikembangkan oleh: <strong>Tim IT UICI</strong></p>
            @endif
        </div>
    </div>
@endsection
