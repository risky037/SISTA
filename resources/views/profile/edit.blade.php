@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')
    <div class="flex justify-between items-center mb-4">
        <div>
            <h1 class="text-gray-800 text-xl font-semibold">Profil Saya</h1>
            <p class="text-gray-500 text-sm">Kelola informasi akun Anda</p>
        </div>
        <nav class="text-sm text-gray-500">
            <ol class="list-reset flex">
                <li><a href="{{ route(auth()->user()->role . '.dashboard') }}" class="hover:text-green-600">Home</a></li>
                <li><span class="mx-2">/</span></li>
                <li class="text-gray-700">Profil</li>
            </ol>
        </nav>
    </div>

    {{-- Flash Message --}}
    @if (session('status') === 'profile-updated')
        <div class="bg-green-100 text-green-800 p-3 rounded-md border border-green-400 mb-4">
            Profil berhasil diperbarui.
        </div>
    @endif

    {{-- FORM --}}
    <div class="bg-white rounded shadow p-6 mb-6">
        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-4">
            @csrf
            @method('PATCH')

            {{-- Foto --}}
            <div class="text-center">
                <label class="block text-sm font-medium text-gray-700 mb-2">Foto Profil</label>
                @if ($user->foto)
                    <img id="preview-image" src="{{ asset('storage/' . $user->foto) }}" alt="Foto Profil"
                        class="w-32 h-32 rounded-full mx-auto mb-4 object-cover shadow-lg">
                @else
                    <img id="preview-image" src="#" alt="Foto Profil"
                        class="w-32 h-32 rounded-full mx-auto mb-4 object-cover shadow-lg hidden">
                    <div
                        class="w-32 h-32 rounded-full bg-gray-300 mx-auto mb-4 flex items-center justify-center text-white shadow-lg">
                        <span class="text-2xl">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                    </div>
                @endif
                <input type="file" name="foto" id="foto-input"
                    class="mt-2 text-sm bg-gray-50 border border-gray-300 rounded-md p-2 w-full cursor-pointer hover:bg-green-100 focus:outline-none block text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100">
                @error('foto')
                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            {{-- Nama --}}
            <div>
                <label class="block text-sm font-medium text-gray-700">Nama</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}"
                    class="w-full border rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-green-500 mt-2">
                @error('name')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            {{-- Email --}}
            <div>
                <label class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}"
                    class="w-full border rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-green-500 mt-2">
                @error('email')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            {{-- No HP --}}
            <div>
                <label class="block text-sm font-medium text-gray-700">No HP</label>
                <input type="text" name="no_hp" value="{{ old('no_hp', $user->no_hp) }}"
                    class="w-full border rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-green-500 mt-2">
                @error('no_hp')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            {{-- Field Khusus Berdasarkan Role --}}
            @if ($user->role === 'mahasiswa')
                {{-- NIM --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700">NIM</label>
                    <input type="text" name="NIM" value="{{ old('NIM', $user->NIM) }}"
                        class="w-full border rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-green-500 mt-2">
                    @error('NIM')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Prodi --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700">Program Studi</label>
                    <input type="text" name="prodi" value="{{ old('prodi', $user->prodi) }}"
                        class="w-full border rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-green-500 mt-2">
                    @error('prodi')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>
            @elseif ($user->role === 'dosen')
                {{-- NIDN --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700">NIDN</label>
                    <input type="text" name="NIDN" value="{{ old('NIDN', $user->NIDN) }}"
                        class="w-full border rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-green-500 mt-2">
                    @error('NIDN')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Bidang Keahlian --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700">Bidang Keahlian</label>
                    <input type="text" name="bidang_keahlian"
                        value="{{ old('bidang_keahlian', $user->bidang_keahlian) }}"
                        class="w-full border rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-green-500 mt-2">
                    @error('bidang_keahlian')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>
            @endif

            {{-- Tombol --}}
            <div>
                <button type="submit"
                    class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>

    <div class="space-y-6">
        @include('profile.partials.update-password-form')
    </div>
@endsection

@push('scripts')
    <script>
        document.getElementById('foto-input').addEventListener('change', function(e) {
            const file = e.target.files[0];
            const preview = document.getElementById('preview-image');
            const placeholder = preview.nextElementSibling;

            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    preview.src = event.target.result;
                    preview.classList.remove('hidden');
                    if (placeholder) {
                        placeholder.style.display = 'none';
                    }
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
@endpush
