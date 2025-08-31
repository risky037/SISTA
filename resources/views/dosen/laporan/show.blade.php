@extends('layouts.app')

@section('title', 'Detail Laporan Progress')

@section('content')
    <div class="flex justify-between items-center mb-4">
        <div>
            <h1 class="text-gray-800 text-xl font-semibold">@yield('title')</h1>
            <p class="text-gray-500 text-sm">Halaman untuk melihat detail dan memperbarui laporan progress.</p>
        </div>
        <nav class="text-sm text-gray-500">
            <ol class="list-reset flex">
                <li><a href="{{ route('dosen.dashboard') }}" class="hover:text-green-600">Home</a></li>
                <li><span class="mx-2">/</span></li>
                <li><a href="{{ route('dosen.laporan-progress.index') }}" class="hover:text-green-600">Laporan Progress</a>
                </li>
                <li><span class="mx-2">/</span></li>
                <li class="text-gray-700">Detail</li>
            </ol>
        </nav>
    </div>

    <div class="p-6 bg-white rounded-lg shadow-md">
        @if (session('success'))
            <div class="bg-green-100 text-green-800 p-3 rounded-md border border-green-400 mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="p-4 bg-gray-50 rounded-lg border border-gray-200 mb-6">
            <p class="mb-2"><strong>Mahasiswa:</strong> {{ $laporan->mahasiswa->name }}</p>
            <p class="mb-2"><strong>Judul:</strong> {{ $laporan->judul_laporan }}</p>
            <p class="mb-2"><strong>Deskripsi:</strong> {{ $laporan->deskripsi }}</p>
            @php
                $statusClass = match ($laporan->status) {
                    'submitted' => 'bg-yellow-100 text-yellow-800',
                    'reviewed' => 'bg-green-100 text-green-800',
                    default => 'bg-gray-100 text-gray-800',
                };
            @endphp
            <p class="mb-2">
                <strong>Status:</strong>
                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClass }}">
                    {{ ucfirst($laporan->status) }}
                </span>
            </p>
            <p><strong>Catatan Dosen:</strong> {{ $laporan->catatan_dosen ?? '-' }}</p>
        </div>

        <form action="{{ route('dosen.laporan-progress.update', $laporan->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="status" class="block text-sm font-medium text-gray-700">Ubah Status:</label>
                <select name="status" id="status"
                    class="mt-1 block w-full border rounded-md p-1 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                    <option value="submitted" {{ $laporan->status == 'submitted' ? 'selected' : '' }}>Submitted</option>
                    <option value="reviewed" {{ $laporan->status == 'reviewed' ? 'selected' : '' }}>Reviewed</option>
                </select>
            </div>

            <div class="mb-6">
                <label for="catatan_dosen" class="block text-sm font-medium text-gray-700">Catatan Dosen:</label>
                <textarea name="catatan_dosen" id="catatan_dosen" rows="3"
                    class="mt-1 block w-full border rounded-md p-1 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">{{ $laporan->catatan_dosen }}</textarea>
            </div>

            <div class="flex space-x-4">
                <button type="submit"
                    class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                    Simpan
                </button>
                <a href="{{ route('dosen.laporan-progress.index') }}"
                    class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md shadow-sm text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                    Kembali
                </a>
            </div>
        </form>
    </div>
@endsection
