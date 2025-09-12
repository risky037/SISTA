@extends('layouts.app')

@section('title', 'Edit Proposal')

@section('content')
    <div class="flex justify-between items-center mb-4">
        <div>
            <h1 class="text-gray-800 text-xl font-semibold">@yield('title')</h1>
            <p class="text-gray-500 text-sm">Halaman untuk memperbarui data proposal skripsi Anda.</p>
        </div>
        <nav class="text-sm text-gray-500">
            <ol class="list-reset flex">
                <li><a href="{{ route('mahasiswa.dashboard') }}" class="hover:text-green-600">Home</a></li>
                <li><span class="mx-2">/</span></li>
                <li><a href="{{ route('mahasiswa.proposals.index') }}" class="hover:text-green-600">Daftar Proposal</a></li>
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

        <form action="{{ route('mahasiswa.proposals.update', $proposal->id) }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="judul" class="block text-sm font-medium text-gray-700">Judul</label>
                <input type="text" id="judul" name="judul" value="{{ old('judul', $proposal->judul) }}"
                    class="w-full border rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-green-500" required>
            </div>

            <div class="mb-4">
                <label for="deskripsi" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                <textarea id="deskripsi" name="deskripsi" rows="4"
                    class="w-full border rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-green-500">{{ old('deskripsi', $proposal->deskripsi) }}</textarea>
            </div>

            <div class="mb-6">
                <label for="file_proposal" class="block text-sm font-medium text-gray-700">Ganti File Proposal</label>
                <input type="file" id="file_proposal" name="file_proposal"
                    class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100">
                @if ($proposal->file_proposal)
                    <p class="mt-2 text-sm text-gray-500">File saat ini: <a
                            href="{{ asset('storage/' . $proposal->file_proposal) }}" target="_blank"
                            class="text-blue-600 hover:underline">{{ basename($proposal->file_proposal) }}</a></p>
                @endif
                <p class="mt-1 text-sm text-gray-500">File yang diizinkan: .pdf, .docx (maks. 2MB)</p>
            </div>
            
            <div class="mb-4">
                <label for="dosen_pembimbing_id" class="block text-sm font-medium text-gray-700">Pilih Dosen
                    Pembimbing</label>
                <select id="dosen_pembimbing_id" name="dosen_pembimbing_id" required
                    class="w-full border rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-green-500">
                    <option value="" disabled>-- Pilih Dosen Pembimbing --</option>
                    @foreach ($dosens as $dosen)
                        <option value="{{ $dosen->id }}"
                            {{ old('dosen_pembimbing_id', $proposal->dosen_pembimbing_id) == $dosen->id ? 'selected' : '' }}>
                            {{ $dosen->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex space-x-4">
                <button type="submit"
                    class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                    Update
                </button>
                <a href="{{ route('mahasiswa.proposals.index') }}"
                    class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md shadow-sm text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                    Kembali
                </a>
            </div>
        </form>
    </div>
@endsection
