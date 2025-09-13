@extends('layouts.app')

@section('title', 'Template Skripsi')

@section('content')
    <div class="flex justify-between items-center mb-4">
        <div>
            <h1 class="text-gray-800 text-xl font-semibold">Daftar Template Skripsi</h1>
            <p class="text-gray-500 text-sm">Silakan unduh template yang sesuai untuk penulisan skripsi.</p>
        </div>
        <nav class="text-sm text-gray-500">
            <ol class="list-reset flex">
                <li><a href="{{ route('mahasiswa.dashboard') }}" class="hover:text-green-600">Home</a></li>
                <li><span class="mx-2">/</span></li>
                <li class="text-gray-700">Template Skripsi</li>
            </ol>
        </nav>
    </div>

    <div class="p-6 bg-white rounded-lg shadow-md">
        <table class="table-auto w-full border border-gray-200 rounded-md">
            <thead class="bg-green-100 text-gray-700">
                <tr>
                    <th class="px-4 py-2 border text-left">Nama Template</th>
                    <th class="px-4 py-2 border text-left">Prodi</th>
                    <th class="px-4 py-2 border text-center">Format</th>
                    <th class="px-4 py-2 border text-left">Aturan Format</th>
                    <th class="px-4 py-2 border text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($templates as $template)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-2">{{ $template->nama_template }}</td>
                        <td class="px-4 py-2">{{ $template->prodi ?? '-' }}</td>
                        <td class="px-4 py-2 text-center uppercase">{{ $template->tipe_file }}</td>
                        <td class="px-4 py-2 text-sm text-gray-500">{{ $template->aturan_format ?? '-' }}</td>
                        <td class="px-4 py-2 text-center">
                            <a href="{{ asset('storage/' . $template->file_path) }}" target="_blank"
                                class="bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700 text-sm">
                                📥 Download
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-gray-500 py-4">Belum ada template yang tersedia.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">
            {{ $templates->links() }}
        </div>
    </div>
@endsection
