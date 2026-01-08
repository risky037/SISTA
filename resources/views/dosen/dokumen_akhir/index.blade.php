@extends('layouts.app')

@section('title', 'Review Dokumen Akhir')

@section('content')
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">@yield('title')</h1>
            <p class="text-gray-500 text-sm mt-1">Daftar mahasiswa bimbingan yang telah mengunggah dokumen.</p>
        </div>
        <nav class="text-sm font-medium text-gray-500 bg-gray-100 px-4 py-2 rounded-lg w-full md:w-auto">
            <ol class="list-reset flex items-center gap-2">
                <li><a href="{{ route('dosen.dashboard') }}" class="hover:text-green-600">Home</a></li>
                <li><span class="mx-2">/</span></li>
                <li class="text-green-600">@yield('title')</li>
            </ol>
        </nav>
    </div>

    <div class="hidden md:block bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            Mahasiswa</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            Progress Upload</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status
                            Terakhir</th>
                        <th class="px-6 py-4 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($mahasiswas as $m)
                        @php
                            $uploadedCount = $m->dokumenAkhir->count();
                            $lastUpdate = $m->dokumenAkhir->sortByDesc('updated_at')->first();
                        @endphp
                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <div
                                            class="h-10 w-10 rounded-full bg-green-100 flex items-center justify-center text-green-600 font-bold uppercase text-sm">
                                            {{ substr($m->name, 0, 1) }}
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $m->name }}</div>
                                        <div class="text-xs text-gray-500">{{ $m->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="w-full bg-gray-200 rounded-full h-2.5 max-w-[150px]">
                                    <div class="bg-green-600 h-2.5 rounded-full transition-all duration-500"
                                        style="width: {{ ($uploadedCount / 6) * 100 }}%"></div>
                                </div>
                                <div class="text-[11px] text-gray-500 mt-1 font-medium">{{ $uploadedCount }} dari 6 Bab
                                    Terupload</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if ($lastUpdate)
                                    <span class="text-sm font-bold text-gray-700">Bab {{ $lastUpdate->bab }}</span>
                                    <br>
                                    <span
                                        class="text-[10px] text-gray-400 uppercase">{{ $lastUpdate->updated_at->diffForHumans() }}</span>
                                @else
                                    <span class="text-xs text-gray-400 italic">Belum ada dokumen</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('dosen.dokumen-akhir.show-mahasiswa', $m->id) }}"
                                    class="inline-flex items-center px-4 py-2 bg-white border border-green-600 rounded-lg font-bold text-green-600 text-[10px] uppercase tracking-widest shadow-sm hover:bg-green-600 hover:text-white transition duration-200">
                                    Lihat Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-4 md:hidden">
        @forelse($mahasiswas as $m)
            @php
                $uploadedCount = $m->dokumenAkhir->count();
                $lastUpdate = $m->dokumenAkhir->sortByDesc('updated_at')->first();
                $percentage = ($uploadedCount / 6) * 100;
            @endphp
            <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm">
                <div class="flex items-start justify-between mb-4">
                    <div class="flex items-center gap-3">
                        <div
                            class="h-12 w-12 rounded-xl bg-green-50 text-green-600 flex items-center justify-center font-bold text-lg border border-green-100">
                            {{ substr($m->name, 0, 1) }}
                        </div>
                        <div class="min-w-0">
                            <h3 class="font-bold text-gray-800 text-sm truncate">{{ $m->name }}</h3>
                            <p class="text-[11px] text-gray-400 truncate">{{ $m->email }}</p>
                        </div>
                    </div>
                </div>

                <div class="space-y-4">
                    <div>
                        <div class="flex justify-between items-center mb-1.5">
                            <span class="text-[11px] font-bold text-gray-500 uppercase tracking-tight">Progress
                                Dokumen</span>
                            <span class="text-[11px] font-bold text-green-600">{{ $uploadedCount }}/6 Bab</span>
                        </div>
                        <div class="w-full bg-gray-100 rounded-full h-2">
                            <div class="bg-green-500 h-2 rounded-full" style="width: {{ $percentage }}%"></div>
                        </div>
                    </div>

                    <div class="flex items-center justify-between bg-gray-50 p-3 rounded-xl border border-gray-100">
                        <div class="flex flex-col">
                            <span class="text-[10px] text-gray-400 uppercase font-bold">Terakhir Update</span>
                            <span class="text-xs font-bold text-gray-700">
                                {{ $lastUpdate ? 'Bab ' . $lastUpdate->bab : 'N/A' }}
                            </span>
                        </div>
                        <span class="text-[10px] text-gray-400">
                            {{ $lastUpdate ? $lastUpdate->updated_at->diffForHumans() : '-' }}
                        </span>
                    </div>

                    <a href="{{ route('dosen.dokumen-akhir.show-mahasiswa', $m->id) }}"
                        class="block w-full text-center py-3 bg-green-600 text-white rounded-xl font-bold text-xs uppercase tracking-widest shadow-lg shadow-green-100 active:scale-[0.98] transition">
                        Lihat Detail Mahasiswa
                    </a>
                </div>
            </div>
        @empty
            <div class="bg-white p-12 rounded-2xl border-2 border-dashed border-gray-100 text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-gray-50 rounded-full mb-4">
                    <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
                <p class="text-gray-400 font-medium">Belum ada mahasiswa bimbingan.</p>
            </div>
        @endforelse
    </div>
@endsection
