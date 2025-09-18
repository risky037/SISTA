@extends('layouts.app')

@section('title', 'Daftar Nilai Saya')

@section('content')
    <div class="flex justify-between items-center mb-4">
        <div>
            <h1 class="text-gray-800 text-xl font-semibold">@yield('title')</h1>
            <p class="text-gray-500 text-sm">Halaman untuk melihat nilai yang telah Anda peroleh.</p>
        </div>
        <nav class="text-sm text-gray-500">
            <ol class="list-reset flex">
                <li><a href="{{ route('mahasiswa.dashboard') }}" class="hover:text-green-600">Home</a></li>
                <li><span class="mx-2">/</span></li>
                <li class="text-gray-700">Nilai</li>
            </ol>
        </nav>
    </div>

    {{-- Tabel Nilai Proposal --}}
    <div class="p-6 bg-white rounded-lg shadow-md mb-6">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Nilai Proposal</h2>
        @if ($nilaiProposal->count() > 0)
            <div class="overflow-x-auto">
                <table class="table-auto w-full border border-gray-200 rounded-lg min-w-[600px]">
                    <thead class="bg-green-100 text-gray-700">
                        <tr>
                            <th class="px-4 py-2 border text-left">Judul Proposal</th>
                            <th class="px-4 py-2 border text-center">Nilai</th>
                            <th class="px-4 py-2 border text-left">Keterangan</th>
                            <th class="px-4 py-2 border text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($nilaiProposal as $n)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3">{{ $n->proposal->judul ?? '-' }}</td>
                                <td class="px-4 py-3 text-center font-semibold text-green-700">{{ $n->grade }}</td>
                                <td class="px-4 py-3 text-sm text-gray-500">{{ $n->keterangan ?? '-' }}</td>
                                <td class="px-4 py-3 text-center">
                                    <a href="{{ route('mahasiswa.nilai.show', $n->id) }}"
                                        class="text-blue-600 hover:text-blue-900 underline">Detail</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-gray-500 text-sm">Belum ada nilai proposal.</p>
        @endif
    </div>

    {{-- Tabel Nilai Dokumen Akhir --}}
    <div class="p-6 bg-white rounded-lg shadow-md">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Nilai Dokumen Akhir</h2>
        @if ($nilaiDokumenAkhir->count() > 0)
            <div class="overflow-x-auto">
                <table class="table-auto w-full border border-gray-200 rounded-lg min-w-[600px]">
                    <thead class="bg-blue-100 text-gray-700">
                        <tr>
                            <th class="px-4 py-2 border text-left">Judul Dokumen</th>
                            <th class="px-4 py-2 border text-center">Nilai</th>
                            <th class="px-4 py-2 border text-left">Keterangan</th>
                            <th class="px-4 py-2 border text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($nilaiDokumenAkhir as $n)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3">{{ $n->dokumenAkhir->judul ?? '-' }}</td>
                                <td class="px-4 py-3 text-center font-semibold text-blue-700">{{ $n->grade }}</td>
                                <td class="px-4 py-3 text-sm text-gray-500">{{ $n->keterangan ?? '-' }}</td>
                                <td class="px-4 py-3 text-center">
                                    <a href="{{ route('mahasiswa.nilai.show', $n->id) }}"
                                        class="text-blue-600 hover:text-blue-900 underline">Detail</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-gray-500 text-sm">Belum ada nilai dokumen akhir.</p>
        @endif
    </div>
@endsection
