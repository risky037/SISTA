@extends('layouts.app')

@section('title', 'Detail Pengumuman')

@section('content')
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
        <div>
            <h1 class="text-gray-800 text-2xl font-bold">@yield('title')</h1>
            <p class="text-gray-500 text-sm mt-1">Halaman untuk melihat detail informasi dan lampiran pengumuman.</p>
        </div>
        <nav class="text-sm text-gray-500">
            <ol class="flex items-center space-x-2">
                <li><a href="{{ route('dashboard') }}" class="hover:text-green-600">Home</a></li>
                <li><span class="text-gray-300">/</span></li>
                <li><a href="#" class="hover:text-green-600 transition-colors">Pengumuman</a></li>
                <li><span class="text-gray-300">/</span></li>
                <li class="text-gray-700 font-medium">Detail</li>
            </ol>
        </nav>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">

        <div class="bg-gray-50/50 px-6 py-5 border-b border-gray-100">
            <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-blue-100 text-blue-600 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-lg font-semibold text-gray-800">Nomor Surat: {{ $pengumuman->nomor_surat }}</h2>
                        <span class="inline-flex items-center text-sm text-gray-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            {{ \Carbon\Carbon::parse($pengumuman->tanggal)->translatedFormat('d F Y') }}
                        </span>
                    </div>
                </div>

                <span
                    class="px-3 py-1 text-xs font-medium text-green-700 bg-green-100 rounded-full border border-green-200">
                    Terbaru
                </span>
            </div>
        </div>

        <div class="p-6 md:p-8">
            <h3 class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-3">Informasi Pengumuman</h3>

            <div class="prose max-w-none text-gray-700 leading-relaxed mb-8">
                {!! nl2br(e($pengumuman->informasi)) !!}
            </div>

            @if ($pengumuman->file_path)
                <div class="border-t border-gray-100 pt-6">
                    <h3 class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-4">Lampiran Dokumen</h3>

                    <div
                        class="flex items-center p-4 mb-4 bg-gray-50 border border-gray-200 rounded-lg hover:bg-gray-100 transition-colors group">
                        <div class="p-3 bg-red-100 text-red-500 rounded-lg mr-4 group-hover:bg-red-200 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 truncate">
                                {{ basename($pengumuman->file_path) }}
                            </p>
                            <p class="text-xs text-gray-500">
                                Klik tombol di kanan untuk melihat atau mengunduh.
                            </p>
                        </div>
                        <div class="flex gap-2">
                            <a href="{{ asset('storage/' . $pengumuman->file_path) }}" target="_blank"
                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-green-700 bg-green-100 hover:bg-green-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 md:mr-1" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <span class="hidden md:inline">Lihat</span>
                            </a>

                            <a href="{{ asset('storage/' . $pengumuman->file_path) }}" download
                                class="inline-flex items-center px-3 py-2 border border-gray-300 text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 md:mr-1" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                </svg>
                                <span class="hidden md:inline">Unduh</span>
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex justify-end">
            <a href="{{ url()->previous() }}"
                class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali
            </a>
        </div>
    </div>
@endsection
