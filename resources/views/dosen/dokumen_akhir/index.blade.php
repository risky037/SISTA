@extends('layouts.app')

@section('title', 'Review Dokumen Akhir')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Review Dokumen Akhir</h1>
            <p class="text-gray-500 text-sm mt-1">Daftar mahasiswa bimbingan yang telah mengunggah dokumen.</p>
        </div>

        <nav class="text-sm text-gray-500">
            <ol class="list-reset flex">
                <li><a href="{{ route('dosen.dashboard') }}" class="hover:text-green-600">Dashboard</a></li>
                <li><span class="mx-2">/</span></li>
                <li class="text-gray-700">Dokumen Akhir</li>
            </ol>
        </nav>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
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
                            // Menghitung berapa bab yang sudah diupload
                            $uploadedCount = $m->dokumenAkhir->count();
                            // Mengambil update terakhir
                            $lastUpdate = $m->dokumenAkhir->sortByDesc('updated_at')->first();
                        @endphp
                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <div
                                            class="h-10 w-10 rounded-full bg-green-100 flex items-center justify-center text-green-600 font-bold">
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
                                <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-200 max-w-[150px]">
                                    <div class="bg-green-600 h-2.5 rounded-full"
                                        style="width: {{ ($uploadedCount / 6) * 100 }}%"></div>
                                </div>
                                <div class="text-xs text-gray-500 mt-1">{{ $uploadedCount }} dari 6 Bab</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if ($lastUpdate)
                                    <span class="text-sm text-gray-700">Bab {{ $lastUpdate->bab }}</span>
                                    <br>
                                    <span
                                        class="text-xs text-gray-400">{{ $lastUpdate->updated_at->diffForHumans() }}</span>
                                @else
                                    <span class="text-xs text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('dosen.dokumen-akhir.show-mahasiswa', $m->id) }}"
                                    class="inline-flex items-center px-4 py-2 bg-white border border-green-600 rounded-lg font-semibold text-green-600 text-xs uppercase tracking-widest shadow-sm hover:bg-green-50 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    Lihat Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-10 text-center text-gray-500">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <p class="mt-2 text-sm">Belum ada mahasiswa bimbingan yang mengupload dokumen.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
