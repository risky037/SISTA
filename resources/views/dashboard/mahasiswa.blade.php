@extends('layouts.app')

@section('title', 'Dashboard Mahasiswa')

@section('content')
    <div
        class="bg-gradient-to-r from-green-600 to-teal-500 rounded-2xl p-6 mb-8 text-white shadow-lg relative overflow-hidden">
        <div class="relative z-10">
            <h1 class="text-2xl font-bold mb-2 inline-flex items-center">Selamat Datang, {{ Auth::user()->name }}! <img
                    src="https://raw.githubusercontent.com/Ridhsuki/Ridhsuki/refs/heads/main/img/Hi.gif" alt="hi"
                    class="ml-2 w-8 h-8" loading="lazy"></h1>
            <p class="text-green-50 text-sm opacity-90 max-w-2xl">
                Pantau terus progres tugas akhirmu. Jangan lupa cek jadwal bimbingan dan pengumuman terbaru dari program
                studi.
            </p>
        </div>
        <div class="absolute top-0 right-0 -mr-12 -mt-12 w-48 h-48 bg-white opacity-10 rounded-full blur-2xl"></div>
        <div class="absolute bottom-0 right-20 w-24 h-24 bg-green-400 opacity-20 rounded-full blur-xl"></div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        <div class="lg:col-span-2 space-y-6">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 flex items-center justify-between">
                    <div>
                        <p class="text-xs text-gray-500 uppercase font-semibold tracking-wider">Status Proposal</p>
                        <h3
                            class="text-lg font-bold mt-1 {{ $proposalStatus == 'approved' ? 'text-green-600' : ($proposalStatus == 'rejected' ? 'text-red-500' : 'text-yellow-500') }}">
                            {{ ucfirst($proposalStatus ?? 'Belum Mengajukan') }}
                        </h3>
                        @if ($nilaiProposal)
                            <p class="text-xs text-gray-400 mt-1">Nilai: <span
                                    class="font-semibold text-gray-700">{{ $nilaiProposal->grade ?? '-' }}</span></p>
                        @endif
                    </div>
                    <div
                        class="p-3 rounded-full {{ $proposalStatus == 'approved' ? 'bg-green-100 text-green-600' : 'bg-gray-100 text-gray-400' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                </div>

                <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 flex items-center justify-between">
                    <div>
                        <p class="text-xs text-gray-500 uppercase font-semibold tracking-wider">Status Sidang Akhir</p>
                        <h3
                            class="text-lg font-bold mt-1 {{ $dokumenStatus == 'approved' ? 'text-green-600' : ($dokumenStatus == 'rejected' ? 'text-red-500' : 'text-yellow-500') }}">
                            {{ ucfirst($dokumenStatus ?? 'Belum Mengajukan') }}
                        </h3>
                        @if ($nilaiDokumen)
                            <p class="text-xs text-gray-400 mt-1">Nilai: <span
                                    class="font-semibold text-gray-700">{{ $nilaiDokumen->grade ?? '-' }}</span></p>
                        @endif
                    </div>
                    <div
                        class="p-3 rounded-full {{ $dokumenStatus == 'approved' ? 'bg-green-100 text-green-600' : 'bg-gray-100 text-gray-400' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-green-600" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    Statistik Bimbingan
                </h3>
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-green-50 p-4 rounded-lg text-center border border-green-100">
                        <span class="block text-3xl font-bold text-green-600 mb-1">{{ $bimbinganDone }}</span>
                        <span class="text-xs font-medium text-green-700 uppercase tracking-wide">Selesai (Approved)</span>
                    </div>
                    <div class="bg-yellow-50 p-4 rounded-lg text-center border border-yellow-100">
                        <span class="block text-3xl font-bold text-yellow-600 mb-1">{{ $bimbinganPending }}</span>
                        <span class="text-xs font-medium text-yellow-700 uppercase tracking-wide">Menunggu</span>
                    </div>
                </div>
            </div>

        </div>

        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 h-full flex flex-col">
                <div class="p-5 border-b border-gray-100 flex justify-between items-center bg-gray-50 rounded-t-xl">
                    <h3 class="font-bold text-gray-800">Pengumuman Terbaru</h3>
                    <a href="{{ route('pengumuman.index') }}"
                        class="text-xs text-green-600 hover:text-green-800 font-semibold hover:underline">Lihat Semua</a>
                </div>

                <div class="p-2 flex-1 overflow-y-auto max-h-[500px]">
                    @forelse($pengumumans as $p)
                        <a href="{{ route('pengumuman.show', $p->id) }}"
                            class="block p-3 hover:bg-gray-50 rounded-lg transition-colors group mb-1">
                            <div class="flex items-start">
                                <div class="flex-shrink-0 mt-1">
                                    <div
                                        class="w-2 h-2 rounded-full bg-blue-500 group-hover:bg-green-500 transition-colors">
                                    </div>
                                </div>
                                <div class="ml-3">
                                    <p class="text-xs text-gray-400 mb-1">
                                        {{ \Carbon\Carbon::parse($p->tanggal)->format('d M Y') }}
                                    </p>
                                    <h4
                                        class="text-sm font-semibold text-gray-700 group-hover:text-green-700 line-clamp-2 transition-colors">
                                        {{ $p->nomor_surat }}
                                    </h4>
                                    <p class="text-xs text-gray-500 mt-1 line-clamp-2">
                                        {{ Str::limit($p->informasi, 70) }}
                                    </p>
                                </div>
                            </div>
                        </a>
                        @if (!$loop->last)
                            <hr class="border-gray-100 mx-3 my-1">
                        @endif
                    @empty
                        <div class="text-center py-8 px-4">
                            <p class="text-gray-400 text-sm">Tidak ada pengumuman terbaru.</p>
                        </div>
                    @endforelse
                </div>

                <div class="p-4 border-t border-gray-100 bg-gray-50 rounded-b-xl text-center">
                    <a href="{{ route('pengumuman.index') }}"
                        class="text-xs font-medium text-gray-500 hover:text-green-600 transition-colors flex justify-center items-center">
                        Arsip Pengumuman
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 ml-1" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
