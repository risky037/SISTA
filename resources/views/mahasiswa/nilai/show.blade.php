@extends('layouts.app')

@section('title', 'Detail Nilai')

@section('content')
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Detail Penilaian</h1>
            <p class="text-gray-500 text-sm mt-1">Rincian nilai dan catatan evaluasi dari Dosen.</p>
        </div>
        <nav class="text-sm font-medium text-gray-500 bg-gray-100 px-4 py-2 rounded-lg">
            <ol class="list-reset flex items-center gap-2">
                <li><a href="{{ route('mahasiswa.dashboard') }}" class="hover:text-green-600">Home</a></li>
                <li><span class="mx-2">/</span></li>
                <li><a href="{{ route('mahasiswa.nilai.index') }}" class="hover:text-green-600">Nilai</a></li>
                <li><span class="mx-2">/</span></li>
                <li class="text-green-600">Detail</li>
            </ol>
        </nav>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        <div class="md:col-span-1">
            <div
                class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden text-center p-6 h-full flex flex-col items-center justify-center">
                <p class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-4">Hasil Penilaian</p>

                @php
                    $gradeColor = match (strtoupper($nilai->grade)) {
                        'A', 'A+', 'A-' => 'text-green-600 bg-green-50 ring-green-100',
                        'B', 'B+', 'B-' => 'text-blue-600 bg-blue-50 ring-blue-100',
                        'C', 'C+', 'C-' => 'text-yellow-600 bg-yellow-50 ring-yellow-100',
                        default => 'text-red-600 bg-red-50 ring-red-100',
                    };
                @endphp

                <div
                    class="w-32 h-32 rounded-full flex items-center justify-center text-6xl font-extrabold ring-8 {{ $gradeColor }} mb-6">
                    {{ $nilai->grade }}
                </div>

                <div class="w-full border-t border-gray-100 pt-4 mt-2">
                    <p class="text-xs text-gray-500">Dinilai oleh:</p>
                    <p class="font-bold text-gray-800 text-lg mt-1">{{ $nilai->dosen->name ?? 'Dosen' }}</p>
                    <p class="text-xs text-gray-400 mt-1">{{ $nilai->created_at->translatedFormat('l, d F Y H:i') }}</p>
                </div>
            </div>
        </div>

        <div class="md:col-span-2 space-y-6">

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-4 border-b border-gray-100 bg-gray-50 font-bold text-gray-700">
                    <i class="fas fa-info-circle mr-2"></i> Informasi Dokumen
                </div>
                <div class="p-6">
                    @if ($nilai->proposal_id)
                        <div class="mb-2">
                            <span
                                class="text-xs font-bold text-green-600 bg-green-100 px-2 py-1 rounded uppercase">Proposal</span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $nilai->proposal->judul }}</h3>
                        <p class="text-gray-600 text-sm mb-4">{{ Str::limit($nilai->proposal->deskripsi, 150) }}</p>

                        @if ($nilai->proposal->file_proposal)
                            <a href="{{ asset('storage/proposals/' . $nilai->proposal->file_proposal) }}" target="_blank"
                                class="inline-flex items-center text-sm text-blue-600 hover:underline">
                                <i class="fas fa-external-link-alt mr-1"></i> Lihat File Proposal
                            </a>
                        @endif
                    @elseif($nilai->dokumen_akhir_id)
                        <div class="flex items-center gap-2 mb-3">
                            <span class="text-xs font-bold text-blue-600 bg-blue-100 px-2 py-1 rounded uppercase">Dokumen
                                Akhir</span>
                            <span class="text-xs font-bold text-gray-600 bg-gray-100 px-2 py-1 rounded uppercase">Bab
                                {{ $nilai->dokumenAkhir->bab }}</span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $nilai->dokumenAkhir->judul }}</h3>
                        <p class="text-gray-600 text-sm mb-4">{{ Str::limit($nilai->dokumenAkhir->deskripsi, 150) }}</p>

                        @if ($nilai->dokumenAkhir->file)
                            <a href="{{ asset('storage/' . $nilai->dokumenAkhir->file) }}" target="_blank"
                                class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition mt-2">
                                <i class="fas fa-download mr-2"></i> Download Dokumen
                            </a>
                        @endif
                    @endif
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-4 border-b border-gray-100 bg-yellow-50 font-bold text-yellow-800">
                    <i class="fas fa-comment-dots mr-2"></i> Catatan Evaluasi
                </div>
                <div class="p-6 bg-yellow-50/20">
                    @if ($nilai->keterangan)
                        <div class="prose max-w-none text-gray-700 text-sm">
                            {!! nl2br(e($nilai->keterangan)) !!}
                        </div>
                    @else
                        <p class="text-gray-400 italic text-sm text-center">Tidak ada catatan tambahan dari dosen.</p>
                    @endif
                </div>
            </div>

            <div class="flex justify-end">
                <a href="{{ route('mahasiswa.nilai.index') }}"
                    class="px-6 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-lg shadow transition text-sm font-medium">
                    Kembali
                </a>
            </div>
        </div>
    </div>
@endsection
