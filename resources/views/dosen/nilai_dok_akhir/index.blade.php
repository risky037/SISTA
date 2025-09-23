@extends('layouts.app')

@section('title', 'Data Nilai Dokumen Akhir')

@section('content')
    <div class="flex justify-between items-center mb-4">
        <div>
            <h1 class="text-gray-800 text-xl font-semibold">@yield('title')</h1>
            <p class="text-gray-500 text-sm">Halaman untuk melihat dan mengelola nilai dokumen akhir mahasiswa.</p>
        </div>
        <nav class="text-sm text-gray-500">
            <ol class="list-reset flex">
                <li><a href="{{ route('dosen.dashboard') }}" class="hover:text-green-600">Home</a></li>
                <li><span class="mx-2">/</span></li>
                <li class="text-gray-700">Nilai Dokumen Akhir</li>
            </ol>
        </nav>
    </div>

    <div class="p-6 bg-white rounded-lg shadow-md">
        @if (session('success'))
            <div class="bg-green-100 text-green-800 p-3 rounded-md border border-green-400 mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="flex justify-end mb-4">
            <a href="{{ route('dosen.nilai-dokumen-akhir.create') }}"
                class="px-4 py-2 bg-green-600 text-white text-sm rounded-lg hover:bg-green-700 transition">
                + Tambah Nilai
            </a>
        </div>

        <div class="relative overflow-x-auto">
            <h2 class="text-lg font-semibold">Dokumen Akhir yang Sudah Dinilai</h2>
            <p class="text-sm text-gray-500 mb-4 italic">Hanya dokumen yang sudah direview yang dapat dinilai.</p>
            <table class="table-auto w-full mt-2 border border-gray-200 rounded-lg min-w-[600px]">
                <thead class="bg-green-100 text-gray-700">
                    <tr>
                        <th class="px-4 py-2 border text-left">Mahasiswa</th>
                        <th class="px-4 py-2 border text-left">Judul Dokumen</th>
                        <th class="px-4 py-2 border text-center">Nilai</th>
                        <th class="px-4 py-2 border text-left">Keterangan</th>
                        <th class="px-4 py-2 border text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($nilai as $n)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3">{{ $n->dokumenAkhir->mahasiswa->name ?? '-' }}</td>
                            <td class="px-4 py-3">
                                @if ($n->dokumenAkhir?->file)
                                    <a href="{{ $n->dokumenAkhir->file_url }}" target="_blank"
                                        class="text-blue-600 hover:underline">
                                        {{ $n->dokumenAkhir->judul ?? '-' }}
                                    </a>
                                @else
                                    {{ $n->dokumenAkhir->judul ?? '-' }}
                                @endif
                            </td>
                            <td class="px-4 py-3 text-center font-semibold text-gray-700">{{ $n->grade ?? '-' }}</td>
                            <td class="px-4 py-3 text-sm text-gray-500">{{ $n->keterangan ?? '-' }}</td>
                            <td class="px-4 py-3 text-center text-sm font-medium">
                                <a href="{{ route('dosen.nilai-dokumen-akhir.edit', $n->id) }}"
                                    class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Edit</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center p-4 text-gray-500">Belum ada nilai untuk dokumen akhir.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="p-6 bg-white rounded-lg shadow-md mb-8">
        <h2 class="text-lg font-semibold mb-4">Dokumen Akhir yang Belum Dinilai</h2>
        @if ($dokumenBelumDinilai->count() > 0)
            <div class="overflow-x-auto">
                <table class="table-auto w-full border border-gray-200 rounded-lg min-w-[600px]">
                    <thead class="bg-yellow-100 text-gray-700">
                        <tr>
                            <th class="px-4 py-2 border text-left">Nama Mahasiswa</th>
                            <th class="px-4 py-2 border text-left">Judul Dokumen</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($dokumenBelumDinilai as $dokumen)
                            @if ($dokumen->status !== 'pending')
                                <tr class="hover:bg-yellow-50">
                                    <td class="px-4 py-3">{{ $dokumen->mahasiswa->name ?? '-' }}</td>
                                    <td class="px-4 py-3">
                                        @if ($dokumen->file)
                                            <a href="{{ $dokumen->file_url }}" target="_blank"
                                                class="text-blue-600 hover:underline">
                                                {{ $dokumen->judul ?? '-' }}
                                            </a>
                                        @else
                                            {{ $dokumen->judul ?? '-' }}
                                        @endif
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center p-4 bg-yellow-50 border border-yellow-200 text-yellow-600 rounded-lg">
                @if ($jumlahDokumenPending > 0)
                    Belum ada dokumen akhir yang siap dinilai.
                    <a href="{{ route('dosen.dokumen-akhir.index') }}"
                        class="underline text-green-600 hover:text-green-800 font-medium">
                        Klik di sini untuk mereview dokumen
                    </a>
                @else
                    Semua dokumen akhir sudah memiliki nilai.
                @endif
            </div>
        @endif
    </div>
@endsection
