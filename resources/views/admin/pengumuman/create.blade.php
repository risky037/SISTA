@extends('layouts.app')

@section('title', 'Buat Pengumuman Baru')

@section('content')
    <div class="flex justify-between items-center mb-4">
        <div>
            <h1 class="text-gray-800 text-xl font-semibold">@yield('title')</h1>
            <p class="text-gray-500 text-sm">Halaman untuk menambahkan data pengumuman baru.</p>
        </div>
        <nav class="text-sm text-gray-500">
            <ol class="list-reset flex">
                <li><a href="{{ route('admin.dashboard') }}" class="hover:text-green-600">Home</a></li>
                <li><span class="mx-2">/</span></li>
                <li><a href="{{ route('admin.pengumuman.index') }}" class="hover:text-green-600">Pengumuman</a></li>
                <li><span class="mx-2">/</span></li>
                <li class="text-gray-700">Tambah</li>
            </ol>
        </nav>
    </div>

    <div class="p-6 bg-white rounded-lg shadow-md">
        <h2 class="text-xl font-bold mb-4">Form Pengumuman</h2>

        {{-- Menampilkan Error Validasi Global --}}
        @if ($errors->any())
            <div class="mb-4 bg-red-100 text-red-700 p-3 rounded-md border border-red-400">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>- {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.pengumuman.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf

            <div>
                <label class="block text-gray-700">Nomor Surat</label>
                <input type="text" name="nomor_surat" value="{{ old('nomor_surat') }}"
                    class="w-full border rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-green-500 @error('nomor_surat') border-red-500 @enderror"
                    placeholder="Contoh: 001/AKAD/UICI/2026" required>
                @error('nomor_surat')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-gray-700">Tanggal Surat</label>
                <input type="date" name="tanggal" value="{{ old('tanggal') }}"
                    class="w-full border rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-green-500 @error('tanggal') border-red-500 @enderror"
                    required>
                @error('tanggal')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-gray-700">Informasi / Isi Pengumuman</label>
                <textarea name="informasi" rows="5"
                    class="w-full border rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-green-500 @error('informasi') border-red-500 @enderror"
                    placeholder="Masukkan detail informasi pengumuman..." required>{{ old('informasi') }}</textarea>
                @error('informasi')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-gray-700">Upload File PDF</label>
                <input type="file" name="file_pdf" accept=".pdf"
                    class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100 mt-1">
                <p class="text-xs text-gray-500 mt-1">Format PDF, Maksimal 2MB.</p>
                @error('file_pdf')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex gap-2 pt-4">
                <button type="submit"
                    class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition-colors">
                    <i class="fas fa-paper-plane mr-2"></i>Simpan & Kirim
                </button>
                <a href="{{ route('admin.pengumuman.index') }}"
                    class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 transition-colors">
                    Batal
                </a>
            </div>
        </form>
    </div>
@endsection
