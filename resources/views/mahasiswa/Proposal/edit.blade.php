@extends('layouts.app')

@section('title', 'Edit Proposal')

@section('content')
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">@yield('title')</h1>
            <p class="text-gray-500 text-sm mt-1">Perbarui informasi proposal skripsi Anda.</p>
        </div>
        <nav class="text-sm font-medium text-gray-500 bg-gray-100 px-4 py-2 rounded-lg">
            <ol class="list-reset flex items-center gap-2">
                <li><a href="{{ route('mahasiswa.dashboard') }}" class="hover:text-green-600">Home</a></li>
                <li><span class="mx-2">/</span></li>
                <li><a href="{{ route('mahasiswa.proposals.index') }}" class="hover:text-green-600">Daftar Proposal</a></li>
                <li><span class="mx-2">/</span></li>
                <li class="text-green-600">Edit</li>
            </ol>
        </nav>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">

        <div class="p-6 border-b border-gray-100 bg-yellow-50/50">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-yellow-100 flex items-center justify-center text-yellow-600">
                    <i class="fas fa-edit"></i>
                </div>
                <div>
                    <h2 class="text-lg font-bold text-gray-800">Edit Data</h2>
                    <p class="text-xs text-gray-500">Silakan perbarui data yang diperlukan.</p>
                </div>
            </div>
        </div>

        <div class="p-6 md:p-8">
            @if ($errors->any())
                <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-r shadow-sm">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-exclamation-circle text-red-500"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-bold text-red-800">Periksa input Anda:</p>
                            <ul class="mt-1 list-disc list-inside text-sm text-red-700">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <form action="{{ route('mahasiswa.proposals.update', $proposal->id) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">

                    <div class="col-span-1 md:col-span-2">
                        <label for="judul" class="block text-sm font-bold text-gray-700 mb-2">Judul Proposal</label>
                        <input type="text" id="judul" name="judul" value="{{ old('judul', $proposal->judul) }}"
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:border-green-500 focus:ring focus:ring-green-200 transition p-2.5"
                            required>
                    </div>

                    <div class="col-span-1 md:col-span-2">
                        <label for="dosen_pembimbing_id" class="block text-sm font-bold text-gray-700 mb-2">Dosen
                            Pembimbing</label>
                        <div class="relative">
                            <select id="dosen_pembimbing_id" name="dosen_pembimbing_id" required
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:border-green-500 focus:ring focus:ring-green-200 transition p-2.5 appearance-none bg-white">
                                <option value="" disabled>-- Pilih Dosen Pembimbing --</option>
                                @foreach ($dosens as $dosen)
                                    <option value="{{ $dosen->id }}"
                                        {{ old('dosen_pembimbing_id', $proposal->dosen_pembimbing_id) == $dosen->id ? 'selected' : '' }}>
                                        {{ $dosen->name }}
                                    </option>
                                @endforeach
                            </select>
                            <div
                                class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                            </div>
                        </div>
                    </div>

                    <div class="col-span-1 md:col-span-2">
                        <label for="deskripsi" class="block text-sm font-bold text-gray-700 mb-2">Deskripsi</label>
                        <textarea id="deskripsi" name="deskripsi" rows="5"
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:border-green-500 focus:ring focus:ring-green-200 transition p-2.5">{{ old('deskripsi', $proposal->deskripsi) }}</textarea>
                    </div>

                    <div class="col-span-1 md:col-span-2">
                        <label class="block text-sm font-bold text-gray-700 mb-2">Update File Proposal</label>

                        @if ($proposal->file_proposal)
                            <div
                                class="flex items-center p-3 mb-3 bg-blue-50 border border-blue-100 rounded-lg text-sm text-blue-700">
                                <i class="fas fa-file-pdf mr-2 text-lg"></i>
                                <span class="mr-2">File saat ini:</span>
                                <a href="{{ asset('storage/' . $proposal->file_proposal) }}" target="_blank"
                                    class="font-bold hover:underline truncate max-w-xs">
                                    {{ basename($proposal->file_proposal) }}
                                </a>
                            </div>
                        @endif

                        <div
                            class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:bg-gray-50 transition relative">
                            <div class="space-y-1 text-center">
                                <i class="fas fa-cloud-upload-alt text-3xl text-gray-400 mb-2"></i>
                                <div class="flex text-sm text-gray-600 justify-center">
                                    <label for="file_proposal"
                                        class="relative cursor-pointer bg-white rounded-md font-medium text-green-600 hover:text-green-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-green-500">
                                        <span>Ganti file</span>
                                        <input id="file_proposal" name="file_proposal" type="file" class="sr-only"
                                            onchange="document.getElementById('file-name-edit').innerText = this.files[0].name">
                                    </label>
                                    <p class="pl-1">atau drag ke sini</p>
                                </div>
                                <p class="text-xs text-gray-500">Biarkan kosong jika tidak ingin mengubah file.</p>
                                <p id="file-name-edit" class="text-sm text-green-600 font-semibold mt-2"></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 pt-6 border-t border-gray-100">
                    <a href="{{ route('mahasiswa.proposals.index') }}"
                        class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition">
                        Batal
                    </a>
                    <button type="submit"
                        class="px-5 py-2.5 text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 shadow-md transition flex items-center">
                        <i class="fas fa-save mr-2"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
