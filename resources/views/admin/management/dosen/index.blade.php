@extends('layout.app')

@section('title', 'Manajemen Dosen')

@section('content')
    <div class="flex justify-between items-center mb-4">
        <div>
            <h1 class="text-gray-800 text-xl font-semibold">@yield('title')</h1>
            <p class="text-gray-500 text-sm">Halaman untuk mengelola data dosen, termasuk menambah, mengedit, dan menghapus
                akun dosen.</p>
        </div>
        <nav class="text-sm text-gray-500">
            <ol class="list-reset flex">
                <li><a href="{{ route('admin.dashboard') }}" class="hover:text-green-600">Home</a></li>
                <li><span class="mx-2">/</span></li>
                <li class="text-gray-700">Manajemen Dosen</li>
            </ol>
        </nav>
    </div>
    <div class="p-6 bg-white rounded-lg shadow-md">
        <a href="{{ route('admin.management.dosen.create') }}"
            class="px-4 py-2 bg-green-600 text-white rounded-md mb-4 inline-block hover:bg-green-700 transition-colors">
            <i class="fas fa-plus mr-2"></i>Tambah Dosen
        </a>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded-md my-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto">
            <table class="table-auto w-full mt-4 border border-gray-200 rounded-lg min-w-[800px]">
                <thead class="bg-green-100 text-gray-700">
                    <tr>
                        <th class="px-2 md:px-4 py-2 border text-left">Nama</th>
                        <th class="px-2 md:px-4 py-2 border text-left">Email</th>
                        <th class="px-2 md:px-4 py-2 border text-left">NIDN</th>
                        <th class="px-2 md:px-4 py-2 border text-left">Bidang Keahlian</th>
                        <th class="px-2 md:px-4 py-2 border text-left">Foto</th>
                        <th class="px-2 md:px-4 py-2 border text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($dosen as $d)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-2 md:px-4 py-2 border break-words max-w-[150px]">{{ $d->name }}</td>
                            <td class="px-2 md:px-4 py-2 border break-words max-w-[200px]">{{ $d->email }}</td>
                            <td class="px-2 md:px-4 py-2 border break-words max-w-[150px]">{{ $d->NIDN }}</td>
                            <td class="px-2 md:px-4 py-2 border break-words max-w-[200px]">{{ $d->bidang_keahlian }}</td>
                            <td class="px-2 md:px-4 py-2 border">
                                @if ($d->foto)
                                    <img src="{{ asset('storage/' . $d->foto) }}" alt="Foto {{ $d->name }}"
                                        class="w-12 h-12 rounded-full object-cover">
                                @else
                                    <img src="https://lembahbambu.ridhsuki.my.id/storage/photos/defaultpp.jpg"
                                        alt="Foto Default" width="50" class="rounded-full object-cover w-12 h-12">
                                @endif
                            </td>
                            <td class="px-2 md:px-4 py-2 border flex flex-col md:flex-row gap-1 md:gap-2 items-center">
                                <a href="{{ route('admin.management.dosen.edit', $d->id) }}"
                                    class="px-3 py-1 bg-blue-500 text-white rounded text-center hover:bg-blue-600 transition-colors">Edit</a>
                                <form action="{{ route('admin.management.dosen.destroy', $d->id) }}" method="POST"
                                    onsubmit="return confirm('Yakin ingin menghapus data dosen ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600 transition-colors">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center p-4 text-gray-500">Belum ada data dosen.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
