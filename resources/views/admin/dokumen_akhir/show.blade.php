@extends('layouts.app')

@section('title', 'Detail Progress Skripsi')

@section('content')
    <div class="flex justify-between items-center mb-4">
        <div>
            <h1 class="text-gray-800 text-xl font-semibold">@yield('title')</h1>
            <p class="text-gray-500 text-sm">Halaman untuk melihat detail Dokumen Akhir Mahasiswa.</p>
        </div>
        <nav class="text-sm text-gray-500">
            <ol class="list-reset flex">
                <li><a href="{{ route('admin.dashboard') }}" class="hover:text-green-600">Home</a></li>
                <li><span class="mx-2">/</span></li>
                <li><a href="{{ route('admin.dokumen-akhir.index') }}" class="hover:text-green-600">Monitoring Dokumen
                        Akhir</a></li>
                <li><span class="mx-2">/</span></li>
                <li class="text-gray-700">@yield('title')</li>
            </ol>
        </nav>
    </div>
    <div class="container mx-auto px-4 py-4">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">{{ $mahasiswa->name }}</h1>
                    <p class="text-gray-500 mt-1">
                        Email: {{ $mahasiswa->email }}
                        @if ($mahasiswa->nim)
                            | NIM: {{ $mahasiswa->nim }}
                        @endif
                    </p>
                </div>
            </div>
        </div>

        <div class="space-y-6">
            @foreach ($chapters as $key => $chapterName)
                @php
                    $dokumen = $uploads[$key] ?? null;
                    $status = $dokumen ? $dokumen->status : 'none';

                    $borderClass = match ($status) {
                        'approved' => 'border-l-4 border-green-500',
                        'rejected' => 'border-l-4 border-red-500',
                        'pending' => 'border-l-4 border-amber-500',
                        default => 'border-l-4 border-gray-200',
                    };
                @endphp

                <div class="bg-white rounded-xl shadow-sm {{ $borderClass }} p-6">
                    <div class="flex flex-col lg:flex-row justify-between gap-6">
                        <div class="flex-1">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-lg font-bold text-gray-800">{{ $chapterName }}</h3>
                                @if ($status == 'approved')
                                    <span
                                        class="px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700">DISETUJUI</span>
                                @elseif($status == 'rejected')
                                    <span
                                        class="px-3 py-1 rounded-full text-xs font-bold bg-red-100 text-red-700">REVISI</span>
                                @elseif($status == 'pending')
                                    <span
                                        class="px-3 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-700">MENUNGGU
                                        REVIEW</span>
                                @else
                                    <span class="px-3 py-1 rounded-full text-xs font-bold bg-gray-100 text-gray-500">BELUM
                                        UPLOAD</span>
                                @endif
                            </div>

                            @if ($dokumen)
                                <div class="bg-gray-50 rounded-lg p-4 border border-gray-100 mb-4">
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <p class="text-xs text-gray-500 uppercase font-semibold">Judul Dokumen</p>
                                            <p class="text-gray-900 font-medium">{{ $dokumen->judul }}</p>
                                        </div>
                                        <div>
                                            <p class="text-xs text-gray-500 uppercase font-semibold">Dosen Pembimbing</p>
                                            <p class="text-gray-900">{{ $dokumen->dosen->name ?? '-' }}</p>
                                        </div>
                                        <div>
                                            <p class="text-xs text-gray-500 uppercase font-semibold">Waktu Upload</p>
                                            <p class="text-gray-900">{{ $dokumen->created_at->format('d M Y, H:i') }}</p>
                                        </div>
                                    </div>
                                    @if ($dokumen->deskripsi)
                                        <div class="mt-3 pt-3 border-t border-gray-200">
                                            <p class="text-xs text-gray-500 uppercase font-semibold mb-1">Catatan Mahasiswa
                                            </p>
                                            <p class="text-gray-700 italic text-sm">"{{ $dokumen->deskripsi }}"</p>
                                        </div>
                                    @endif
                                </div>

                                @if ($dokumen->catatan_dosen)
                                    <div class="bg-blue-50 rounded-lg p-4 border border-blue-100">
                                        <p class="text-xs text-blue-600 uppercase font-semibold mb-1">Catatan Dosen</p>
                                        <p class="text-gray-800 text-sm">{{ $dokumen->catatan_dosen }}</p>
                                    </div>
                                @endif
                            @else
                                <div class="text-center py-6 bg-gray-50 rounded-lg border border-dashed border-gray-300">
                                    <p class="text-gray-400 text-sm">Mahasiswa belum mengunggah dokumen untuk bab ini.</p>
                                </div>
                            @endif
                        </div>

                        @if ($dokumen)
                            <div class="flex items-start">
                                <a href="{{ asset('storage/' . $dokumen->file) }}" target="_blank"
                                    class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg text-white hover:bg-blue-700 font-medium text-sm transition shadow-sm">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                        </path>
                                    </svg>
                                    Lihat File
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
