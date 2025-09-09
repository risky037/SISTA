@extends('layouts.app')

@section('title', 'Daftar Nilai Mahasiswa')

@section('content')
    <div class="flex justify-between items-center mb-4">
        <div>
            <h1 class="text-gray-800 text-xl font-semibold">@yield('title')</h1>
            <p class="text-gray-500 text-sm">Halaman untuk mengelola data nilai mahasiswa.</p>
        </div>
        <a href="{{ route('dosen.nilai.create') }}"
           class="px-4 py-2 bg-green-600 text-white rounded-lg shadow hover:bg-green-700 transition">
            + Tambah Nilai
        </a>
    </div>

    <div class="p-6 bg-white rounded-lg shadow-md">
        @if (session('success'))
            <div class="bg-green-100 text-green-800 p-3 rounded-md border border-green-400 mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if($nilai->count() > 0)
            <div class="overflow-x-auto">
                <table class="table-auto w-full mt-4 border border-gray-200 rounded-lg min-w-[700px]">
                    <thead class="bg-green-100 text-gray-700">
                        <tr>
                            <th class="px-4 py-2 border">No</th>
                            <th class="px-4 py-2 border text-left">Mahasiswa</th>
                            <th class="px-4 py-2 border text-left">Komponen</th>
                            <th class="px-4 py-2 border text-center">Nilai</th>
                            <th class="px-4 py-2 border text-left">Keterangan</th>
                            <th class="px-4 py-2 border text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($nilai as $index => $n)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-2 text-sm">{{ $index + 1 }}</td>
                                <td class="px-4 py-2 text-sm font-medium text-gray-800">{{ $n->mahasiswa->nama ?? '-' }}</td>
                                <td class="px-4 py-2 text-sm">{{ $n->komponen ?? '-' }}</td>
                                <td class="px-4 py-2 text-center text-sm font-bold text-green-700">{{ $n->nilai ?? '-' }}</td>
                                <td class="px-4 py-2 text-sm">
                                    @if($n->nilai >= 70)
                                        <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-700">Lulus</span>
                                    @else
                                        <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-700">Remedial</span>
                                    @endif
                                </td>
                                <td class="px-4 py-2 text-center">
                                    <div class="flex justify-center gap-2">
                                        <a href="{{ route('dosen.nilai.edit', $n->id) }}"
                                           class="px-3 py-1 bg-blue-500 text-white rounded-md text-sm hover:bg-blue-600">
                                            Edit
                                        </a>
                                        <form action="{{ route('dosen.nilai.destroy', $n->id) }}" method="POST"
                                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="px-3 py-1 bg-red-500 text-white rounded-md text-sm hover:bg-red-600">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center p-6 bg-gray-50 border border-gray-200 rounded-lg text-gray-500">
                Belum ada data nilai mahasiswa.
            </div>
        @endif
    </div>
@endsection
