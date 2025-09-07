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
        @if (session('success'))
            <div class="bg-green-100 text-green-800 p-3 rounded-md border border-green-400 mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="flex justify-end mb-4">
            <a href="{{ route('dosen.nilai.create') }}"
               class="px-4 py-2 bg-green-600 text-white text-sm rounded-lg hover:bg-green-700 transition">
               + Tambah Nilai
            </a>
        </div>

        <div class="relative overflow-x-auto">
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
                        <tr>
                            <td class="px-4 py-3">{{ $n->mahasiswa->name }}</td>
                            <td class="px-4 py-3">{{ $n->judul_tugas_akhir }}</td>
                            <td class="px-4 py-3 text-center font-semibold text-gray-700">{{ $n->nilai }}</td>
                            <td class="px-4 py-3 text-sm text-gray-500">{{ $n->keterangan ?? '-' }}</td>
                            <td class="px-4 py-3 text-center text-sm font-medium">
                                <div x-data="{ open: false }" class="relative inline-block text-left">
                                    <button type="button" @click="open = !open"
                                        class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-3 py-1 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none">
                                        Aksi
                                        <svg class="-mr-1 ml-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                             fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M19 9l-7 7-7-7"/>
                                        </svg>
                                    </button>

                                    <div x-show="open" @click.away="open = false"
                                        class="origin-top-right absolute right-0 mt-2 w-40 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-50"
                                        role="menu">
                                        <div class="py-1" role="none">
                                            <a href="{{ route('dosen.nilai.edit', $n->id) }}"
                                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                ✏️ Edit
                                            </a>
                                            <form action="{{ route('dosen.nilai.destroy', $n->id) }}" method="POST"
                                                  onsubmit="return confirm('Yakin ingin menghapus nilai ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                                                    🗑️ Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
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
@endsection 
