@extends('layouts.app')

@section('title', 'Detail Proposal')

@section('content')
    <div class="flex justify-between items-center mb-4">
        <div>
            <h1 class="text-gray-800 text-xl font-semibold">@yield('title')</h1>
            <p class="text-gray-500 text-sm">Halaman untuk melihat detail Dokumen Akhir Anda.</p>
        </div>
        <nav class="text-sm text-gray-500">
            <ol class="list-reset flex">
                <li><a href="{{ route('mahasiswa.dashboard') }}" class="hover:text-green-600">Home</a></li>
                <li><span class="mx-2">/</span></li>
                <li><a href="{{ route('mahasiswa.dokumen-akhir.index') }}" class="hover:text-green-600">Daftar Dokumen Akhir</a></li>
                <li><span class="mx-2">/</span></li>
                <li class="text-gray-700">Detail</li>
            </ol>
        </nav>
    </div>

    <div class="p-6 bg-white rounded-lg shadow-md">
        <div class="space-y-4">
            <div>
                <strong class="block text-sm font-medium text-gray-700">Judul:</strong>
                <p class="mt-1 text-gray-900">{{ $dokumen->judul }}</p>
            </div>

            <div>
                <strong class="block text-sm font-medium text-gray-700">Deskripsi:</strong>
                <p class="mt-1 text-gray-900">{{ $dokumen->deskripsi }}</p>
            </div>

            <div>
                <strong class="block text-sm font-medium text-gray-700">File dokumen:</strong>
                <p class="mt-1 text-gray-900">
                    <a href="{{ asset('storage/dokumen_akhir/' . $dokumen->file_dokumen) }}" target="_blank"
                        class="text-blue-600 hover:underline">
                        Lihat/Download File
                    </a>
                </p>
            </div>

            <div>
                <strong class="block text-sm font-medium text-gray-700">Status:</strong>
                @php
                    $statusClass = match ($dokumen->status) {
                        'pending' => 'bg-yellow-100 text-yellow-800',
                        'approved' => 'bg-green-100 text-green-800',
                        'rejected' => 'bg-red-100 text-red-800',
                        default => 'bg-gray-100 text-gray-800',
                    };
                @endphp
                <p class="mt-1">
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClass }}">
                        {{ ucfirst($dokumen->status) }}
                    </span>
                </p>
            </div>
        </div>

        <div class="mt-6">
            <a href="{{ route('mahasiswa.dokumen-akhir.index') }}"
                class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md shadow-sm text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                Kembali
            </a>
        </div>
    </div>
@endsection
