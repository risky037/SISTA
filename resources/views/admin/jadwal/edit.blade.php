@extends('layouts.app')

@section('title', 'Edit Jadwal Sidang')

@section('content')
    <div class="flex justify-between items-center mb-4">
        <div>
            <h1 class="text-gray-800 text-xl font-semibold">@yield('title')</h1>
            <p class="text-gray-500 text-sm">Halaman untuk mengedit detail jadwal sidang.</p>
        </div>
        <nav class="text-sm text-gray-500">
            <ol class="list-reset flex">
                <li><a href="{{ route('admin.dashboard') }}" class="hover:text-green-600">Home</a></li>
                <li><span class="mx-2">/</span></li>
                <li><a href="{{ route('admin.jadwal.index') }}" class="hover:text-green-600">Manajemen Jadwal Sidang</a>
                </li>
                <li><span class="mx-2">/</span></li>
                <li class="text-gray-700">Edit</li>
            </ol>
        </nav>
    </div>
    <div class="p-6 bg-white rounded-lg shadow-md">
        <h2 class="text-xl font-bold mb-4">Edit Jadwal Sidang</h2>

        @if ($errors->any())
            <div class="mb-4 bg-red-100 text-red-700 p-3 rounded-md border border-red-400">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>- {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('admin.jadwal.update', ['jadwal' => $jadwal->id]) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-gray-700">Mahasiswa</label>
                <select name="mahasiswa_id"
                    class="w-full border rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-green-500 @error('mahasiswa_id') border-red-500 @enderror"
                    required>
                    @foreach ($mahasiswa as $m)
                        <option value="{{ $m->id }}"
                            {{ old('mahasiswa_id', $jadwal->mahasiswa_id) == $m->id ? 'selected' : '' }}>
                            {{ $m->name }}</option>
                    @endforeach
                </select>
                @error('mahasiswa_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-gray-700">Dosen</label>
                <select name="dosen_id"
                    class="w-full border rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-green-500 @error('dosen_id') border-red-500 @enderror"
                    required>
                    @foreach ($dosen as $d)
                        <option value="{{ $d->id }}"
                            {{ old('dosen_id', $jadwal->dosen_id) == $d->id ? 'selected' : '' }}>
                            {{ $d->name }}</option>
                    @endforeach
                </select>
                @error('dosen_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-gray-700">Tanggal</label>
                <input type="date" name="tanggal_bimbingan"
                    value="{{ old('tanggal_bimbingan', $jadwal->tanggal_bimbingan) }}"
                    class="w-full border rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-green-500 @error('tanggal_bimbingan') border-red-500 @enderror"
                    required>
                @error('tanggal_bimbingan')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-gray-700">Waktu Mulai</label>
                <input type="time" name="waktu_mulai" value="{{ old('waktu_mulai', $jadwal->waktu_mulai) }}"
                    class="w-full border rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-green-500 @error('waktu_mulai') border-red-500 @enderror"
                    required>
                @error('waktu_mulai')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-gray-700">Waktu Selesai</label>
                <input type="time" name="waktu_selesai" value="{{ old('waktu_selesai', $jadwal->waktu_selesai) }}"
                    class="w-full border rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-green-500 @error('waktu_selesai') border-red-500 @enderror"
                    required>
                @error('waktu_selesai')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-gray-700">Status</label>
                <select name="status"
                    class="w-full border rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-green-500 @error('status') border-red-500 @enderror">
                    <option value="pending" {{ old('status', $jadwal->status) == 'pending' ? 'selected' : '' }}>Pending
                    </option>
                    <option value="approved" {{ old('status', $jadwal->status) == 'approved' ? 'selected' : '' }}>Approved
                    </option>
                    <option value="rejected" {{ old('status', $jadwal->status) == 'rejected' ? 'selected' : '' }}>Rejected
                    </option>
                </select>
                @error('status')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex gap-2 pt-4">
                <button type="submit"
                    class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition-colors">Update</button>
                <a href="{{ route('admin.jadwal.index') }}"
                    class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 transition-colors">Batal</a>
            </div>
        </form>
    </div>
@endsection