@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Ajukan Proposal Baru</h2>

    <form action="{{ route('mahasiswa.proposals.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label>Judul</label>
            <input type="text" name="judul" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Deskripsi</label>
            <textarea name="deskripsi" class="form-control"></textarea>
        </div>

        <div class="mb-3">
            <label>File Proposal (PDF)</label>
            <input type="file" name="file_proposal" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="{{ route('mahasiswa.proposals.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
