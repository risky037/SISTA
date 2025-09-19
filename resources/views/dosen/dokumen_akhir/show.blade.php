@extends('layouts.app')

@section('title', 'Detail Dokumen Akhir')

@section('content')
    <div class="flex justify-between items-center mb-4">
        <div>
            <h1 class="text-gray-800 text-xl font-semibold">@yield('title')</h1>
            <p class="text-gray-500 text-sm">Detail dokumen akhir mahasiswa.</p>
        </div>
        <nav class="text-sm text-gray-500">
            <ol class="list-reset flex">
                <li><a href="{{ route('dosen.dashboard') }}" class="hover:text-green-600">Home</a></li>
                <li><span class="mx-2">/</span></li>
                <li><a href="{{ route('dosen.dokumen-akhir.index') }}" class="hover:text-green-600">Dokumen Akhir</a></li>
                <li><span class="mx-2">/</span></li>
                <li class="text-gray-700">Detail</li>
            </ol>
        </nav>
    </div>

    <div class="p-6 bg-white rounded-lg shadow-md">
        <div class="mb-4">
            <h3 class="text-gray-800 text-lg font-semibold">Mahasiswa</h3>
            <p class="text-gray-700">{{ $dok->mahasiswa->name }}</p>
        </div>
        <div class="mb-4">
            <h3 class="text-gray-800 text-lg font-semibold">Judul</h3>
            <p class="text-gray-700">{{ $dok->judul }}</p>
        </div>
        <div class="mb-4">
            <h3 class="text-gray-800 text-lg font-semibold">File</h3>
            <a href="{{ asset('storage/' . $dok->file) }}" target="_blank" class="text-blue-600 hover:underline">
                Download / Lihat Dokumen
            </a>
        </div>
        <div class="mb-4">
            <h3 class="text-gray-800 text-lg font-semibold">Status</h3>
            @php
                $statusClass = match ($dok->status) {
                    'pending' => 'bg-yellow-100 text-yellow-800',
                    'approved' => 'bg-green-100 text-green-800',
                    'rejected' => 'bg-red-100 text-red-800',
                    default => 'bg-gray-100 text-gray-800',
                };
            @endphp
            <span class="px-2 inline-flex text-sm leading-5 font-semibold rounded-full {{ $statusClass }}">
                {{ ucfirst($dok->status) }}
            </span>
        </div>
        <div class="mb-4">
            <h3 class="text-gray-800 text-lg font-semibold">Deskripsi</h3>
            <p class="text-gray-500">{{ $dok->deskripsi ?? '-' }}</p>
        </div>
        <div class="mb-4">
            <h3 class="text-gray-800 text-lg font-semibold">Catatan dari dosen</h3>
            <p class="text-gray-500">{{ $dok->catatan_dosen ?? 'belum ada catatan dari anda' }}</p>
        </div>
        <div class="flex justify-start mt-4">
            <a href="{{ route('dosen.dokumen-akhir.index') }}"
                class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700">
                Kembali ke Dokumen Akhir
            </a>
        </div>
    </div>
@endsection
