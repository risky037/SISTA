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

    <div class="p-6 bg-white rounded-lg shadow-md">
        @if ($nilai->count() > 0)
            <div class="overflow-x-auto">
                <table class="table-auto w-full mt-4 border border-gray-200 rounded-lg min-w-[600px]">
                    <thead class="bg-green-100 text-gray-700">
                        <tr>
                            <th class="px-2 md:px-4 py-2 border text-left">Judul Tugas Akhir</th>
                            <th class="px-2 md:px-4 py-2 border text-center">Nilai</th>
                            <th class="px-2 md:px-4 py-2 border text-left">Keterangan</th>
                            <th class="px-2 md:px-4 py-2 border text-left">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($nilai as $n)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3">{{ $n->proposal->judul ?? 'Tidak ada judul' }}</td>
                                <td class="px-4 py-3 text-center font-semibold text-green-700">{{ $n->grade }}</td>
                                <td class="px-4 py-3 text-sm text-gray-500">{{ $n->keterangan ?? '-' }}</td>
                                <td class="px-4 py-3 text-sm text-gray-500">
                                    <a href="{{ route('mahasiswa.nilai.show', $n->id) }}"
                                        class="text-blue-600 hover:text-blue-900 underline mr-2">Detail</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center p-6 bg-gray-50 border border-gray-200 rounded-lg text-gray-500">
                Belum ada nilai yang tersedia.
            </div>
        @endif
    </div>
@endsection
