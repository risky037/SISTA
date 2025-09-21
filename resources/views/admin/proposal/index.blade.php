@extends('layouts.app')

@section('title', 'Manajemen Proposal dan Dokumen Akhir')

@section('content')
    <div class="flex justify-between items-center mb-4">
        <div>
            <h1 class="text-gray-800 text-xl font-semibold">@yield('title')</h1>
            <p class="text-gray-500 text-sm">Halaman untuk mengelola data proposal dan dokumen akhir sidang.</p>
        </div>
        <nav class="text-sm text-gray-500">
            <ol class="list-reset flex">
                <li><a href="{{ route('admin.dashboard') }}" class="hover:text-green-600">Home</a></li>
                <li><span class="mx-2">/</span></li>
                <li class="text-gray-700">Manajemen Proposal dan Dokumen Akhir</li>
            </ol>
        </nav>
    </div>
    <div class="p-6 bg-white rounded-lg shadow-md">
        <h2 class="text-lg font-semibold text-gray-700 mb-4">Daftar Proposal</h2>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded-md my-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto">
            <table class="table-auto w-full mt-4 border border-gray-200 rounded-lg min-w-[600px]">
                <thead class="bg-green-100 text-gray-700">
                    <tr>
                        <th class="px-2 md:px-4 py-2 border text-left">Mahasiswa</th>
                        <th class="px-2 md:px-4 py-2 border text-left">Dosen Pembimbing</th>
                        <th class="px-2 md:px-4 py-2 border text-left">Judul</th>
                        <th class="px-2 md:px-4 py-2 border text-left">Status</th>
                        <th class="px-2 md:px-4 py-2 border text-left">File</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($proposals as $p)
                        @php
                            $statusColor = match ($p->status) {
                                'pending' => 'bg-yellow-200 text-yellow-800',
                                'diterima' => 'bg-green-200 text-green-800',
                                default => 'bg-red-200 text-red-800',
                            };
                        @endphp
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-2 md:px-4 py-2 border break-words max-w-[150px]">{{ $p->mahasiswa->name ?? '-' }}
                            </td>
                            <td class="px-2 md:px-4 py-2 border break-words max-w-[150px]">{{ $p->dosen->name ?? '-' }}</td>
                            <td class="px-2 md:px-4 py-2 border break-words max-w-[300px]">{{ $p->judul }}</td>
                            <td class="px-2 md:px-4 py-2 border">
                                <span class="text-xs font-semibold px-2.5 py-0.5 rounded {{ $statusColor }}">
                                    {{ ucfirst($p->status) }}
                                </span>
                            </td>
                            <td class="px-2 md:px-4 py-2 border">
                                @if ($p->file_proposal)
                                    <a href="{{ asset('storage/proposals/' . $p->file_proposal) }}" target="_blank"
                                        class="text-blue-600 hover:underline">Lihat</a>
                                @else
                                    <span class="text-gray-500">Tidak ada</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center p-4 text-gray-500">Belum ada data proposal.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="p-6 bg-white rounded-lg shadow-md">
        <h2 class="text-lg font-semibold text-gray-700 mb-4">Daftar Dokumen Akhir</h2>
        <div class="overflow-x-auto">
            <table class="table-auto w-full mt-4 border border-gray-200 rounded-lg min-w-[600px]">
                <thead class="bg-green-100 text-gray-700">
                    <tr>
                        <th class="px-2 md:px-4 py-2 border text-left">Mahasiswa</th>
                        <th class="px-2 md:px-4 py-2 border text-left">Dosen Pembimbing</th>
                        <th class="px-2 md:px-4 py-2 border text-left">Judul</th>
                        <th class="px-2 md:px-4 py-2 border text-left">Status</th>
                        <th class="px-2 md:px-4 py-2 border text-left">File</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($dokumens as $d)
                        @php
                            $statusColor = match ($d->status) {
                                'pending' => 'bg-yellow-200 text-yellow-800',
                                'approved' => 'bg-green-200 text-green-800',
                                default => 'bg-red-200 text-red-800',
                            };
                        @endphp
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-2 md:px-4 py-2 border break-words max-w-[150px]">
                                {{ $d->mahasiswa->name ?? '-' }}
                            </td>
                            <td class="px-2 md:px-4 py-2 border break-words max-w-[150px]">{{ $d->dosen->name ?? '-' }}
                            </td>
                            <td class="px-2 md:px-4 py-2 border break-words max-w-[300px]">{{ $d->judul }}</td>
                            <td class="px-2 md:px-4 py-2 border">
                                <span class="text-xs font-semibold px-2.5 py-0.5 rounded {{ $statusColor }}">
                                    {{ ucfirst($d->status) }}
                                </span>
                            </td>
                            <td class="px-2 md:px-4 py-2 border">
                                @if ($d->file)
                                    <a href="{{ asset('storage/' . $d->file) }}" target="_blank"
                                        class="text-blue-600 hover:underline">Lihat</a>
                                @else
                                    <span class="text-gray-500">Tidak ada</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center p-4 text-gray-500">Belum ada data dokumen akhir.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmDelete(type, id) {
            Swal.fire({
                title: 'Apakah kamu yakin?',
                text: "Data ini akan dihapus secara permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e3342f',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal',
                reverseButtons: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-' + type + '-form-' + id).submit();
                }
            })
        }
    </script>
@endpush
