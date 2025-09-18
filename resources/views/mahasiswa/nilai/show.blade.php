@extends('layouts.app')

@section('title', 'Detail Nilai Saya')

@section('content')
    <div class="flex justify-between items-center mb-4">
        <div>
            <h1 class="text-gray-800 text-xl font-semibold">@yield('title')</h1>
            <p class="text-gray-500 text-sm">Halaman untuk melihat detail nilai yang telah Anda peroleh.</p>
        </div>
        <nav class="text-sm text-gray-500">
            <ol class="list-reset flex">
                <li><a href="{{ route('mahasiswa.dashboard') }}" class="hover:text-green-600">Home</a></li>
                <li><span class="mx-2">/</span></li>
                <li><a href="{{ route('mahasiswa.nilai.index') }}" class="hover:text-green-600">Nilai</a></li>
                <li><span class="mx-2">/</span></li>
                <li class="text-gray-700">Detail</li>
            </ol>
        </nav>
    </div>

    <div class="p-6 bg-white rounded-lg shadow-md">
        {{-- Identifikasi Jenis Nilai --}}
        <div class="mb-6">
            <h3 class="text-gray-800 text-lg font-semibold">Jenis Nilai</h3>
            <p class="text-gray-600">
                @if ($nilai->proposal)
                    Nilai Proposal
                @elseif ($nilai->dokumenAkhir)
                    Nilai Dokumen Akhir
                @else
                    Tidak diketahui
                @endif
            </p>
        </div>

        {{-- Judul --}}
        <div class="mb-4">
            <h3 class="text-gray-800 text-lg font-semibold">Judul Tugas Akhir</h3>
            <p class="text-gray-700">
                @if ($nilai->proposal)
                    {{ $nilai->proposal->judul ?? '-' }}
                @elseif ($nilai->dokumenAkhir)
                    {{ $nilai->dokumenAkhir->judul ?? '-' }}
                @else
                    Tidak ada judul
                @endif
            </p>
        </div>

        {{-- Grade --}}
        <div class="mb-4">
            <h3 class="text-gray-800 text-lg font-semibold">Nilai</h3>
            <p class="text-green-700">{{ $nilai->grade }}</p>
        </div>

        {{-- Keterangan --}}
        <div class="mb-4">
            <h3 class="text-gray-800 text-lg font-semibold">Keterangan</h3>
            <p class="text-gray-500">{{ $nilai->keterangan ?? 'Tidak ada keterangan' }}</p>
        </div>

        <div class="flex justify-start mt-4">
            <a href="{{ route('mahasiswa.nilai.index') }}"
                class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700">
                Kembali ke Daftar Nilai
            </a>
        </div>
    </div>
@endsection
