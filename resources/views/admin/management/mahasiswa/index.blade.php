@extends('layouts.app')

@section('title', 'Manajemen Mahasiswa')

@section('content')
    <div class="flex justify-between items-center mb-4">
        <div>
            <h1 class="text-gray-800 text-xl font-semibold">@yield('title')</h1>
            <p class="text-gray-500 text-sm">Halaman untuk mengelola data mahasiswa, termasuk menambah, mengedit, dan
                menghapus
                akun mahasiswa.</p>
        </div>
        <nav class="text-sm text-gray-500">
            <ol class="list-reset flex">
                <li><a href="{{ route('admin.dashboard') }}" class="hover:text-green-600">Home</a></li>
                <li><span class="mx-2">/</span></li>
                <li class="text-gray-700">Manajemen Mahasiswa</li>
            </ol>
        </nav>
    </div>
    <div class="p-6 bg-white rounded-lg shadow-md">
        <a href="{{ route('admin.management.mahasiswa.create') }}"
            class="px-4 py-2 bg-green-600 text-white rounded-md mb-4 inline-block hover:bg-green-700 transition-colors">
            <i class="fas fa-plus mr-2"></i>Tambah Mahasiswa
        </a>
        <button x-data @click="$dispatch('open-modal')"
            class="px-4 py-2 bg-blue-600 text-white rounded-md mb-4 inline-block hover:bg-blue-700 transition-colors">
            <i class="fas fa-upload mr-2"></i>Import Data
        </button>

        <div x-data="{ open: false }" @open-modal.window="open = true" x-cloak x-show="open"
            x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
            class="fixed inset-0 bg-gray-800 bg-opacity-50 flex justify-center items-center p-4 z-50">

            <div @click.away="open = false" x-show="open" x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95"
                class="bg-white p-6 rounded-2xl shadow-2xl max-w-lg w-full transform transition-all">

                <div class="flex justify-between items-center mb-4 border-b pb-2">
                    <h2 class="text-2xl font-bold text-gray-800">Import Data Mahasiswa</h2>
                    <button @click="open = false" class="text-gray-400 hover:text-gray-600 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                            </path>
                        </svg>
                    </button>
                </div>
                <form action="{{ route('admin.management.mahasiswa.import') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="mb-6">
                        <label for="file" class="block text-gray-700 font-medium mb-2">Pilih File Excel (.xlsx,
                            .xls)</label>
                        <input type="file" name="file" accept=".xlsx,.xls"
                            class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100 transition-colors border border-gray-300 rounded-md p-1"
                            required>
                    </div>
                    <div class="flex justify-end space-x-2">
                        <button type="button" @click="open = false"
                            class="px-6 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition-colors">
                            Batal
                        </button>
                        <button type="submit"
                            class="px-6 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition-colors">
                            <i class="fas fa-upload mr-2"></i>Import Data
                        </button>
                    </div>
                </form>
            </div>
        </div>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded-md my-4">
                {{ session('success') }}
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
                        <th class="px-2 md:px-4 py-2 border text-left">Foto</th>
                        <th class="px-2 md:px-4 py-2 border text-left">Nama</th>
                        <th class="px-2 md:px-4 py-2 border text-left">Email</th>
                        <th class="px-2 md:px-4 py-2 border text-left">NIM</th>
                        <th class="px-2 md:px-4 py-2 border text-left">Prodi</th>
                        <th class="px-2 md:px-4 py-2 border text-left">No HP</th>
                        <th class="px-2 md:px-4 py-2 border text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($mahasiswa as $m)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-2 md:px-4 py-2 border">
                                @if ($m->foto)
                                    <img src="{{ asset('storage/' . $m->foto) }}" alt="Foto Mahasiswa" width="50"
                                        class="rounded-full object-cover w-12 h-12">
                                @else
                                    <img src="{{ asset('img/defaultpp.jpg') }}" alt="Foto Default" width="50"
                                        class="rounded-full object-cover w-12 h-12">
                                @endif
                            </td>
                            <td class="px-2 md:px-4 py-2 border break-words max-w-[200px]">{{ $m->name }}</td>
                            <td class="px-2 md:px-4 py-2 border break-words max-w-[200px]">{{ $m->email }}</td>
                            <td class="px-2 md:px-4 py-2 border break-words max-w-[100px]">{{ $m->NIM }}</td>
                            <td class="px-2 md:px-4 py-2 border break-words max-w-[150px]">{{ $m->prodi }}</td>
                            <td class="px-2 md:px-4 py-2 border break-words max-w-[120px]">{{ $m->no_hp ?? '-'}}</td>
                            <td class="px-2 md:px-4 py-2 border flex flex-col md:flex-row gap-1 md:gap-2 items-center">
                                <a href="{{ route('admin.management.mahasiswa.edit', $m->id) }}"
                                    class="px-3 py-1 bg-blue-500 text-white rounded text-center hover:bg-blue-600 transition-colors">Edit</a>
                                <form action="{{ route('admin.management.mahasiswa.destroy', $m->id) }}" method="POST"
                                    class="delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600 transition-colors">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center p-4 text-gray-500">Belum ada data mahasiswa.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($mahasiswa->hasPages())
            <div class="mt-4">
                {{ $mahasiswa->links() }}
            </div>
        @endif
    </div>
@endsection

@push('styles')
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script><script>document.querySelectorAll('.delete-form').forEach(form=>{form.addEventListener('submit',function(e){e.preventDefault();Swal.fire({title:'Apakah kamu yakin?',text:"Data mahasiswa ini akan dihapus permanen!",icon:'warning',showCancelButton:!0,confirmButtonColor:'#d33',cancelButtonColor:'#3085d6',confirmButtonText:'Ya, hapus!',cancelButtonText:'Batal'}).then((result)=>{if(result.isConfirmed){form.submit()}})})});</script>
@endpush
