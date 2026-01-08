@extends('layouts.app')

@section('title', 'Dashboard Dosen')

@section('content')
    <div
        class="bg-gradient-to-r from-green-600 to-teal-500 rounded-2xl p-6 mb-8 text-white shadow-lg relative overflow-hidden">

        <div class="absolute top-0 right-0 -mr-16 -mt-16 w-64 h-64 bg-white opacity-10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 -ml-16 -mb-16 w-48 h-48 bg-blue-400 opacity-20 rounded-full blur-2xl"></div>

        <div class="relative flex flex-col md:flex-row justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold mb-2 inline-flex items-center">
                    Selamat Datang, Bapak/Ibu {{ Auth::user()->name }}!
                    <img src="https://raw.githubusercontent.com/Ridhsuki/Ridhsuki/refs/heads/main/img/Hi.gif" alt="hi"
                        class="ml-2 w-8 h-8" loading="lazy">
                </h1>
                <p class="text-indigo-100 text-sm opacity-90">
                    Berikut adalah ringkasan aktivitas bimbingan dan tugas akhir mahasiswa Anda.
                </p>
            </div>
            <div class="mt-4 md:mt-0 bg-white/10 px-6 py-3 rounded-lg backdrop-blur-sm border border-white/20">
                <span class="block text-xs text-indigo-100 uppercase tracking-wider font-semibold">Total Mahasiswa
                    Bimbingan</span>
                <span class="block text-3xl font-bold text-white text-center">{{ $mahasiswaBimbingan }}</span>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <div
            class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center hover:shadow-md transition-all">
            <div class="p-4 bg-purple-50 text-purple-600 rounded-full mr-5">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z" />
                </svg>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Total Sesi Bimbingan</p>
                <h3 class="text-3xl font-bold text-gray-800">{{ $bimbinganCount }}</h3>
                <p class="text-xs text-gray-400 mt-1">Interaksi via sistem</p>
            </div>
        </div>

        <div
            class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center hover:shadow-md transition-all">
            <div class="p-4 bg-teal-50 text-teal-600 rounded-full mr-5">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                </svg>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Total Penilaian Diberikan</p>
                <h3 class="text-3xl font-bold text-gray-800">{{ $nilaiProposal + $nilaiDokumenAkhir }}</h3>
                <p class="text-xs text-gray-400 mt-1">Proposal & Dokumen Akhir</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

        <div class="space-y-4">
            <h3 class="font-bold text-gray-800 text-lg flex items-center">
                <span class="w-1 h-6 bg-yellow-500 rounded-full mr-2"></span>
                Tahap 1: Proposal Skripsi
            </h3>

            <div
                class="bg-white rounded-xl shadow-sm border-l-4 {{ $proposalToReview > 0 ? 'border-yellow-400' : 'border-green-400' }} p-6 flex justify-between items-center transition-transform hover:-translate-y-1 duration-200">
                <div>
                    <p
                        class="text-xs font-bold uppercase tracking-wider {{ $proposalToReview > 0 ? 'text-yellow-600' : 'text-green-600' }}">
                        {{ $proposalToReview > 0 ? 'Butuh Review' : 'Semua Aman' }}
                    </p>
                    <h4 class="text-2xl font-bold text-gray-800 mt-1">{{ $proposalToReview }} Proposal</h4>
                    <p class="text-sm text-gray-500">Menunggu persetujuan Anda</p>
                </div>
                <div
                    class="h-12 w-12 rounded-full flex items-center justify-center {{ $proposalToReview > 0 ? 'bg-yellow-100 text-yellow-600' : 'bg-green-100 text-green-600' }}">
                    @if ($proposalToReview > 0)
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    @else
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    @endif
                </div>
            </div>

            <div class="grid grid-cols-3 gap-4">
                <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 text-center">
                    <span class="text-2xl font-bold text-green-600 block">{{ $proposalAccepted }}</span>
                    <span class="text-xs text-gray-500 font-medium">Diterima</span>
                </div>
                <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 text-center">
                    <span class="text-2xl font-bold text-red-500 block">{{ $proposalRejected }}</span>
                    <span class="text-xs text-gray-500 font-medium">Ditolak</span>
                </div>
                <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 text-center">
                    <span class="text-2xl font-bold text-blue-600 block">{{ $nilaiProposal }}</span>
                    <span class="text-xs text-gray-500 font-medium">Dinilai</span>
                </div>
            </div>
        </div>

        <div class="space-y-4">
            <h3 class="font-bold text-gray-800 text-lg flex items-center">
                <span class="w-1 h-6 bg-green-500 rounded-full mr-2"></span>
                Tahap 2: Dokumen Akhir (Sidang)
            </h3>

            <div
                class="bg-white rounded-xl shadow-sm border-l-4 {{ $dokumenToApprove > 0 ? 'border-orange-400' : 'border-green-400' }} p-6 flex justify-between items-center transition-transform hover:-translate-y-1 duration-200">
                <div>
                    <p
                        class="text-xs font-bold uppercase tracking-wider {{ $dokumenToApprove > 0 ? 'text-orange-600' : 'text-green-600' }}">
                        {{ $dokumenToApprove > 0 ? 'Verifikasi Dokumen' : 'Semua Aman' }}
                    </p>
                    <h4 class="text-2xl font-bold text-gray-800 mt-1">{{ $dokumenToApprove }} Dokumen</h4>
                    <p class="text-sm text-gray-500">Menunggu approval Anda</p>
                </div>
                <div
                    class="h-12 w-12 rounded-full flex items-center justify-center {{ $dokumenToApprove > 0 ? 'bg-orange-100 text-orange-600' : 'bg-green-100 text-green-600' }}">
                    @if ($dokumenToApprove > 0)
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    @else
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    @endif
                </div>
            </div>

            <div class="grid grid-cols-3 gap-4">
                <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 text-center">
                    <span class="text-2xl font-bold text-green-600 block">{{ $dokumenApproved }}</span>
                    <span class="text-xs text-gray-500 font-medium">Approved</span>
                </div>
                <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 text-center">
                    <span class="text-2xl font-bold text-red-500 block">{{ $dokumenRejected }}</span>
                    <span class="text-xs text-gray-500 font-medium">Rejected</span>
                </div>
                <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 text-center">
                    <span class="text-2xl font-bold text-blue-600 block">{{ $nilaiDokumenAkhir }}</span>
                    <span class="text-xs text-gray-500 font-medium">Dinilai</span>
                </div>
            </div>
        </div>
    </div>
@endsection
