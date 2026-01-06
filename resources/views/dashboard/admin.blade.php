@extends('layouts.app')

@section('title', 'Dashboard Administrator')

@section('content')
    <div
        class="bg-gradient-to-r from-green-600 to-teal-500 rounded-2xl p-6 mb-8 text-white shadow-lg relative overflow-hidden">
        <div class="relative z-10">
            <h1 class="text-2xl font-bold mb-2 inline-flex items-center">Selamat Datang, {{ Auth::user()->name }}! <img
                    src="https://raw.githubusercontent.com/Ridhsuki/Ridhsuki/refs/heads/main/img/Hi.gif" alt="hi"
                    class="ml-2 w-8 h-8"></h1>
            <p class="text-blue-100 text-sm opacity-90">
                Panel kontrol utama sistem. Pantau data mahasiswa, dosen, dan validasi pengajuan akademik di sini.
            </p>
        </div>
        <div class="absolute right-0 top-0 h-full w-1/3 bg-white opacity-5 skew-x-12 transform translate-x-12"></div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center">
            <div class="p-3 rounded-full bg-blue-50 text-blue-600 mr-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
            </div>
            <div>
                <p class="text-sm text-gray-500 font-medium">Total Mahasiswa</p>
                <h3 class="text-2xl font-bold text-gray-800">{{ $totalMahasiswa }}</h3>
            </div>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center">
            <div class="p-3 rounded-full bg-purple-50 text-purple-600 mr-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
            </div>
            <div>
                <p class="text-sm text-gray-500 font-medium">Total Dosen</p>
                <h3 class="text-2xl font-bold text-gray-800">{{ $totalDosen }}</h3>
            </div>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center">
            <div class="p-3 rounded-full bg-yellow-50 text-yellow-600 mr-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
            </div>
            <div>
                <p class="text-sm text-gray-500 font-medium">Proposal Pending</p>
                <h3 class="text-2xl font-bold text-gray-800">{{ $proposalPending }}</h3>
            </div>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center">
            <div class="p-3 rounded-full bg-green-50 text-green-600 mr-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                </svg>
            </div>
            <div>
                <p class="text-sm text-gray-500 font-medium">Sidang Pending</p>
                <h3 class="text-2xl font-bold text-gray-800">{{ $sidangPending }}</h3>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50">
                    <h3 class="font-bold text-gray-800">Proposal Terbaru Masuk</h3>
                    <a href="{{ route('admin.proposal.index') }}" class="text-xs text-blue-600 hover:underline">Lihat
                        Semua</a>
                </div>
                <div class="divide-y divide-gray-100">
                    @forelse($recentProposals as $proposal)
                        <div class="p-4 hover:bg-gray-50 transition-colors flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center text-gray-500 font-bold text-sm">
                                    {{ substr($proposal->mahasiswa->name, 0, 1) }}
                                </div>
                                <div>
                                    <h4 class="text-sm font-semibold text-gray-800">{{ $proposal->judul }}</h4>
                                    <p class="text-xs text-gray-500">Oleh: {{ $proposal->mahasiswa->name }}</p>
                                </div>
                            </div>
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-700">
                                {{ $proposal->status }}
                            </span>
                        </div>
                    @empty
                        <div class="p-6 text-center text-gray-500 text-sm">Belum ada proposal baru.</div>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="lg:col-span-1 space-y-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                <h3 class="font-bold text-gray-800 mb-4">Aksi Cepat</h3>
                <div class="grid grid-cols-2 gap-3">
                    <a href="{{ route('admin.management.dosen.create') }}"
                        class="flex flex-col items-center justify-center p-4 bg-gray-50 rounded-lg hover:bg-blue-50 hover:text-blue-600 transition-colors border border-gray-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mb-2" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                        </svg>
                        <span class="text-xs font-medium text-center">Tambah Dosen</span>
                    </a>
                    <a href="{{ route('admin.pengumuman.index') }}"
                        class="flex flex-col items-center justify-center p-4 bg-gray-50 rounded-lg hover:bg-green-50 hover:text-green-600 transition-colors border border-gray-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mb-2" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
                        </svg>
                        <span class="text-xs font-medium text-center">Buat Info</span>
                    </a>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                <h3 class="font-bold text-gray-800 mb-3 text-sm uppercase tracking-wide">Pengumuman Terkirim</h3>
                <ul class="space-y-3">
                    @foreach ($recentPengumuman as $p)
                        <li class="flex items-start">
                            <div class="w-2 h-2 mt-1.5 bg-green-500 rounded-full flex-shrink-0 mr-2"></div>
                            <p class="text-sm text-gray-600 leading-tight">{{ Str::limit($p->informasi, 50) }}</p>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endsection
