@extends('layouts.app')

@section('title', 'Manajemen Template Skripsi')

@section('content')
    <div class="flex justify-between items-center mb-4">
        <div>
            <h1 class="text-gray-800 text-xl font-semibold">@yield('title')</h1>
            <p class="text-gray-500 text-sm">Halaman untuk mengelola template skripsi yang tersedia.</p>
        </div>
        <nav class="text-sm text-gray-500">
            <ol class="list-reset flex">
                <li><a href="{{ route('admin.dashboard') }}" class="hover:text-green-600">Home</a></li>
                <li><span class="mx-2">/</span></li>
                <li class="text-gray-700">Manajemen Template</li>
            </ol>
        </nav>
    </div>

    <div class="p-6 bg-white rounded-lg shadow-md">
        <a href="{{ route('admin.template.create') }}"
            class="px-4 py-2 bg-green-600 text-white rounded-md mb-4 inline-block hover:bg-green-700 transition-colors">
            <i class="fas fa-plus mr-2"></i>Tambah Template
        </a>

        @if (session('success'))
            <div class="bg-green-100 text-green-800 p-3 rounded-md border border-green-400 mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto">
            <table class="table-auto w-full mt-4 border border-gray-200 rounded-lg min-w-[600px]">
                <thead class="bg-green-100 text-gray-700">
                    <tr>
                        <th scope="col" class="px-2 md:px-4 py-2 border text-left">Nama</th>
                        <th scope="col" class="px-2 md:px-4 py-2 border text-left">Prodi</th>
                        <th scope="col" class="px-2 md:px-4 py-2 border text-left">File</th>
                        <th scope="col" class="px-2 md:px-4 py-2 border text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($template as $t)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $t->nama_template }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $t->prodi ?? '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <a href="{{ asset('storage/' . $t->file_path) }}" target="_blank"
                                    class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                                    Lihat file
                                </a>
                            </td>
                            <td class="px-2 md:px-4 py-2 border flex flex-col md:flex-row gap-1 md:gap-2 items-center">
                                <a href="{{ route('admin.template.edit', $t) }}"
                                    class="px-3 py-1 bg-blue-500 text-white rounded text-center hover:bg-blue-600 transition-colors">Edit</a>
                                <form action="{{ route('admin.template.destroy', $t) }}" method="POST"
                                    class="inline delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600 transition-all duration-300">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center p-4 text-gray-500">Belum ada template skripsi yang
                                tersedia.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $template->links() }}
        </div>
    </div>
@endsection
