@extends('layouts.app')

@section('title', 'Tambah Nilai Dokumen Akhir')

@section('content')
    <div class="flex justify-between items-center mb-4">
        <div>
            <h1 class="text-gray-800 text-xl font-semibold">@yield('title')</h1>
            <p class="text-gray-500 text-sm">Halaman untuk menambahkan nilai dokumen akhir mahasiswa.</p>
        </div>
        <nav class="text-sm text-gray-500">
            <ol class="list-reset flex">
                <li><a href="{{ route('dosen.dashboard') }}" class="hover:text-green-600">Home</a></li>
                <li><span class="mx-2">/</span></li>
                <li><a href="{{ route('dosen.nilai-dokumen-akhir.index') }}" class="hover:text-green-600">Nilai Dokumen Akhir</a></li>
                <li><span class="mx-2">/</span></li>
                <li class="text-gray-700">Tambah</li>
            </ol>
        </nav>
    </div>

    <div class="p-6 bg-white rounded-lg shadow-md">
        @if ($errors->any())
            <div class="mb-4 bg-red-100 text-red-800 p-3 rounded-md border border-red-400">
                <ul class="list-disc ml-5 text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('dosen.nilai-dokumen-akhir.store') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700">Dokumen Akhir Mahasiswa</label>
                <select name="dokumen_akhir_id"
                    class="mt-1 block w-full border rounded-md p-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500"
                    required>
                    <option value="">-- Pilih Dokumen --</option>
                    @foreach ($dokumenAkhir as $dok)
                        <option value="{{ $dok->id }}">
                            {{ $dok->mahasiswa->name }} - "{{ $dok->judul }}"
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Grade</label>
                <select name="grade"
                    class="mt-1 block w-full border rounded-md p-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500"
                    required>
                    <option value="">-- Pilih Grade --</option>
                    @foreach (['A+', 'A', 'A-', 'B+', 'B', 'B-', 'C+', 'C', 'C-', 'D', 'E'] as $grade)
                        <option value="{{ $grade }}">{{ $grade }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Keterangan</label>
                <textarea name="keterangan" rows="3"
                    class="mt-1 block w-full border rounded-md p-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500"></textarea>
            </div>

            <div class="flex justify-end">
                <a href="{{ route('dosen.nilai-dokumen-akhir.index') }}"
                    class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md mr-2 hover:bg-gray-300 transition">
                    Batal
                </a>
                <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition">
                    Simpan
                </button>
            </div>
        </form>
    </div>
@endsection
