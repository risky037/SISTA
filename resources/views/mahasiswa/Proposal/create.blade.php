@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Pengajuan Proposal Skripsi</h2>
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card">
        <div class="card-header">Formulir Pengajuan</div>
        <div class="card-body">
            <form action="{{ route('mahasiswa.proposal.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="judul_proposal" class="form-label">Judul Proposal</label>
                    <input type="text" class="form-control" id="judul_proposal" name="judul_proposal" required>
                </div>
                <div class="mb-3">
                    <label for="deskripsi_proposal" class="form-label">Deskripsi Singkat</label>
                    <textarea class="form-control" id="deskripsi_proposal" name="deskripsi_proposal" rows="4" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="file_proposal" class="form-label">Unggah Berkas Proposal (PDF/DOCX)</label>
                    <input type="file" class="form-control" id="file_proposal" name="file_proposal" required>
                </div>
                <button type="submit" class="btn btn-primary">Ajukan Proposal</button>
            </form>
        </div>
    </div>
</div>
@endsection