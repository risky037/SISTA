@extends('layouts.app')

@section('title', 'Detail Proposal')

@section('content')
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">@yield('title')</h1>
            <p class="text-gray-500 text-sm mt-1">Halaman untuk melihat detail proposal skripsi Anda.</p>
        </div>
        <nav class="text-sm font-medium text-gray-500 bg-gray-100 px-4 py-2 rounded-lg">
            <ol class="list-reset flex items-center gap-2">
                <li><a href="{{ route('mahasiswa.dashboard') }}" class="hover:text-green-600">Home</a></li>
                <li><span class="mx-2">/</span></li>
                <li><a href="{{ route('mahasiswa.proposals.index') }}" class="hover:text-green-600">Daftar Proposal</a></li>
                <li><span class="mx-2">/</span></li>
                <li class="text-green-600">Detail</li>
            </ol>
        </nav>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-100 bg-gray-50 flex items-center gap-2">
                    <i class="fas fa-file-alt text-green-600"></i>
                    <h2 class="text-lg font-bold text-gray-800">Informasi Proposal</h2>
                </div>

                <div class="p-6">
                    <div class="mb-6">
                        <label class="text-xs font-bold text-gray-400 uppercase tracking-wider block mb-2">Judul Proposal</label>
                        <h3 class="text-xl md:text-2xl font-bold text-gray-800 leading-snug">{{ $proposal->judul }}</h3>
                    </div>

                    <div class="mb-6">
                        <label class="text-xs font-bold text-gray-400 uppercase tracking-wider block mb-2">Deskripsi / Latar Belakang</label>
                        <div class="prose max-w-none text-gray-600 bg-gray-50 p-4 rounded-lg border border-gray-100 text-sm leading-relaxed text-justify">
                            {{ $proposal->deskripsi }}
                        </div>
                    </div>

                    <div>
                        <label class="text-xs font-bold text-gray-400 uppercase tracking-wider block mb-2">File Dokumen</label>
                        @if($proposal->file_proposal)
                            <a href="{{ asset('storage/proposals/' . $proposal->file_proposal) }}" target="_blank"
                            class="group flex items-center p-4 border border-gray-200 rounded-xl hover:border-green-500 hover:bg-green-50 transition cursor-pointer relative overflow-hidden">
                                <div class="absolute left-0 top-0 bottom-0 w-1 bg-gray-200 group-hover:bg-green-500 transition"></div>
                                <div class="flex-shrink-0 h-12 w-12 bg-red-100 text-red-500 rounded-lg flex items-center justify-center group-hover:scale-110 transition duration-300">
                                    <i class="fas fa-file-pdf text-2xl"></i>
                                </div>
                                <div class="ml-4 flex-1">
                                    <p class="text-sm font-bold text-gray-800 group-hover:text-green-700">Download File Proposal</p>
                                    <p class="text-xs text-gray-500 group-hover:text-green-600">Klik untuk melihat atau mengunduh dokumen</p>
                                </div>
                                <div>
                                    <i class="fas fa-download text-gray-400 group-hover:text-green-600"></i>
                                </div>
                            </a>
                        @else
                            <div class="p-4 border border-dashed border-gray-300 rounded-xl text-center bg-gray-50">
                                <p class="text-sm text-gray-500 italic">File tidak tersedia</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-4 border-b border-gray-100 bg-yellow-50 flex items-center gap-2">
                    <i class="fas fa-sticky-note text-yellow-600"></i>
                    <h2 class="text-lg font-bold text-gray-800">Catatan Dosen Pembimbing</h2>
                </div>
                <div class="p-6">
                    @if($proposal->catatan_dosen)
                        <div class="bg-yellow-50/50 text-gray-800 p-4 rounded-lg border border-yellow-200 text-sm leading-relaxed">
                            <i class="fas fa-quote-left text-yellow-300 mr-2"></i>
                            {{ $proposal->catatan_dosen }}
                        </div>
                    @else
                        <div class="text-center py-4">
                            <p class="text-gray-400 italic text-sm">Belum ada catatan atau revisi dari dosen pembimbing.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="lg:col-span-1 space-y-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <label class="text-xs font-bold text-gray-400 uppercase tracking-wider block mb-3">Status Pengajuan</label>

                @php
                    $statusConfig = match ($proposal->status) {
                        'pending' => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-800', 'icon' => 'fa-clock', 'label' => 'Menunggu Review'],
                        'diterima' => ['bg' => 'bg-green-100', 'text' => 'text-green-800', 'icon' => 'fa-check-circle', 'label' => 'Diterima'],
                        'ditolak' => ['bg' => 'bg-red-100', 'text' => 'text-red-800', 'icon' => 'fa-times-circle', 'label' => 'Ditolak'],
                        'revisi' => ['bg' => 'bg-orange-100', 'text' => 'text-orange-800', 'icon' => 'fa-edit', 'label' => 'Perlu Revisi'],
                        default => ['bg' => 'bg-gray-100', 'text' => 'text-gray-800', 'icon' => 'fa-info-circle', 'label' => ucfirst($proposal->status)],
                    };
                @endphp

                <div class="flex flex-col items-center justify-center p-5 rounded-xl {{ $statusConfig['bg'] }} {{ $statusConfig['text'] }} mb-5 border border-transparent">
                    <i class="fas {{ $statusConfig['icon'] }} text-3xl mb-2"></i>
                    <span class="text-lg font-bold">{{ $statusConfig['label'] }}</span>
                </div>

                <div class="space-y-4 pt-2">
                    <div class="flex justify-between items-center border-b border-gray-50 pb-2">
                        <p class="text-xs text-gray-500">Tanggal Upload</p>
                        <p class="text-sm font-semibold text-gray-700">{{ $proposal->created_at->translatedFormat('d M Y') }}</p>
                    </div>
                    <div class="flex justify-between items-center border-b border-gray-50 pb-2">
                        <p class="text-xs text-gray-500">Jam Upload</p>
                        <p class="text-sm font-semibold text-gray-700">{{ $proposal->created_at->format('H:i') }} WIB</p>
                    </div>
                    <div class="flex justify-between items-center">
                        <p class="text-xs text-gray-500">Terakhir Update</p>
                        <p class="text-sm font-semibold text-gray-700">{{ $proposal->updated_at->diffForHumans() }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <label class="text-xs font-bold text-gray-400 uppercase tracking-wider block mb-4">Dosen Pembimbing</label>
                <div class="flex items-center">
                    <div class="h-12 w-12 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold mr-4 text-lg border border-indigo-200 shadow-sm">
                        {{ $proposal->dosen ? substr($proposal->dosen->name, 0, 1) : '?' }}
                    </div>
                    <div class="overflow-hidden">
                        <p class="text-sm font-bold text-gray-800 truncate" title="{{ $proposal->dosen ? $proposal->dosen->name : 'Belum ditentukan' }}">
                            {{ $proposal->dosen ? $proposal->dosen->name : 'Belum Ditentukan' }}
                        </p>
                        <p class="text-xs text-gray-500 truncate">
                            {{ $proposal->dosen ? ($proposal->dosen->email ?? 'Email tidak tersedia') : '-' }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="flex flex-col gap-3">
                @if(in_array($proposal->status, ['pending', 'ditolak', 'revisi']))
                    <a href="{{ route('mahasiswa.proposals.edit', $proposal->id) }}" class="w-full text-center px-4 py-3 bg-yellow-500 hover:bg-yellow-600 text-white rounded-lg shadow-sm transition font-medium flex items-center justify-center gap-2">
                        <i class="fas fa-edit"></i> Edit Proposal
                    </a>
                @endif

                <a href="{{ route('mahasiswa.proposals.index') }}" class="w-full text-center px-4 py-3 bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 rounded-lg shadow-sm transition font-medium flex items-center justify-center gap-2">
                    <i class="fas fa-arrow-left"></i> Kembali ke Daftar
                </a>
            </div>
        </div>

    </div>
@endsection
