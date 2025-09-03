@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Proposal</h2>

    <form action="{{ route('mahasiswa.proposals.update', $proposal->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Judul</label>
            <input type="text" name="judul" class="form-control" value="{{ $proposal->judul }}" required>
        </div>

        <div class="mb-3">
            <label>Deskripsi</label>
            <textarea name="deskripsi" class="form-control">{{ $proposal->deskripsi }}</textarea>
        </div>

        <div class="mb-3">
            <label>File Proposal (PDF)</label>
            <input type="file" name="file_proposal" class="form-control">
            @if($proposal->file_proposal)
                <p>File lama: <a href="{{ asset('storage/proposals/' . $proposal->file_proposal) }}" target="_blank">Lihat</a></p>
            @endif
        </div>

        <button type="submit" class="btn btn-warning">Update</button>
        <a href="{{ route('mahasiswa.proposals.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
