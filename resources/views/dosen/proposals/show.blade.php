@extends('layouts.app')

@section('title', 'Detail Proposal')

@section('content')
    <div class="flex justify-between items-center mb-4">
        <div>
            <h1 class="text-gray-800 text-xl font-semibold">@yield('title')</h1>
            <p class="text-gray-500 text-sm">Informasi lengkap mengenai proposal mahasiswa bimbingan Anda.</p>
        </div>
        <nav class="text-sm text-gray-500">
            <ol class="list-reset flex">
                <li><a href="{{ route('dosen.dashboard') }}" class="hover:text-green-600">Home</a></li>
                <li><span class="mx-2">/</span></li>
                <li><a href="{{ route('dosen.proposals.index') }}" class="hover:text-green-600">Proposal</a></li>
                <li><span class="mx-2">/</span></li>
                <li class="text-gray-700">Detail</li>
            </ol>
        </nav>
    </div>

    <div class="p-6 bg-white rounded-lg shadow-md">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- Nama Mahasiswa --}}
            <div>
                <p class="text-gray-500 text-sm">Mahasiswa</p>
                <p class="text-gray-800 font-medium">{{ $proposal->mahasiswa->name }}</p>
            </div>

            {{-- Judul Proposal --}}
            <div>
                <p class="text-gray-500 text-sm">Judul</p>
                <p class="text-gray-800 font-medium">{{ $proposal->judul }}</p>
            </div>

            {{-- Deskripsi --}}
            <div class="md:col-span-2">
                <p class="text-gray-500 text-sm">Deskripsi</p>
                <p class="text-gray-800 font-medium">{{ $proposal->deskripsi ?? '-' }}</p>
            </div>

            {{-- File Proposal --}}
            <div>
                <p class="text-gray-500 text-sm">File Proposal</p>
                <a href="{{ asset('storage/' . $proposal->file_proposal) }}" target="_blank"
                    class="text-blue-600 hover:text-blue-800 underline text-sm font-medium">
                    Lihat File Proposal
                </a>
            </div>

            {{-- Status Proposal --}}
            <div>
                <p class="text-gray-500 text-sm">Status</p>
                @php
                    $statusClass = match ($proposal->status) {
                        'pending' => 'bg-yellow-100 text-yellow-800',
                        'revisi' => 'bg-orange-100 text-orange-800',
                        'diterima' => 'bg-green-100 text-green-800',
                        'ditolak' => 'bg-red-100 text-red-800',
                        default => 'bg-gray-100 text-gray-800',
                    };
                @endphp
                <span class="inline-block px-3 py-1 text-xs font-semibold rounded-full {{ $statusClass }}">
                    {{ ucfirst($proposal->status) }}
                </span>
            </div>

            {{-- Catatan Dosen --}}
            <div class="md:col-span-2">
                <p class="text-gray-500 text-sm">Catatan Dosen</p>
                <p class="text-gray-800 font-medium">{{ $proposal->catatan_dosen ?? '-' }}</p>
            </div>
        </div>

        {{-- Tombol Kembali --}}
        <div class="mt-6">
            <a href="{{ route('dosen.proposals.index') }}"
                class="inline-block bg-green-600 text-white text-sm font-medium px-4 py-2 rounded-md hover:bg-green-700 transition-colors">
                ← Kembali ke Daftar
            </a>
        </div>
    </div>
@endsection
