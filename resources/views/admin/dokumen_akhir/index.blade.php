@extends('layouts.app')

@section('title', 'Monitoring Dokumen Akhir')

@section('content')
    <div class="flex justify-between items-center mb-4">
        <div>
            <h1 class="text-gray-800 text-xl font-semibold">@yield('title')</h1>
            <p class="text-gray-500 text-sm">Monitoring Dokumen Akhir Mahasiswa.</p>
        </div>
        <nav class="text-sm text-gray-500">
            <ol class="list-reset flex">
                <li><a href="{{ route('admin.dashboard') }}" class="hover:text-green-600">Home</a></li>
                <li><span class="mx-2">/</span></li>
                <li class="text-gray-700">@yield('title')</li>
            </ol>
        </nav>
    </div>
    <div class="container mx-auto px-4 py-4">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mahasiswa
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Progress
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pembimbing
                            Terakhir</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($mahasiswas as $mhs)
                        @php
                            $totalUpload = $mhs->dokumenAkhir ? $mhs->dokumenAkhir->count() : 0;
                            $approved = $mhs->dokumenAkhir
                                ? $mhs->dokumenAkhir->where('status', 'approved')->count()
                                : 0;
                            $lastDoc = $mhs->dokumenAkhir ? $mhs->dokumenAkhir->last() : null;
                        @endphp
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="text-sm font-medium text-gray-900">{{ $mhs->name }}</div>
                                </div>
                                <div class="text-sm text-gray-500">{{ $mhs->email }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="w-full bg-gray-200 rounded-full h-2.5 max-w-[100px]">
                                    <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ ($approved / 6) * 100 }}%">
                                    </div>
                                </div>
                                <span class="text-xs text-gray-500 mt-1 inline-block">{{ $approved }} dari 6 Bab
                                    Disetujui</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $lastDoc && $lastDoc->dosen ? $lastDoc->dosen->name : '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('admin.dokumen-akhir.show', $mhs->id) }}"
                                    class="text-blue-600 hover:text-blue-900">Detail</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
