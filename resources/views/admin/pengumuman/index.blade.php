@extends('layouts.app')

@section('title', 'Kelola Pengumuman')

@section('content')
    <div class="flex justify-between items-center mb-4">
        <div>
            <h1 class="text-gray-800 text-xl font-semibold">@yield('title')</h1>
            <p class="text-gray-500 text-sm">Halaman untuk mengelola data pengumuman, termasuk menambah, mengedit, dan
                menghapus pengumuman.</p>
        </div>
        <nav class="text-sm text-gray-500">
            <ol class="list-reset flex">
                <li><a href="{{ route('admin.dashboard') }}" class="hover:text-green-600">Home</a></li>
                <li><span class="mx-2">/</span></li>
                <li class="text-gray-700">@yield('title')</li>
            </ol>
        </nav>
    </div>

    <div class="p-6 bg-white rounded-lg shadow-md">
        <a href="{{ route('admin.pengumuman.create') }}"
            class="px-4 py-2 bg-green-600 text-white rounded-md mb-4 inline-block hover:bg-green-700 transition-colors">
            <i class="fas fa-plus mr-2"></i>Buat Pengumuman
        </a>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded-md my-4">
                <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded-md my-4">
                {!! session('error') !!}
            </div>
        @endif

        <div class="overflow-x-auto">
            <table class="table-auto w-full mt-4 border border-gray-200 rounded-lg min-w-[600px]">
                <thead class="bg-green-100 text-gray-700">
                    <tr>
                        <th class="px-2 md:px-4 py-2 border text-left">No</th>
                        <th class="px-2 md:px-4 py-2 border text-left">Nomor Surat</th>
                        <th class="px-2 md:px-4 py-2 border text-left">Tanggal</th>
                        <th class="px-2 md:px-4 py-2 border text-left">Informasi</th>
                        <th class="px-2 md:px-4 py-2 border text-left">File</th>
                        <th class="px-2 md:px-4 py-2 border text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pengumumans as $index => $item)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-2 md:px-4 py-2 border">
                                {{ $pengumumans->firstItem() + $index }}
                            </td>
                            <td class="px-2 md:px-4 py-2 border break-words max-w-[150px] font-medium">
                                {{ $item->nomor_surat }}
                            </td>
                            <td class="px-2 md:px-4 py-2 border whitespace-nowrap">
                                {{ $item->tanggal->format('d M Y') }}
                            </td>
                            <td class="px-2 md:px-4 py-2 border break-words max-w-[300px]">
                                {{ Str::limit($item->informasi, 100) }}
                            </td>
                            <td class="px-2 md:px-4 py-2 border">
                                <a href="{{ asset('storage/' . $item->file_path) }}" target="_blank"
                                    class="text-blue-600 hover:text-blue-800 hover:underline flex items-center gap-1 transition-colors">
                                    <i class="fas fa-file-pdf"></i> Lihat PDF
                                </a>
                            </td>
                            <td class="px-2 md:px-4 py-2 border">
                                <div class="flex flex-col md:flex-row gap-1 md:gap-2 items-center">
                                    <a href="{{ route('admin.pengumuman.edit', $item->id) }}"
                                        class="px-3 py-1 bg-blue-500 text-white rounded text-center hover:bg-blue-600 transition-colors w-full md:w-auto text-sm">
                                        Edit
                                    </a>

                                    <form action="{{ route('admin.pengumuman.destroy', $item->id) }}" method="POST"
                                        class="delete-form w-full md:w-auto">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600 transition-colors w-full md:w-auto text-sm">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center p-6 text-gray-500">
                                <div class="flex flex-col items-center justify-center">
                                    <i class="fas fa-inbox text-4xl mb-2 text-gray-300"></i>
                                    <p>Belum ada data pengumuman.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($pengumumans->hasPages())
            <div class="mt-4">
                {{ $pengumumans->links() }}
            </div>
        @endif
    </div>
@endsection
