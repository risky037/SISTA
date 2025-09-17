@extends('layouts.app')

@section('title', 'Data Nilai Mahasiswa')

@section('content')
    <div class="flex justify-between items-center mb-4">
        <div>
            <h1 class="text-gray-800 text-xl font-semibold">@yield('title')</h1>
            <p class="text-gray-500 text-sm">Halaman untuk melihat dan mengelola nilai mahasiswa bimbingan.</p>
        </div>
        <nav class="text-sm text-gray-500">
            <ol class="list-reset flex">
                <li><a href="{{ route('dosen.dashboard') }}" class="hover:text-green-600">Home</a></li>
                <li><span class="mx-2">/</span></li>
                <li class="text-gray-700">Nilai Mahasiswa</li>
            </ol>
        </nav>
    </div>

    <div class="p-6 bg-white rounded-lg shadow-md">
        <div class="flex justify-end mb-4">
            <a href="{{ route('dosen.nilai.create') }}"
                class="px-4 py-2 bg-green-600 text-white text-sm rounded-lg hover:bg-green-700 transition">
                + Tambah Nilai
            </a>
        </div>

        <div class="relative overflow-x-auto">
            <h2 class="text-lg font-semibold mb-4">Proposal yang Sudah Dinilai</h2>
            <table class="table-auto w-full mt-2 border border-gray-200 rounded-lg min-w-[600px]">
                <thead class="bg-green-100 text-gray-700">
                    <tr>
                        <th class="px-2 md:px-4 py-2 border text-left">Mahasiswa</th>
                        <th class="px-2 md:px-4 py-2 border text-left">Judul Tugas Akhir</th>
                        <th class="px-2 md:px-4 py-2 border text-center">Nilai</th>
                        <th class="px-2 md:px-4 py-2 border text-left">Keterangan</th>
                        <th class="px-2 md:px-4 py-2 border text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($nilai as $n)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3">{{ $n->proposal->mahasiswa->name ?? '-' }}</td>
                            <td class="px-4 py-3">{{ $n->proposal->judul ?? '-' }}</td>
                            <td class="px-4 py-3 text-center font-semibold text-gray-700">{{ $n->grade ?? '-' }}</td>
                            <td class="px-4 py-3 text-sm text-gray-500">{{ $n->keterangan ?? '-' }}</td>
                            <td class="px-4 py-3 text-center text-sm font-medium">
                                <a href="{{ route('dosen.nilai.edit', $n->id) }}"
                                    class="text-yellow-600 hover:text-yellow-900 underline mr-2">✏️ Edit</a>
                                {{-- <form action="{{ route('dosen.nilai.destroy', $n->id) }}" method="POST" class="inline"
                                    onsubmit="return confirm('Yakin ingin menghapus nilai ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900 underline">🗑️
                                        Hapus</button>
                                </form> --}}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center p-4 text-gray-500">Belum ada data nilai mahasiswa.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="p-6 bg-white rounded-lg shadow-md mb-8">
        <h2 class="text-lg font-semibold mb-4">Proposal yang Belum Dinilai</h2>
        @if ($proposalsBelumDinilai->count() > 0)
            <div class="overflow-x-auto">
                <table class="table-auto w-full border border-gray-200 rounded-lg min-w-[600px]">
                    <thead class="bg-yellow-100 text-gray-700">
                        <tr>
                            <th class="px-4 py-2 border text-left">Nama Mahasiswa</th>
                            <th class="px-4 py-2 border text-left">Judul Proposal</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($proposalsBelumDinilai as $proposal)
                            <tr class="hover:bg-yellow-50">
                                <td class="px-4 py-3">{{ $proposal->mahasiswa->name ?? '-' }}</td>
                                {{-- <td class="px-4 py-3">{{ $proposal->judul ?? '-' }}</td> --}}
                                <td class="px-4 py-3">
                                    @if ($proposal->file_proposal)
                                        <a href="{{ asset('storage/proposals/' . $proposal->file_proposal) }}"
                                            target="_blank" class="text-blue-600 hover:underline">
                                            {{ $proposal->judul ?? '-' }}
                                        </a>
                                    @else
                                        {{ $proposal->judul ?? '-' }}
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center p-4 bg-yellow-50 border border-yellow-200 text-yellow-600 rounded-lg">
                Semua proposal sudah memiliki nilai.
            </div>
        @endif
    </div>
@endsection
