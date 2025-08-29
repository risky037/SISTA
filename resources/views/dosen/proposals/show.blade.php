@extends('layouts.app')

@section('content')
    <div class="p-6">
        <h2 class="text-2xl font-bold mb-4">Detail Proposal</h2>

        {{-- Main card to display proposal details --}}
        <div class="bg-white shadow rounded-lg p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Mahasiswa (Student) Name --}}
                <div>
                    <p class="text-gray-500 text-sm">Mahasiswa</p>
                    <p class="font-semibold text-lg">{{ $proposal->mahasiswa->name }}</p>
                </div>
                {{-- Proposal Title --}}
                <div>
                    <p class="text-gray-500 text-sm">Judul</p>
                    <p class="font-semibold text-lg">{{ $proposal->judul }}</p>
                </div>
                {{-- Proposal Description (takes full width on medium screens) --}}
                <div class="md:col-span-2">
                    <p class="text-gray-500 text-sm">Deskripsi</p>
                    {{-- Displays description, or a dash if it's empty --}}
                    <p class="font-semibold text-lg">{{ $proposal->deskripsi ?? '-' }}</p>
                </div>
                {{-- Proposal File Link --}}
                <div>
                    <p class="text-gray-500 text-sm">File Proposal</p>
                    {{-- Links to the file stored in the 'storage' folder --}}
                    <a href="{{ asset('storage/' . $proposal->file_proposal) }}" target="_blank"
                        class="text-blue-600 hover:text-blue-800 underline font-semibold transition duration-200 ease-in-out">
                        Lihat File Proposal
                    </a>
                </div>
                {{-- Proposal Status --}}
                <div>
                    <p class="text-gray-500 text-sm">Status</p>
                    {{-- Converts the status to a capitalized string (e.g., 'pending' becomes 'Pending') --}}
                    <p class="font-semibold text-lg">{{ ucfirst($proposal->status) }}</p>
                </div>
                {{-- Dosen's Notes --}}
                <div class="md:col-span-2">
                    <p class="text-gray-500 text-sm">Catatan Dosen</p>
                    {{-- Displays notes, or a dash if they're empty --}}
                    <p class="font-semibold text-lg">{{ $proposal->catatan_dosen ?? '-' }}</p>
                </div>
            </div>
            {{-- Back button to return to the list --}}
            <div class="mt-6">
                <a href="{{ route('dosen.proposals.index') }}"
                    class="inline-block bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300 transition duration-200 ease-in-out">
                    Kembali ke Daftar
                </a>
            </div>
        </div>
    </div>
@endsection
