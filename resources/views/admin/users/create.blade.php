@extends('layout.app')

@section('content')
    <div class="container">
        <h2>Tambah User</h2>

        <form action="{{ route('users.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label>Nama</label>
                <input type="text" name="nama" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>No HP</label>
                <input type="text" name="no_hp" class="form-control">
            </div>
            <div class="mb-3">
                <label>Role</label>
                <select name="role" class="form-control" required>
                    <option value="admin">Admin</option>
                    <option value="mahasiswa">Mahasiswa</option>
                    <option value="dosen">Dosen</option>
                </select>
            </div>
            <div class="mb-3">
                <label>NIM (Mahasiswa)</label>
                <input type="text" name="NIM" class="form-control">
            </div>
            <div class="mb-3">
                <label>Prodi (Mahasiswa)</label>
                <input type="text" name="prodi" class="form-control">
            </div>
            <div class="mb-3">
                <label>NIDN (Dosen)</label>
                <input type="text" name="NIDN" class="form-control">
            </div>
            <div class="mb-3">
                <label>Bidang Keahlian (Dosen)</label>
                <input type="text" name="bidang_keahlian" class="form-control">
            </div>
            <button class="btn btn-success">Simpan</button>
            <a href="{{ route('users.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
@endsection
