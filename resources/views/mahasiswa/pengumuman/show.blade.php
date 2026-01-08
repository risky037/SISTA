@extends('layouts.app')

@section('title', 'Detail Pengumuman')

@section('content')
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">@yield('title')</h1>
            <p class="text-gray-500 text-sm mt-1">Informasi lengkap dan lampiran dokumen pengumuman.</p>
        </div>
        <nav class="text-sm font-medium text-gray-500 bg-gray-100 px-4 py-2 rounded-lg">
            <ol class="list-reset flex items-center gap-2">
                <li><a href="{{ route('dashboard') }}" class="hover:text-green-600">Home</a></li>
                <li><span class="mx-2">/</span></li>
                <li><a href="{{ route('pengumuman.index') }}" class="hover:text-green-600">Pengumuman</a></li>
                <li><span class="mx-2">/</span></li>
                <li class="text-green-600">Detail</li>
            </ol>
        </nav>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden min-h-[400px]">

                <div class="p-6 border-b border-gray-100 bg-blue-50/50 flex items-start gap-4">
                    <div
                        class="flex-shrink-0 w-12 h-12 rounded-xl bg-blue-100 flex items-center justify-center text-blue-600 shadow-sm">
                        <i class="fas fa-bullhorn text-xl"></i>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-800 leading-snug">Pengumuman Akademik</h2>
                        <div class="flex items-center mt-1.5 gap-2">
                            <span class="text-xs font-semibold text-gray-500 uppercase tracking-wide">No. Surat:</span>
                            <span
                                class="font-mono text-sm font-bold text-gray-700 bg-white border border-gray-200 px-2 py-0.5 rounded shadow-sm">
                                {{ $pengumuman->nomor_surat }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="p-6 md:p-8">
                    <div class="prose max-w-none text-gray-700 leading-relaxed text-sm md:text-base text-justify">
                        {!! nl2br(e($pengumuman->informasi)) !!}
                    </div>
                </div>
            </div>
        </div>

        <div class="lg:col-span-1 space-y-6">

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-5 pb-2 border-b border-gray-50">
                    Detail Informasi
                </h3>

                <div class="space-y-5">
                    <div class="flex items-center gap-3">
                        <div class="p-2.5 bg-green-50 text-green-600 rounded-lg">
                            <i class="far fa-calendar-alt text-lg"></i>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Tanggal Terbit</p>
                            <p class="font-semibold text-gray-800">
                                {{ \Carbon\Carbon::parse($pengumuman->tanggal)->translatedFormat('d F Y') }}
                            </p>
                        </div>
                    </div>

                    <div class="flex items-center gap-3">
                        <div class="p-2.5 bg-purple-50 text-purple-600 rounded-lg">
                            <i class="far fa-clock text-lg"></i>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Diposting</p>
                            <p class="font-semibold text-gray-800">{{ $pengumuman->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4">
                    Lampiran Dokumen
                </h3>

                @if ($pengumuman->file_path)
                    <div
                        class="p-4 border border-gray-200 rounded-xl bg-gray-50 hover:bg-white hover:border-blue-400 hover:shadow-md transition group">
                        <div class="flex items-center gap-3 mb-4">
                            <div
                                class="p-2.5 bg-white rounded-lg border border-gray-200 shadow-sm text-red-500 group-hover:scale-110 transition-transform">
                                <i class="fas fa-file-pdf text-2xl"></i>
                            </div>
                            <div class="overflow-hidden">
                                <p class="text-sm font-bold text-gray-800 truncate"
                                    title="{{ basename($pengumuman->file_path) }}">
                                    {{ basename($pengumuman->file_path) }}
                                </p>
                                <p class="text-xs text-gray-500">Klik tombol di bawah</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-2">
                            <a href="{{ asset('storage/' . $pengumuman->file_path) }}" target="_blank"
                                class="flex items-center justify-center px-3 py-2 bg-white border border-gray-300 rounded-lg text-xs font-bold text-gray-700 hover:text-blue-600 hover:border-blue-300 transition shadow-sm">
                                <i class="fas fa-eye mr-2"></i> Lihat
                            </a>
                            <a href="{{ asset('storage/' . $pengumuman->file_path) }}" download
                                class="flex items-center justify-center px-3 py-2 bg-blue-600 border border-transparent rounded-lg text-xs font-bold text-white hover:bg-blue-700 transition shadow-sm">
                                <i class="fas fa-download mr-2"></i> Unduh
                            </a>
                        </div>
                    </div>
                @else
                    <div class="text-center py-8 bg-gray-50 rounded-xl border border-dashed border-gray-300">
                        <i class="fas fa-paperclip text-gray-300 text-xl mb-2"></i>
                        <p class="text-gray-400 text-sm italic">Tidak ada lampiran file.</p>
                    </div>
                @endif
            </div>

            <a href="{{ url()->previous() }}"
                class="block w-full text-center px-4 py-3 bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 hover:text-gray-900 rounded-xl shadow-sm transition font-medium">
                <i class="fas fa-arrow-left mr-2"></i> Kembali
            </a>
        </div>
    </div>
@endsection
