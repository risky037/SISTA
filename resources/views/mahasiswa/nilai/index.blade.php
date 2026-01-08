@extends('layouts.app')

@section('title', 'Transkrip Nilai Bimbingan')

@section('content')
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">@yield('title')</h1>
            <p class="text-gray-500 text-sm mt-1">Pantau perkembangan nilai Proposal dan Dokumen Skripsi Anda.</p>
        </div>
        <nav class="text-sm font-medium text-gray-500 bg-gray-100 px-4 py-2 rounded-lg">
            <ol class="list-reset flex items-center gap-2">
                <li><a href="{{ route('mahasiswa.dashboard') }}" class="hover:text-green-600">Home</a></li>
                <li><span class="mx-2">/</span></li>
                <li class="text-green-600">Nilai</li>
            </ol>
        </nav>
    </div>

    <div class="mb-10">
        <div class="mb-6">
            <h2 class="text-xl font-bold text-gray-800">Nilai Proposal Skripsi</h2>
            <p class="text-gray-500 text-sm mt-1">Seminar & Sidang Proposal</p>
        </div>

        @if ($nilaiProposal->count() > 0)
            <div class="hidden md:block bg-white rounded-[2rem] shadow-sm border border-slate-200 overflow-hidden">
                <table class="w-full text-sm text-left">
                    <thead class="text-xs text-slate-400 uppercase tracking-widest bg-slate-50 border-b border-slate-100">
                        <tr>
                            <th class="px-8 py-5 font-black">Judul & Catatan</th>
                            <th class="px-6 py-5 font-black">Tanggal</th>
                            <th class="px-6 py-5 font-black text-center">Grade</th>
                            <th class="px-8 py-5 font-black text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach ($nilaiProposal as $n)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-8 py-6">
                                    <span
                                        class="block font-bold text-slate-800 text-base mb-1">{{ $n->proposal->judul ?? 'Judul tidak tersedia' }}</span>
                                    <span
                                        class="text-xs text-slate-500 italic">"{{ $n->keterangan ?? 'Tidak ada catatan khusus' }}"</span>
                                </td>
                                <td class="px-6 py-6 whitespace-nowrap text-slate-600 font-medium">
                                    {{ $n->created_at->format('d M Y') }}
                                </td>
                                <td class="px-6 py-6">
                                    @include('layouts.partials.grade-badge', ['grade' => $n->grade])
                                </td>
                                <td class="px-8 py-6 text-right">
                                    <a href="{{ route('mahasiswa.nilai.show', $n->id) }}"
                                        class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-slate-100 text-slate-500 hover:bg-green-600 hover:text-white transition-all shadow-sm">
                                        <i class="fas fa-chevron-right text-xs"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="grid grid-cols-1 gap-4 md:hidden">
                @foreach ($nilaiProposal as $n)
                    <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm relative overflow-hidden">
                        <div class="absolute top-0 right-0 p-4">
                            @include('layouts.partials.grade-badge', ['grade' => $n->grade])
                        </div>
                        <div class="pr-16">
                            <p class="text-[10px] font-black uppercase tracking-widest text-green-600 mb-1">Proposal</p>
                            <h3 class="font-bold text-slate-800 leading-snug mb-3">
                                {{ $n->proposal->judul ?? 'Judul tidak tersedia' }}</h3>
                            <div class="flex items-center gap-2 text-slate-400 text-xs mb-4 font-medium">
                                <i class="far fa-calendar-alt"></i>
                                {{ $n->created_at->format('d M Y') }}
                            </div>
                            <a href="{{ route('mahasiswa.nilai.show', $n->id) }}"
                                class="flex items-center justify-center w-full py-3 bg-slate-50 text-slate-600 text-xs font-black uppercase tracking-widest rounded-xl border border-slate-100">
                                Lihat Detail Nilai
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            @include('layouts.partials.empty-state', [
                'icon' => 'fa-inbox',
                'text' => 'Belum ada nilai proposal.',
            ])
        @endif
    </div>

    <div>
        <div class="mb-6">
            <h2 class="text-xl font-bold text-gray-800">Nilai Dokumen Akhir</h2>
            <p class="text-gray-500 text-sm mt-1">Progres Bab & Final Skripsi</p>
        </div>

        @if ($nilaiDokumenAkhir->count() > 0)
            <div class="hidden md:block bg-white rounded-[2rem] shadow-sm border border-slate-200 overflow-hidden text-sm">
                <table class="w-full text-left">
                    <thead class="text-xs text-slate-400 uppercase tracking-widest bg-slate-50 border-b border-slate-100">
                        <tr>
                            <th class="px-8 py-5 font-black text-center">Bab</th>
                            <th class="px-6 py-5 font-black">Dokumen & Penilai</th>
                            <th class="px-6 py-5 font-black text-center">Grade</th>
                            <th class="px-8 py-5 font-black text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach ($nilaiDokumenAkhir as $n)
                            <tr class="hover:bg-slate-50/50 transition">
                                <td class="px-8 py-6 text-center">
                                    <span
                                        class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-blue-50 text-blue-700 font-black border border-blue-100">
                                        {{ $n->dokumenAkhir->bab ?? '?' }}
                                    </span>
                                </td>
                                <td class="px-6 py-6">
                                    <div class="flex items-center gap-4">
                                        <div
                                            class="w-10 h-10 rounded-lg bg-rose-50 flex items-center justify-center text-rose-500">
                                            <i class="fas fa-file-pdf"></i>
                                        </div>
                                        <div>
                                            <span
                                                class="block font-bold text-slate-800 leading-tight">{{ $n->dokumenAkhir->judul ?? 'Judul Dokumen' }}</span>
                                            <span
                                                class="text-[11px] text-slate-400 font-bold uppercase tracking-tighter">Oleh:
                                                {{ $n->dosen->name ?? 'Dosen' }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-6">
                                    <div class="flex flex-col items-center gap-1">
                                        @include('layouts.partials.grade-badge', ['grade' => $n->grade])
                                        <span
                                            class="text-[10px] text-slate-400 font-medium tracking-tight italic">{{ $n->updated_at->diffForHumans() }}</span>
                                    </div>
                                </td>
                                <td class="px-8 py-6 text-right">
                                    <a href="{{ route('mahasiswa.nilai.show', $n->id) }}"
                                        class="px-5 py-2.5 bg-white border border-slate-200 text-slate-600 text-xs font-black uppercase tracking-widest rounded-xl hover:bg-slate-900 hover:text-white transition-all shadow-sm">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="grid grid-cols-1 gap-4 md:hidden">
                @foreach ($nilaiDokumenAkhir as $n)
                    <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm relative overflow-hidden">
                        <div class="flex items-start gap-4 mb-4">
                            <div
                                class="w-12 h-12 flex-shrink-0 rounded-2xl bg-blue-50 text-blue-700 flex flex-col items-center justify-center border border-blue-100">
                                <span class="text-[8px] uppercase font-black leading-none mb-0.5">Bab</span>
                                <span class="text-lg font-black leading-none">{{ $n->dokumenAkhir->bab ?? '?' }}</span>
                            </div>
                            <div class="flex-1 pr-12">
                                <h3 class="font-bold text-slate-800 leading-snug mb-1">
                                    {{ $n->dokumenAkhir->judul ?? 'Judul Dokumen' }}</h3>
                                <p class="text-xs text-slate-400 font-medium italic">Penilai:
                                    {{ $n->dosen->name ?? 'Dosen' }}</p>
                            </div>
                            <div class="absolute top-6 right-6">
                                @include('layouts.partials.grade-badge', ['grade' => $n->grade])
                            </div>
                        </div>
                        <div class="pt-4 border-t border-slate-50 flex items-center justify-between">
                            <span
                                class="text-[10px] text-slate-400 font-medium">{{ $n->updated_at->format('d M Y') }}</span>
                            <a href="{{ route('mahasiswa.nilai.show', $n->id) }}"
                                class="text-blue-600 text-xs font-black uppercase tracking-widest">
                                Lihat Detail <i class="fas fa-arrow-right ml-1 text-[10px]"></i>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            @include('layouts.partials.empty-state', [
                'icon' => 'fa-folder-open',
                'text' => 'Belum ada nilai dokumen.',
            ])
        @endif
    </div>
@endsection

@section('styles')
    <style>
        .grade-badge {
            @apply inline-flex items-center justify-center font-black rounded-xl border-2;
        }
    </style>
@endsection
