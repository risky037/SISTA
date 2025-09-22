@extends('layouts.app')

@section('title', 'Dokumen Akhir')

@section('content')
    <div class="flex justify-between items-center mb-4">
        <div>
            <h1 class="text-gray-800 text-xl font-semibold">{{ $__env->yieldContent('title') }}</h1>
            <p class="text-gray-500 text-sm">Halaman untuk mengelola dokumen akhir Anda.</p>
        </div>
        <nav class="text-sm text-gray-500">
            <ol class="list-reset flex">
                <li><a href="{{ route('mahasiswa.dashboard') }}" class="hover:text-green-600">Home</a></li>
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

        <div class="flex justify-end mb-4">
            <a href="{{ route('mahasiswa.dokumen-akhir.create') }}"
                class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                + Upload Dokumen Baru
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="table-auto w-full mt-4 border border-gray-200 rounded-lg min-w-[600px]">
                <thead class="bg-green-100 text-gray-700">
                    <tr>
                        <th scope="col" class="px-2 md:px-4 py-2 border text-left">Tanggal Upload</th>
                        <th scope="col" class="px-2 md:px-4 py-2 border text-left">Judul</th>
                        <th scope="col" class="px-2 md:px-4 py-2 border text-left">Deskripsi</th>
                        <th scope="col" class="px-2 md:px-4 py-2 border text-left">Dosen</th>
                        <th scope="col" class="px-2 md:px-4 py-2 border text-left">File</th>
                        <th scope="col" class="px-2 md:px-4 py-2 border text-left">Status</th>
                        <th scope="col" class="px-2 md:px-4 py-2 border text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($dokumen as $d)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $d->created_at->format('d M Y') }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $d->judul }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $d->deskripsi }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $d->dosen->name ?? '-' }}</td>
                            <td class="px-6 py-4 text-sm">
                                <a href="{{ asset('storage/' . $d->file) }}" target="_blank"
                                    class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Lihat</a>
                            </td>
                            <td class="px-6 py-4 text-sm">
                                @if ($d->status == 'approved')
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 capitalize">diterima</span>
                                @elseif ($d->status == 'rejected')
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800 capitalize">ditolak</span>
                                @else
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800 capitalize">{{ ucfirst($d->status) }}</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                <a href="{{ route('mahasiswa.dokumen-akhir.show', $d->id) }}"
                                    class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 mr-2">Detail</a>
                                @if ($d->status == 'pending' || $d->status == 'rejected')
                                    <a href="{{ route('mahasiswa.dokumen-akhir.edit', $d->id) }}"
                                        class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 mr-2">Edit</a>
                                    <form action="{{ route('mahasiswa.dokumen-akhir.destroy', $d->id) }}" method="POST"
                                        class="inline delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">Hapus</button>
                                    </form>
                                @endif
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center p-4 text-gray-500">Belum ada dokumen yang diupload.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('scripts')
    <script>document.addEventListener('DOMContentLoaded',function(){document.querySelectorAll('.delete-form').forEach(form=>{form.addEventListener('submit',function(event){event.preventDefault();Swal.fire({title:'Yakin hapus?',text:"Anda tidak akan bisa mengembalikan dokumen ini!",icon:'warning',showCancelButton:!0,confirmButtonColor:'#d33',cancelButtonColor:'#3085d6',confirmButtonText:'Ya, hapus!',cancelButtonText:'Batal'}).then((result)=>{if(result.isConfirmed){form.submit()}})})})});</script>
@endpush
