@extends('layouts.app')

@section('title', 'Daftar Proposal')

@section('content')
    <div class="flex justify-between items-center mb-4">
        <div>
            <h1 class="text-gray-800 text-xl font-semibold">@yield('title')</h1>
            <p class="text-gray-500 text-sm">Halaman untuk mengelola proposal skripsi Anda.</p>
        </div>
        <nav class="text-sm text-gray-500">
            <ol class="list-reset flex">
                <li><a href="{{ route('mahasiswa.dashboard') }}" class="hover:text-green-600">Home</a></li>
                <li><span class="mx-2">/</span></li>
                <li class="text-gray-700">Daftar Proposal</li>
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
            <a href="{{ route('mahasiswa.proposals.create') }}"
                class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                + Ajukan Proposal
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
                    @forelse($proposals as $proposal)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $proposal->created_at->format('d M Y') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $proposal->judul }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $proposal->deskripsi }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                {{ $proposal->dosen ? $proposal->dosen->name : '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <a href="{{ asset('storage/proposals/' . $proposal->file_proposal) }}" target="_blank"
                                    class="text-blue-600 hover:underline">Lihat</a>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                @php
                                    $statusClass = match ($proposal->status) {
                                        'pending' => 'bg-yellow-100 text-yellow-800',
                                        'diterima' => 'bg-green-100 text-green-800',
                                        'ditolak' => 'bg-red-100 text-red-800',
                                        default => 'bg-gray-100 text-gray-800',
                                    };
                                @endphp
                                <span
                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClass }}">
                                    {{ ucfirst($proposal->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                <a href="{{ route('mahasiswa.proposals.show', $proposal->id) }}"
                                    class="text-blue-600 hover:text-blue-900 underline mr-2">Detail</a>
                                @if ($proposal->status == 'pending' || $proposal->status == 'rejected')
                                    <a href="{{ route('mahasiswa.proposals.edit', $proposal->id) }}"
                                        class="text-yellow-600 hover:text-yellow-900 underline mr-2">Edit</a>
                                    <form action="{{ route('mahasiswa.proposals.destroy', $proposal->id) }}" method="POST"
                                        class="inline delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="text-red-600 hover:text-red-900 underline">Hapus</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center p-4 text-gray-500">Belum ada proposal yang diajukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('scripts')
    <script>document.addEventListener('DOMContentLoaded',function(){document.querySelectorAll('.delete-form').forEach(form=>{form.addEventListener('submit',function(event){event.preventDefault();Swal.fire({title:'Yakin hapus?',text:"Anda tidak akan bisa mengembalikan proposal ini!",icon:'warning',showCancelButton:!0,confirmButtonColor:'#d33',cancelButtonColor:'#3085d6',confirmButtonText:'Ya, hapus!',cancelButtonText:'Batal'}).then((result)=>{if(result.isConfirmed){form.submit()}})})})});</script>
@endpush
