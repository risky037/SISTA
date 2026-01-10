@extends('layouts.app')

@section('title', 'Manajemen Proposal')

@section('content')
    <div class="flex justify-between items-center mb-4">
        <div>
            <h1 class="text-gray-800 text-xl font-semibold">@yield('title')</h1>
            <p class="text-gray-500 text-sm">Halaman untuk menglola pengajuan judul dan proposal mahasiswa.</p>
        </div>
        <nav class="text-sm text-gray-500">
            <ol class="list-reset flex">
                <li><a href="{{ route('admin.dashboard') }}" class="hover:text-green-600">Home</a></li>
                <li><span class="mx-2">/</span></li>
                <li class="text-gray-700">@yield('title')</li>
            </ol>
        </nav>
    </div>
    <div class="container mx-auto px-4 py-4">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
            <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-500 uppercase">Total Pengajuan</p>
                    <p class="text-2xl font-bold text-gray-800 mt-1">{{ $stats['total'] }}</p>
                </div>
                <div class="p-3 bg-blue-50 text-blue-600 rounded-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                        </path>
                    </svg>
                </div>
            </div>

            <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-500 uppercase">Menunggu Review</p>
                    <p class="text-2xl font-bold text-yellow-600 mt-1">{{ $stats['pending'] }}</p>
                </div>
                <div class="p-3 bg-yellow-50 text-yellow-600 rounded-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>

            <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-500 uppercase">Disetujui</p>
                    <p class="text-2xl font-bold text-green-600 mt-1">{{ $stats['approved'] }}</p>
                </div>
                <div class="p-3 bg-green-50 text-green-600 rounded-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>

            <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-500 uppercase">Ditolak</p>
                    <p class="text-2xl font-bold text-red-600 mt-1">{{ $stats['rejected'] }}</p>
                </div>
                <div class="p-3 bg-red-50 text-red-600 rounded-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">

            <div
                class="p-5 border-b border-gray-100 bg-gray-50/50 flex flex-col md:flex-row md:items-center justify-between gap-4">

                <form action="{{ route('admin.proposal.index') }}" method="GET" class="relative w-full md:w-64">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}"
                        class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition duration-150 ease-in-out"
                        placeholder="Cari Nama / Judul...">
                </form>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Mahasiswa</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider w-1/3">
                                Judul Proposal</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Dosen Pembimbing</th>
                            <th scope="col"
                                class="px-6 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Status</th>
                            <th scope="col"
                                class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($proposals as $proposal)
                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <div
                                                class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold text-sm">
                                                {{ substr($proposal->mahasiswa->name ?? '?', 0, 2) }}
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $proposal->mahasiswa->name ?? 'Deleted User' }}</div>
                                            <div class="text-xs text-gray-500">{{ $proposal->mahasiswa->NIM ?? '-' }}</div>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900 font-medium line-clamp-2"
                                        title="{{ $proposal->judul }}">
                                        {{ $proposal->judul }}
                                    </div>
                                    <div class="text-xs text-gray-500 mt-1">
                                        Upload: {{ $proposal->created_at->format('d M Y') }}
                                    </div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if ($proposal->dosen)
                                        <div class="text-sm text-gray-900">{{ $proposal->dosen->name }}</div>
                                        <div class="text-xs text-gray-500">NIDN:
                                            {{ $proposal->dosen->NIDN ?? '-' }}</div>
                                    @else
                                        <span class="text-xs text-red-500 italic">Belum ditentukan</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    @php
                                        $statusClasses = match ($proposal->status) {
                                            'diterima' => 'bg-green-100 text-green-800 border-green-200',
                                            'ditolak' => 'bg-red-100 text-red-800 border-red-200',
                                            default => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                                        };
                                        $statusLabel = match ($proposal->status) {
                                            'diterima' => 'Approved',
                                            'ditolak' => 'Rejected',
                                            default => 'Pending',
                                        };
                                    @endphp
                                    <span
                                        class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full border {{ $statusClasses }}">
                                        {{ $statusLabel }}
                                    </span>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex justify-end items-center gap-2">
                                        @if ($proposal->file_proposal)
                                            <a href="{{ asset('storage/proposals/' . $proposal->file_proposal) }}" target="_blank"
                                                class="text-gray-400 hover:text-blue-600 g-blue-50 p-2 rounded-lg transition"
                                                title="Download File">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                                    </path>
                                                </svg>
                                            </a>
                                        @endif

                                        <a href="{{ route('admin.proposal.edit', $proposal->id) }}"
                                            class="text-blue-600 hover:text-blue-900 bg-blue-50 p-2 rounded-lg transition"
                                            title="Edit Data">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                </path>
                                            </svg>
                                        </a>

                                        <button
                                            onclick="confirmDelete('{{ $proposal->id }}', '{{ addslashes($proposal->judul) }}')"
                                            class="text-red-600 hover:text-red-900 bg-red-50 p-2 rounded-lg transition"
                                            title="Hapus">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                </path>
                                            </svg>
                                        </button>

                                        <form id="delete-form-{{ $proposal->id }}"
                                            action="{{ route('admin.proposal.destroy', $proposal->id) }}" method="POST"
                                            class="hidden">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-10 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                            </path>
                                        </svg>
                                        <p class="text-gray-500 text-sm">Belum ada data proposal yang ditemukan.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
                {{ $proposals->withQueryString()->links() }}
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function confirmDelete(id, judul) {
            Swal.fire({
                title: 'Hapus Proposal?',
                text: "Anda akan menghapus data proposal: " + judul,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            })
        }
    </script>
@endpush
