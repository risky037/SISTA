@extends('layouts.app')

@section('title', 'Review Dokumen Akhir Mahasiswa')

@section('content')
    <div class="flex justify-between items-center mb-4">
        <div>
            <h1 class="text-gray-800 text-xl font-semibold">@yield('title')</h1>
            <p class="text-gray-500 text-sm">Halaman untuk meninjau dokumen akhir mahasiswa bimbingan Anda.</p>
        </div>
        <nav class="text-sm text-gray-500">
            <ol class="list-reset flex">
                <li><a href="{{ route('dosen.dashboard') }}" class="hover:text-green-600">Home</a></li>
                <li><span class="mx-2">/</span></li>
                <li class="text-gray-700">Dokumen Akhir</li>
            </ol>
        </nav>
    </div>

    <div class="p-6 bg-white rounded-lg shadow-md">
        @if (session('success'))
            <div class="bg-green-100 text-green-800 p-3 rounded-md border border-green-400 mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="relative overflow-visible">
            <table class="table-auto w-full mt-4 border border-gray-200 rounded-lg min-w-[600px]">
                <thead class="bg-blue-100 text-gray-700">
                    <tr>
                        <th class="px-2 md:px-4 py-2 border text-left">Mahasiswa</th>
                        <th class="px-2 md:px-4 py-2 border text-left">Judul</th>
                        <th class="px-2 md:px-4 py-2 border text-center">File</th>
                        <th class="px-2 md:px-4 py-2 border text-center">Status</th>
                        <th class="px-2 md:px-4 py-2 border text-left">Keterangan</th>
                        <th class="px-2 md:px-4 py-2 border text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($dokumen as $dok)
                        @php
                            $statusClass = match ($dok->status) {
                                'pending' => 'bg-yellow-100 text-yellow-800',
                                'approved' => 'bg-green-100 text-green-800',
                                'rejected' => 'bg-red-100 text-red-800',
                                default => 'bg-gray-100 text-gray-800',
                            };
                        @endphp
                        <tr>
                            <td class="px-6 py-4">{{ $dok->mahasiswa->name }}</td>
                            <td class="px-6 py-4">{{ $dok->judul }}</td>
                            <td class="px-6 py-4 text-center">
                                <a href="{{ asset('storage/' . $dok->file) }}" target="_blank"
                                    class="text-blue-600 hover:underline">Lihat Dokumen</a>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span
                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClass }}">
                                    {{ ucfirst($dok->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $dok->keterangan ?? '-' }}</td>
                            <td class="px-6 py-4 text-center text-sm font-medium">
                                <div x-data="{ open: false }" class="relative inline-block text-left">
                                    <button type="button" @click="open = !open"
                                        class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-green-500">
                                        Aksi
                                        <svg class="-mr-1 ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd"
                                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </button>

                                    <div x-show="open" @click.away="open = false"
                                        x-transition:enter="transition ease-out duration-100"
                                        x-transition:enter-start="transform opacity-0 scale-95"
                                        x-transition:enter-end="transform opacity-100 scale-100"
                                        x-transition:leave="transition ease-in duration-75"
                                        x-transition:leave-start="transform opacity-100 scale-100"
                                        x-transition:leave-end="transform opacity-0 scale-95"
                                        class="origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 divide-y divide-gray-100 focus:outline-none z-50"
                                        role="menu" aria-orientation="vertical" aria-labelledby="menu-button"
                                        tabindex="-1">
                                        <div class="py-1" role="none">
                                            <a href="{{ route('dosen.dokumen-akhir.show', $dok->id) }}"
                                                class="text-gray-700 block px-4 py-2 text-sm hover:bg-gray-100">
                                                <i class="fas fa-eye mr-2"></i> Lihat Detail
                                            </a>
                                        </div>
                                        <form action="{{ route('dosen.dokumen-akhir.updateStatus', $dok->id) }}"
                                            method="POST" class="py-1 px-4 space-y-2" role="none">
                                            @csrf
                                            <div class="block">
                                                <label for="status-{{ $dok->id }}"
                                                    class="text-xs font-semibold text-gray-700">Ubah Status:</label>
                                                <select name="status" id="status-{{ $dok->id }}"
                                                    class="mt-1 block w-full border rounded-md p-1 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                                                    <option value="pending" @selected($dok->status == 'pending')>Pending</option>
                                                    <option value="approved" @selected($dok->status == 'approved')>Approved</option>
                                                    <option value="rejected" @selected($dok->status == 'rejected')>Rejected</option>
                                                </select>
                                            </div>
                                            <div class="block">
                                                <label for="keterangan-{{ $dok->id }}"
                                                    class="text-xs font-semibold text-gray-700">Catatan:</label>
                                                <textarea name="keterangan" id="keterangan-{{ $dok->id }}" rows="2"
                                                    class="mt-1 block w-full border rounded-md p-1 text-sm focus:outline-none focus:ring-2 focus:ring-green-500"
                                                    placeholder="Tambahkan catatan">{{ $dok->keterangan }}</textarea>
                                            </div>
                                            <div class="block">
                                                <button type="submit"
                                                    class="w-full bg-green-600 text-white font-medium py-1 rounded-md hover:bg-green-700 transition-colors">Update</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center p-4 text-gray-500">Belum ada dokumen akhir mahasiswa.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
