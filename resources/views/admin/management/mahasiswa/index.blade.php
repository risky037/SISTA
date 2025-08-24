@extends('layouts.app')

@section('title', 'Manajemen Mahasiswa')

@section('content')
    <div class="flex justify-between items-center mb-4">
        <div>
            <h1 class="text-gray-800 text-xl font-semibold">@yield('title')</h1>
            <p class="text-gray-500 text-sm">Halaman untuk mengelola data mahasiswa, termasuk menambah, mengedit, dan
                menghapus
                akun mahasiswa.</p>
        </div>
        <nav class="text-sm text-gray-500">
            <ol class="list-reset flex">
                <li><a href="{{ route('admin.dashboard') }}" class="hover:text-green-600">Home</a></li>
                <li><span class="mx-2">/</span></li>
                <li class="text-gray-700">Manajemen Mahasiswa</li>
            </ol>
        </nav>
    </div>
    <div class="p-6 bg-white rounded-lg shadow-md">
        <a href="{{ route('admin.management.mahasiswa.create') }}"
            class="px-4 py-2 bg-green-600 text-white rounded-md mb-4 inline-block hover:bg-green-700 transition-colors">
            <i class="fas fa-plus mr-2"></i>Tambah Mahasiswa
        </a>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded-md my-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto">
            <table class="table-auto w-full mt-4 border border-gray-200 rounded-lg min-w-[600px]">
                <thead class="bg-green-100 text-gray-700">
                    <tr>
                        <th class="px-2 md:px-4 py-2 border text-left">Foto</th>
                        <th class="px-2 md:px-4 py-2 border text-left">Nama</th>
                        <th class="px-2 md:px-4 py-2 border text-left">Email</th>
                        <th class="px-2 md:px-4 py-2 border text-left">NIM</th>
                        <th class="px-2 md:px-4 py-2 border text-left">Prodi</th>
                        <th class="px-2 md:px-4 py-2 border text-left">No HP</th>
                        <th class="px-2 md:px-4 py-2 border text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($mahasiswa as $m)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-2 md:px-4 py-2 border">
                                @if ($m->foto)
                                    <img src="{{ asset('storage/' . $m->foto) }}" alt="Foto Mahasiswa" width="50"
                                        class="rounded-full object-cover w-12 h-12">
                                @else
                                    <img src="https://lembahbambu.ridhsuki.my.id/storage/photos/defaultpp.jpg" alt="Foto Default" width="50"
                                        class="rounded-full object-cover w-12 h-12">
                                @endif
                            </td>
                            <td class="px-2 md:px-4 py-2 border break-words max-w-[200px]">{{ $m->name }}</td>
                            <td class="px-2 md:px-4 py-2 border break-words max-w-[200px]">{{ $m->email }}</td>
                            <td class="px-2 md:px-4 py-2 border break-words max-w-[100px]">{{ $m->NIM }}</td>
                            <td class="px-2 md:px-4 py-2 border break-words max-w-[150px]">{{ $m->prodi }}</td>
                            <td class="px-2 md:px-4 py-2 border break-words max-w-[120px]">{{ $m->no_hp }}</td>
                            <td class="px-2 md:px-4 py-2 border flex flex-col md:flex-row gap-1 md:gap-2 items-center">
                                <a href="{{ route('admin.management.mahasiswa.edit', $m->id) }}"
                                    class="px-3 py-1 bg-blue-500 text-white rounded text-center hover:bg-blue-600 transition-colors">Edit</a>
                                <form action="{{ route('admin.management.mahasiswa.destroy', $m->id) }}" method="POST"
                                    onsubmit="return confirm('Yakin ingin menghapus data mahasiswa ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600 transition-colors">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center p-4 text-gray-500">Belum ada data mahasiswa.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($mahasiswa->hasPages())
            <div class="mt-4">
                {{ $mahasiswa->links() }}
            </div>
        @endif
    </div>
@endsection
