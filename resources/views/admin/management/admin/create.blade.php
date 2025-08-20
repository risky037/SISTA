@extends('layout.app')

@section('title', 'Tambah Admin')

@section('content')
    <div class="p-6">
        <h2 class="text-xl font-bold mb-4">Tambah Admin</h2>

        @if ($errors->any())
            <div class="mb-4 bg-red-100 text-red-700 p-3 rounded">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>- {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.management.admin.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block">Nama</label>
                <input type="text" name="name" value="{{ old('name') }}" class="w-full border rounded p-2" required>
            </div>
            <div>
                <label class="block">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" class="w-full border rounded p-2" required>
            </div>
            <div>
                <label class="block">Password</label>
                <input type="password" name="password" class="w-full border rounded p-2" required>
            </div>
            <div class="flex gap-2">
                <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded">Simpan</button>
                <a href="{{ route('admin.management.admin.index') }}"
                    class="px-4 py-2 bg-gray-500 text-white rounded">Batal</a>
            </div>
        </form>
    </div>
@endsection
