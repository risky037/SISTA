@extends('layout.app')

@section('content')
    <div class="p-6">
        <h2 class="text-xl font-bold mb-4">Edit Proposal</h2>
        <form action="{{ route('admin.proposal.update', $proposal->id) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="mb-3">
                <label>Mahasiswa</label>
                <select name="mahasiswa_id" class="form-control">
                    @foreach ($mahasiswa as $m)
                        <option value="{{ $m->id }}" {{ $proposal->mahasiswa_id == $m->id ? 'selected' : '' }}>
                            {{ $m->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label>Dosen Pembimbing</label>
                <select name="dosen_pembimbing_id" class="form-control">
                    @foreach ($dosen as $d)
                        <option value="{{ $d->id }}"
                            {{ $proposal->dosen_pembimbing_id == $d->id ? 'selected' : '' }}>{{ $d->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label>Judul</label>
                <input type="text" name="judul" class="form-control" value="{{ $proposal->judul }}" required>
            </div>
            <div class="mb-3">
                <label>Deskripsi</label>
                <textarea name="deskripsi" class="form-control" rows="3">{{ $proposal->deskripsi }}</textarea>
            </div>
            <div class="mb-3">
                <label>Status</label>
                <select name="status" class="form-control">
                    <option value="pending" {{ $proposal->status == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="approved" {{ $proposal->status == 'approved' ? 'selected' : '' }}>Approved</option>
                    <option value="rejected" {{ $proposal->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                </select>
            </div>
            <div class="mb-3">
                <label>Catatan Dosen</label>
                <textarea name="catatan_dosen" class="form-control" rows="3">{{ $proposal->catatan_dosen }}</textarea>
            </div>
            <div class="mb-3">
                <label>File Proposal</label><br>
                @if ($proposal->file_proposal)
                    <a href="{{ asset('storage/' . $proposal->file_proposal) }}" target="_blank" class="text-blue-600">Lihat
                        File</a>
                @endif
                <input type="file" name="file_proposal" class="form-control mt-2">
            </div>
            <button class="btn btn-primary">Update</button>
        </form>
    </div>
@endsection
