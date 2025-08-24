@extends('layout.app')

@section('content')
<div class="p-6">
    <h2 class="text-xl font-bold mb-4">Tambah Proposal</h2>
    <form action="{{ route('admin.proposal.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label>Mahasiswa</label>
            <select name="mahasiswa_id" class="form-control">
                @foreach($mahasiswa as $m)
                    <option value="{{ $m->id }}">{{ $m->nama }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label>Dosen Pembimbing</label>
            <select name="dosen_pembimbing_id" class="form-control">
                @foreach($dosen as $d)
                    <option value="{{ $d->id }}">{{ $d->nama }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label>Judul</label>
            <input type="text" name="judul" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Deskripsi</label>
            <textarea name="deskripsi" class="form-control" rows="3"></textarea>
        </div>
        <div class="mb-3">
            <label>Upload File Proposal</label>
            <input type="file" name="file_proposal" class="form-control">
        </div>
        <button class="btn btn-success">Simpan</button>
    </form>
</div>
@endsection
