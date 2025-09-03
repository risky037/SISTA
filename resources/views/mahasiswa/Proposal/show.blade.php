@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Detail Proposal</h2>

    <div class="mb-3">
        <strong>Judul:</strong> {{ $proposal->judul }}
    </div>

    <div class="mb-3">
        <strong>Deskripsi:</strong> {{ $proposal->deskripsi }}
    </div>

    <div class="mb-3">
        <strong>File Proposal:</strong>
        <a href="{{ asset('storage/proposals/' . $proposal->file_proposal) }}" target="_blank">Download</a>
    </div>

    <div class="mb-3">
        <strong>Status:</strong> {{ ucfirst($proposal->status) }}
    </div>

    <a href="{{ route('mahasiswa.proposals.index') }}" class="btn btn-secondary">Kembali</a>
</div>
@endsection
