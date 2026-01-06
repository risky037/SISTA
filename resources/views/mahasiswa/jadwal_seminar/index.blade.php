@extends('layouts.app')

@section('title', 'Jadwal Bimbingan Saya')

@section('content')
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Jadwal Bimbingan</h1>
            <p class="text-gray-500 text-sm mt-1">Pantau status persetujuan dan detail pelaksanaan bimbingan Anda.</p>
        </div>
        <nav class="text-sm font-medium text-gray-500 bg-gray-100 px-4 py-2 rounded-lg">
            <ol class="list-reset flex items-center gap-2">
                <li><a href="{{ route('dashboard') }}" class="hover:text-green-600 transition">Dashboard</a></li>
                <li><i class="fas fa-chevron-right text-xs"></i></li>
                <li class="text-green-600">Jadwal</li>
            </ol>
        </nav>
    </div>

    @if (session('success'))
        <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-sm mb-6 flex justify-between items-center">
            <p>{{ session('success') }}</p>
            <button onclick="this.parentElement.remove()" class="text-green-500 hover:text-green-700">&times;</button>
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
        @forelse ($bimbingans as $bimbingan)
            <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition-all duration-300 border border-gray-100 overflow-hidden flex flex-col h-full group"
                 x-data="{ showModalProsedur: false }">

                @php
                    $statusColor = match ($bimbingan->status) {
                        'pending' => 'bg-yellow-500',
                        'approved' => 'bg-green-500',
                        'rejected' => 'bg-red-500',
                        default => 'bg-gray-500',
                    };
                    $statusText = match ($bimbingan->status) {
                        'pending' => 'Menunggu',
                        'approved' => 'Disetujui',
                        'rejected' => 'Ditolak',
                        default => 'Unknown',
                    };
                    $statusBadge = match ($bimbingan->status) {
                         'pending' => 'bg-yellow-100 text-yellow-800',
                         'approved' => 'bg-green-100 text-green-800',
                         'rejected' => 'bg-red-100 text-red-800',
                         default => 'bg-gray-100 text-gray-800',
                    };
                @endphp
                <div class="h-1.5 w-full {{ $statusColor }}"></div>

                <div class="p-6 flex-1 flex flex-col">
                    <div class="flex justify-between items-start mb-4">
                        <div class="flex items-center gap-3">
                            <div class="h-10 w-10 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center font-bold border border-blue-100">
                                <i class="fas fa-chalkboard-teacher"></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-800 text-md leading-tight">{{ $bimbingan->dosen->name }}</h3>
                                <p class="text-xs text-gray-500 mt-0.5">Dosen Pembimbing</p>
                            </div>
                        </div>
                        <span class="px-2.5 py-1 rounded-full text-xs font-semibold {{ $statusBadge }}">
                            {{ $statusText }}
                        </span>
                    </div>

                    <div class="bg-gray-50 rounded-lg p-3 mb-4 border border-gray-100">
                        <div class="flex items-center text-sm text-gray-700 mb-2">
                            <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            <span class="font-medium">{{ \Carbon\Carbon::parse($bimbingan->tanggal_bimbingan)->translatedFormat('l, d F Y') }}</span>
                        </div>
                        <div class="flex items-center text-sm text-gray-700">
                            <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span>{{ \Carbon\Carbon::parse($bimbingan->waktu_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($bimbingan->waktu_selesai)->format('H:i') }} WIB</span>
                        </div>
                    </div>

                    @if($bimbingan->catatan_dosen)
                        <div class="mb-4 text-sm bg-yellow-50 text-yellow-800 p-3 rounded-md border border-yellow-100">
                            <span class="font-semibold block text-xs uppercase tracking-wide text-yellow-600 mb-1">Catatan Dosen:</span>
                            "{{ $bimbingan->catatan_dosen }}"
                        </div>
                    @endif

                    <div class="mt-auto"></div>
                </div>

                @if($bimbingan->status == 'approved')
                <div class="bg-gray-50 px-6 py-4 border-t border-gray-100 grid {{ $bimbingan->file_prosedur ? 'grid-cols-2' : 'grid-cols-1' }} gap-3">

                    @if($bimbingan->link_meet)
                        <a href="{{ $bimbingan->link_meet }}" target="_blank"
                           class="flex items-center justify-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-lg text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition transform hover:-translate-y-0.5">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                            Join Meet
                        </a>
                    @else
                        <button disabled class="flex items-center justify-center px-4 py-2 border border-gray-200 shadow-sm text-sm font-medium rounded-lg text-gray-400 bg-gray-100 cursor-not-allowed">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                            Link Belum Ada
                        </button>
                    @endif

                    @if($bimbingan->file_prosedur)
                        <button @click="showModalProsedur = true"
                           class="flex items-center justify-center px-4 py-2 border border-purple-200 shadow-sm text-sm font-medium rounded-lg text-purple-700 bg-purple-50 hover:bg-purple-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            Prosedur
                        </button>
                    @endif
                </div>
                @else
                <div class="bg-gray-50 px-6 py-3 border-t border-gray-100">
                    <p class="text-xs text-center text-gray-500 italic">Link & Prosedur tersedia setelah disetujui.</p>
                </div>
                @endif

                @if($bimbingan->file_prosedur)
                    <div x-show="showModalProsedur" style="display: none;"
                        class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                            <div x-show="showModalProsedur" x-transition.opacity class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
                            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                            <div x-show="showModalProsedur" @click.away="showModalProsedur = false" x-transition.scale
                                class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-3xl w-full">
                                <div class="bg-white px-4 pt-5 pb-4 sm:p-6">
                                    <div class="flex justify-between items-center mb-4">
                                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">Prosedur Bimbingan</h3>
                                        <button @click="showModalProsedur = false" class="text-gray-400 hover:text-gray-500 focus:outline-none">
                                            <span class="sr-only">Close</span>
                                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </div>
                                    <div class="bg-gray-100 rounded-lg p-2 flex justify-center overflow-hidden">
                                        <img src="{{ asset('storage/'.$bimbingan->file_prosedur) }}" alt="Prosedur Bimbingan" class="max-h-[70vh] w-auto object-contain rounded">
                                    </div>
                                    <div class="mt-4 text-center">
                                        <a href="{{ asset('storage/'.$bimbingan->file_prosedur) }}" download class="text-sm text-green-600 hover:text-green-800 font-medium underline">
                                            Download Gambar
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

            </div>
        @empty
            <div class="col-span-1 md:col-span-2 xl:col-span-3 text-center py-16 bg-white rounded-xl shadow-sm border border-dashed border-gray-300">
                <div class="mx-auto h-16 w-16 bg-gray-100 rounded-full flex items-center justify-center mb-4 text-gray-400">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900">Belum ada Jadwal</h3>
                <p class="mt-1 text-gray-500 max-w-md mx-auto">Anda belum memiliki jadwal bimbingan yang terdaftar. Silakan ajukan jadwal baru atau tunggu konfirmasi dosen.</p>
                <div class="mt-6">
                    </div>
            </div>
        @endforelse
    </div>
@endsection
