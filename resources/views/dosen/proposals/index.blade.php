@extends('layouts.app')

@section('title', 'Review Proposal Mahasiswa')

@push('styles')
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
@endpush

@section('content')
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">@yield('title')</h1>
            <p class="text-gray-500 text-sm mt-1">Halaman untuk meninjau proposal mahasiswa bimbingan.</p>
        </div>
        <nav class="text-sm font-medium text-gray-500 bg-gray-100 px-4 py-2 rounded-lg">
            <ol class="list-reset flex items-center gap-2">
                <li><a href="{{ route('dosen.dashboard') }}" class="hover:text-green-600">Home</a></li>
                <li><span class="mx-2">/</span></li>
                <li class="text-green-600">@yield('title')</li>
            </ol>
        </nav>
    </div>

    <div class="grid grid-cols-2 md:flex md:justify-between items-center gap-3 mb-6">
        <div class="bg-white p-3 rounded-xl border border-gray-100 shadow-sm flex items-center gap-3 md:flex-1">
            <div class="p-2 bg-blue-50 rounded-lg text-blue-600 hidden sm:block">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                    </path>
                </svg>
            </div>
            <div>
                <p class="text-[10px] uppercase text-gray-400 font-bold leading-none mb-1">Total</p>
                <p class="text-lg font-bold text-gray-800">{{ $proposals->count() }}</p>
            </div>
        </div>
        <div class="bg-white p-3 rounded-xl border border-gray-100 shadow-sm flex items-center gap-3 md:flex-1">
            <div class="p-2 bg-yellow-50 rounded-lg text-yellow-600 hidden sm:block">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div>
                <p class="text-[10px] uppercase text-gray-400 font-bold leading-none mb-1">Pending</p>
                <p class="text-lg font-bold text-yellow-600">{{ $proposals->where('status', 'pending')->count() }}</p>
            </div>
        </div>
    </div>
    @if (session('success'))
        <div class="mb-4 p-4 bg-green-50 border-l-4 border-green-500 text-green-700">
            <p>
                {{ session('success') }}

                @if (session('show_grade_button'))
                    <a href="{{ route('dosen.nilai-proposal.index') }}"
                        class="font-bold underline ml-2 hover:text-green-900">
                        Beri nilai sekarang!
                    </a>
                @endif
            </p>
        </div>
    @endif
    <div x-data="{
        open: false,
        mhsName: '',
        judul: '',
        status: '',
        catatan: '',
        actionUrl: '',
        openModal(name, title, stat, note, url) {
            this.mhsName = name;
            this.judul = title;
            this.status = stat;
            this.catatan = note;
            this.actionUrl = url;
            this.open = true;
        }
    }">

        <div class="hidden md:block bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-50 border-b border-gray-100 text-gray-600 uppercase text-[11px] font-bold">
                    <tr>
                        <th class="px-6 py-4">Mahasiswa</th>
                        <th class="px-6 py-4">Judul Proposal</th>
                        <th class="px-6 py-4 text-center">Status</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($proposals as $proposal)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="h-8 w-8 rounded-full bg-green-100 text-green-700 flex items-center justify-center font-bold text-xs">
                                        {{ substr($proposal->mahasiswa->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="font-bold text-gray-800">{{ $proposal->mahasiswa->name }}</div>
                                        <div class="text-[10px] text-gray-500 uppercase">{{ $proposal->mahasiswa->nim }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-gray-700 font-medium line-clamp-1 mb-1" title="{{ $proposal->judul }}">
                                    {{ $proposal->judul }}</p>
                                @if ($proposal->file_proposal)
                                    <a href="{{ asset('storage/proposals/' . $proposal->file_proposal) }}" target="_blank"
                                        class="text-red-500 text-[10px] font-bold hover:underline flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z">
                                            </path>
                                        </svg>
                                        LIHAT PDF
                                    </a>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                @php
                                    $color = match ($proposal->status) {
                                        'diterima' => 'bg-green-100 text-green-700 border-green-200',
                                        'ditolak' => 'bg-red-100 text-red-700 border-red-200',
                                        default => 'bg-yellow-100 text-yellow-700 border-yellow-200',
                                    };
                                @endphp
                                <span
                                    class="{{ $color }} px-2 py-0.5 rounded-full text-[10px] font-bold uppercase border">
                                    {{ $proposal->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <button
                                    @click="openModal('{{ $proposal->mahasiswa->name }}', '{{ addslashes($proposal->judul) }}', '{{ $proposal->status }}', '{{ addslashes($proposal->catatan_dosen ?? '') }}', '{{ route('dosen.proposals.updateStatus', $proposal->id) }}')"
                                    class="bg-green-600 text-white text-[10px] font-bold px-3 py-1.5 rounded-lg hover:bg-green-700 transition">
                                    REVIEW
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="p-10 text-center text-gray-400">Belum ada proposal masuk.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="grid grid-cols-1 gap-4 md:hidden">
            @foreach ($proposals as $proposal)
                <div class="bg-white p-4 rounded-xl border border-gray-100 shadow-sm">
                    <div class="flex justify-between items-start mb-3">
                        <h4 class="font-bold text-gray-800 text-sm">{{ $proposal->mahasiswa->name }}</h4>
                        @php
                            $color = match ($proposal->status) {
                                'diterima' => 'bg-green-100 text-green-700',
                                'ditolak' => 'bg-red-100 text-red-700',
                                default => 'bg-yellow-100 text-yellow-700',
                            };
                        @endphp
                        <span
                            class="{{ $color }} px-2 py-0.5 rounded text-[9px] font-bold uppercase">{{ $proposal->status }}</span>
                    </div>
                    <p class="text-xs text-gray-600 line-clamp-2 mb-4 italic">"{{ $proposal->judul }}"</p>
                    <button
                        @click="openModal('{{ $proposal->mahasiswa->name }}', '{{ addslashes($proposal->judul) }}', '{{ $proposal->status }}', '{{ addslashes($proposal->catatan_dosen ?? '') }}', '{{ route('dosen.proposals.updateStatus', $proposal->id) }}')"
                        class="w-full bg-gray-100 text-gray-700 text-xs font-bold py-2 rounded-lg border border-gray-200">
                        Review Detail
                    </button>
                </div>
            @endforeach
        </div>

        <div x-show="open" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-gray-900/50 backdrop-blur-sm" x-cloak>

            <div @click.away="open = false"
                class="bg-white w-full max-w-md rounded-2xl shadow-xl overflow-hidden border-t-4 border-green-600">

                <div class="p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Review Proposal</h3>

                    <div class="mb-4 bg-gray-50 p-3 rounded-lg border border-gray-100">
                        <p class="text-[10px] font-bold text-gray-400 uppercase">Mahasiswa</p>
                        <p class="text-sm font-bold text-gray-800" x-text="mhsName"></p>
                    </div>

                    <form :action="actionUrl" method="POST">
                        @csrf
                        <div class="space-y-4">
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Status Keputusan</label>
                                <select name="status" x-model="status"
                                    class="w-full border-gray-200 rounded-lg text-sm focus:ring-green-500 focus:border-green-500">
                                    <option value="pending">Pending</option>
                                    <option value="diterima">Diterima</option>
                                    <option value="ditolak">Ditolak</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Catatan Dosen</label>
                                <textarea name="catatan_dosen" x-model="catatan" rows="4"
                                    class="w-full border-gray-200 rounded-lg text-sm focus:ring-green-500 focus:border-green-500"
                                    placeholder="Tulis alasan atau revisi..."></textarea>
                            </div>
                        </div>

                        <div class="flex gap-2 mt-6">
                            <button type="button" @click="open = false"
                                class="flex-1 px-4 py-2 bg-gray-100 text-gray-600 text-sm font-bold rounded-lg uppercase tracking-wide">Batal</button>
                            <button type="submit"
                                class="flex-1 px-4 py-2 bg-green-600 text-white text-sm font-bold rounded-lg shadow-md shadow-green-200 uppercase tracking-wide">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
