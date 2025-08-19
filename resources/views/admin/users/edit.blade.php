@extends('layout.app')

@section('content')
    <div class="container">
        <h2>Edit User</h2>

        <form action="{{ route('users.update', $user) }}" method="POST">
            @csrf @method('PUT')
            <div class="mb-3">
                <label>Nama</label>
                <input type="text" name="nama" class="form-control" value="{{ $user->nama }}" required>
            </div>
            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
            </div>
            <div class="mb-3">
                <label>Password (kosongkan jika tidak diganti)</label>
                <input type="password" name="password" class="form-control">
            </div>
            <div class="mb-3">
                <label>No HP</label>
                <input type="text" name="no_hp" class="form-control" value="{{ $user->no_hp }}">
            </div>
            <div class="mb-3">
                <label>Role</label>
                <select name="role" class="form-control" required>
                    <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="mahasiswa" {{ $user->role == 'mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                    <option value="dosen" {{ $user->role == 'dosen' ? 'selected' : '' }}>Dosen</option>
                </select>
            </div>
            <div class="mb-3">
                <label>NIM (Mahasiswa)</label>
                <input type="text" name="NIM" class="form-control" value="{{ $user->NIM }}">
            </div>
            <div class="mb-3">
                <label>Prodi (Mahasiswa)</label>
                <input type="text" name="prodi" class="form-control" value="{{ $user->prodi }}">
            </div>
            <div class="mb-3">
                <label>NIDN (Dosen)</label>
                <input type="text" name="NIDN" class="form-control" value="{{ $user->NIDN }}">
            </div>
            <div class="mb-3">
                <label>Bidang Keahlian (Dosen)</label>
                <input type="text" name="bidang_keahlian" class="form-control" value="{{ $user->bidang_keahlian }}">
            </div>
            <button class="btn btn-success">Update</button>
            <a href="{{ route('users.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
@endsection
