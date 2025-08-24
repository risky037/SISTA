@extends('layout.app')

@section('title', 'Manajemen Proposal')

@section('content')
    <div class="flex justify-between items-center mb-4">
        <div>
            <h1 class="text-gray-800 text-xl font-semibold">@yield('title')</h1>
            <p class="text-gray-500 text-sm">Halaman untuk mengelola data proposal sidang.</p>
        </div>
        <nav class="text-sm text-gray-500">
            <ol class="list-reset flex">
                <li><a href="{{ route('admin.dashboard') }}" class="hover:text-green-600">Home</a></li>
                <li><span class="mx-2">/</span></li>
                <li class="text-gray-700">Manajemen Proposal</li>
            </ol>
        </nav>
    </div>
    <div class="p-6 bg-white rounded-lg shadow-md">
        <a href="{{ route('admin.proposal.create') }}"
            class="px-4 py-2 bg-green-600 text-white rounded-md mb-4 inline-block hover:bg-green-700 transition-colors">
            <i class="fas fa-plus mr-2"></i>Tambah Proposal
        </a>

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
                        <th class="px-2 md:px-4 py-2 border text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($proposals as $p)
                        @php
                            $statusColor = match ($p->status) {
                                'pending' => 'bg-yellow-200 text-yellow-800',
                                'approved' => 'bg-green-200 text-green-800',
                                default => 'bg-red-200 text-red-800',
                            };
                        @endphp
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-2 md:px-4 py-2 border break-words max-w-[150px]">{{ $p->mahasiswa->name }}</td>
                            <td class="px-2 md:px-4 py-2 border break-words max-w-[150px]">{{ $p->dosen->name }}</td>
                            <td class="px-2 md:px-4 py-2 border break-words max-w-[300px]">{{ $p->judul }}</td>
                            <td class="px-2 md:px-4 py-2 border">
                                <span class="text-xs font-semibold px-2.5 py-0.5 rounded {{ $statusColor }}">
                                    {{ ucfirst($p->status) }}
                                </span>
                            </td>
                            <td class="px-2 md:px-4 py-2 border">
                                @if ($p->file_proposal)
                                    <a href="{{ asset('storage/' . $p->file_proposal) }}" target="_blank"
                                        class="text-blue-600 hover:underline">Lihat</a>
                                @else
                                    <span class="text-gray-500">Tidak ada</span>
                                @endif
                            </td>
                            <td class="px-2 md:px-4 py-2 border flex flex-col md:flex-row gap-1 md:gap-2 items-center">
                                <a href="{{ route('admin.proposal.edit', $p->id) }}"
                                    class="px-3 py-1 bg-blue-500 text-white rounded text-center hover:bg-blue-600 transition-colors">Edit</a>
                                <form action="{{ route('admin.proposal.destroy', $p->id) }}" method="POST"
                                    onsubmit="return confirm('Yakin ingin menghapus proposal ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                        class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600 transition-colors">Hapus</button>
                                </form>
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

        @if ($proposals->hasPages())
            <div class="mt-4">
                {{ $proposals->links() }}
            </div>
        @endif
    </div>
@endsection
