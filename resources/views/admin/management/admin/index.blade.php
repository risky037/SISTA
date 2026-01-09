@extends('layouts.app')

@section('title', 'Manajemen Admin')

@section('content')

    <div class="flex justify-between items-center mb-4">
        <div>
            <h1 class="text-gray-800 text-xl font-semibold">@yield('title')</h1>
            <p class="text-gray-500 text-sm">Halaman untuk mengelola data admin, termasuk menambah, mengedit, dan menghapus
                akun admin.</p>
        </div>
        <nav class="text-sm text-gray-500">
            <ol class="list-reset flex">
                <li><a href="{{ route('admin.dashboard') }}" class="hover:text-green-600">Home</a></li>
                <li><span class="mx-2">/</span></li>
                <li class="text-gray-700">Manajemen Admin</li>
            </ol>
        </nav>
    </div>
    <div class="p-6 bg-white rounded-lg shadow-md">
        <a href="{{ route('admin.management.admin.create') }}"
            class="px-4 py-2 bg-green-600 text-white rounded-md mb-4 inline-block hover:bg-green-700 transition-colors">
            <i class="fas fa-plus mr-2"></i>Tambah
            Admin</a>
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded my-4">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded my-4">
                {{ session('error') }}
            </div>
        @endif
        <div class="overflow-x-auto">
            <table class="table-auto w-full mt-4 border border-gray-200 rounded-lg min-w-[800px]">
                <thead class="bg-green-100">
                    <tr>
                        <th class="px-2 md:px-4 py-1 md:py-2 border text-left">Nama</th>
                        <th class="px-2 md:px-4 py-1 md:py-2 border text-left">Email</th>
                        <th class="px-2 md:px-4 py-1 md:py-2 border text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($admins as $admin)
                        <tr>
                            <td class="px-2 md:px-4 py-1 md:py-2 border break-words max-w-[200px]">{{ $admin->name }}</td>
                            <td class="px-2 md:px-4 py-1 md:py-2 border break-words max-w-[200px]">{{ $admin->email }}</td>
                            <td class="px-2 md:px-4 py-1 md:py-2 border flex flex-col md:flex-row gap-1 md:gap-2">
                                <a href="{{ route('admin.management.admin.edit', $admin->id) }}"
                                    class="px-3 py-1 bg-blue-500 text-white rounded text-center">Edit</a>
                                @php
                                    $isMainAdmin = $admin->id === 1;
                                    $isSelf = $admin->id === auth()->id();
                                @endphp

                                @if ($isMainAdmin || $isSelf)
                                    <button class="px-3 py-1 bg-gray-400 text-white rounded opacity-50 cursor-not-allowed"
                                        disabled>Hapus</button>
                                @else
                                    <form action="{{ route('admin.management.admin.destroy', $admin->id) }}" method="POST"
                                        class="delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="px-3 py-1 bg-red-500 text-white rounded">Hapus</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center p-4">Belum ada admin</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $admins->links() }}
        </div>
    </div>
@endsection
