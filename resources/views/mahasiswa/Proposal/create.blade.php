@extends('layouts.app')

@section('title', 'Ajukan Proposal Baru')

@section('content')
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">@yield('title')</h1>
            <p class="text-gray-500 text-sm mt-1">Isi formulir di bawah untuk mengajukan proposal skripsi.</p>
        </div>
        <nav class="text-sm font-medium text-gray-500 bg-gray-100 px-4 py-2 rounded-lg">
            <ol class="list-reset flex items-center gap-2">
                <li><a href="{{ route('mahasiswa.dashboard') }}" class="hover:text-green-600">Home</a></li>
                <li><span class="mx-2">/</span></li>
                <li><a href="{{ route('mahasiswa.proposals.index') }}" class="hover:text-green-600">Daftar Proposal</a></li>
                <li><span class="mx-2">/</span></li>
                <li class="text-green-600">Ajukan</li>
            </ol>
        </nav>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">

        <div class="p-6 border-b border-gray-100 bg-green-50/50">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center text-green-600">
                    <i class="fas fa-pen-nib"></i>
                </div>
                <div>
                    <h2 class="text-lg font-bold text-gray-800">Formulir Pengajuan</h2>
                    <p class="text-xs text-gray-500">Pastikan data yang diisi sudah benar sebelum disimpan.</p>
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
                            <p class="text-sm font-bold text-red-800">Terdapat kesalahan pada input Anda:</p>
                            <ul class="mt-1 list-disc list-inside text-sm text-red-700">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <form action="{{ route('mahasiswa.proposals.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div class="col-span-1 md:col-span-2">
                        <label for="judul" class="block text-sm font-bold text-gray-700 mb-2">
                            <i class="fas fa-heading text-gray-400 mr-1"></i> Judul Proposal
                        </label>
                        <input type="text" id="judul" name="judul" value="{{ old('judul') }}"
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:border-green-500 focus:ring focus:ring-green-200 transition p-2.5"
                            placeholder="Masukkan judul lengkap skripsi..." required>
                    </div>

                    <div class="col-span-1 md:col-span-2">
                        <label for="dosen_pembimbing_id" class="block text-sm font-bold text-gray-700 mb-2">
                            <i class="fas fa-chalkboard-teacher text-gray-400 mr-1"></i> Dosen Pembimbing
                        </label>
                        <div class="relative">
                            <select id="dosen_pembimbing_id" name="dosen_pembimbing_id" required
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:border-green-500 focus:ring focus:ring-green-200 transition p-2.5 appearance-none bg-white">
                                <option value="" disabled selected>-- Pilih Dosen Pembimbing --</option>
                                @foreach ($dosens as $dosen)
                                    <option value="{{ $dosen->id }}"
                                        {{ old('dosen_pembimbing_id') == $dosen->id ? 'selected' : '' }}>
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
                        <label for="deskripsi" class="block text-sm font-bold text-gray-700 mb-2">
                            <i class="fas fa-align-left text-gray-400 mr-1"></i> Deskripsi / Latar Belakang
                        </label>
                        <textarea id="deskripsi" name="deskripsi" rows="5"
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:border-green-500 focus:ring focus:ring-green-200 transition p-2.5"
                            placeholder="Jelaskan secara singkat mengenai topik skripsi...">{{ old('deskripsi') }}</textarea>
                    </div>

                    <div class="col-span-1 md:col-span-2">
                        <label class="block text-sm font-bold text-gray-700 mb-2">
                            <i class="fas fa-file-upload text-gray-400 mr-1"></i> File Proposal
                        </label>
                        <div
                            class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:bg-gray-50 transition relative">
                            <div class="space-y-1 text-center">
                                <i class="fas fa-cloud-upload-alt text-3xl text-gray-400 mb-2"></i>
                                <div class="flex text-sm text-gray-600 justify-center">
                                    <label for="file_proposal"
                                        class="relative cursor-pointer bg-white rounded-md font-medium text-green-600 hover:text-green-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-green-500">
                                        <span>Upload file</span>
                                        <input id="file_proposal" name="file_proposal" type="file" class="sr-only"
                                            required
                                            onchange="document.getElementById('file-name').innerText = this.files[0].name">
                                    </label>
                                    <p class="pl-1">atau drag and drop</p>
                                </div>
                                <p class="text-xs text-gray-500">PDF, DOCX up to 2MB</p>
                                <p id="file-name" class="text-sm text-green-600 font-semibold mt-2"></p>
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
                        <i class="fas fa-paper-plane mr-2"></i> Ajukan Proposal
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
