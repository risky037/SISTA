@extends('layouts.app')

@section('title', 'Edit Template Skripsi')

@section('content')
    <div class="flex justify-between items-center mb-4">
        <div>
            <h1 class="text-gray-800 text-xl font-semibold">@yield('title')</h1>
            <p class="text-gray-500 text-sm">Halaman untuk memperbarui data template skripsi.</p>
        </div>
        <nav class="text-sm text-gray-500">
            <ol class="list-reset flex">
                <li><a href="{{ route('admin.dashboard') }}" class="hover:text-green-600">Home</a></li>
                <li><span class="mx-2">/</span></li>
                <li><a href="{{ route('admin.template.index') }}" class="hover:text-green-600">Manajemen Template</a></li>
                <li><span class="mx-2">/</span></li>
                <li class="text-gray-700">Edit</li>
            </ol>
        </nav>
    </div>

    <div class="p-6 bg-white rounded-lg shadow-md">
        @if ($errors->any())
            <div class="mb-4 bg-red-100 text-red-800 p-3 rounded-md border border-red-400">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.template.update', $template->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="nama_template" class="block text-sm font-medium text-gray-700">Nama Template</label>
                <input type="text" id="nama_template" name="nama_template"
                    value="{{ old('nama_template', $template->nama_template) }}"
                    class="w-full border rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-green-500"
                    required>
            </div>

            <div class="mb-4">
                <label for="prodi" class="block text-sm font-medium text-gray-700">Program Studi</label>
                <input type="text" id="prodi" name="prodi" value="{{ old('prodi', $template->prodi) }}"
                    class="w-full border rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-green-500">
            </div>

            <div class="mb-4">
                <label for="aturan_format" class="block text-sm font-medium text-gray-700">Deskripsi/Aturan Format</label>
                <textarea id="aturan_format" name="aturan_format" rows="4"
                    class="w-full border rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-green-500">{{ old('aturan_format', $template->aturan_format) }}</textarea>
            </div>

            <div class="mb-6">
                <label for="file" class="block text-sm font-medium text-gray-700">Ganti File Template</label>
                <input type="file" id="file" name="file" accept=".pdf,.docx"
                    class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100">
                <p class="mt-2 text-sm text-gray-500">File saat ini: <a
                        href="{{ asset('storage/' . $template->file_path) }}" target="_blank"
                        class="text-blue-600 hover:underline">{{ basename($template->file_path) }}</a></p>
                <p class="mt-1 text-sm text-gray-500">File yang diizinkan: .pdf, .docx (maks. 2MB)</p>
            </div>

            <div class="flex space-x-4">
                <button type="submit"
                    class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                    Update
                </button>
                <a href="{{ route('admin.template.index') }}"
                    class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md shadow-sm text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                    Batal
                </a>
            </div>
        </form>
    </div>
@endsection
