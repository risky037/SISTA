@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Daftar Proposal</h2>

    {{-- Notifikasi sukses --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('mahasiswa.proposals.create') }}" class="btn btn-primary mb-3">+ Ajukan Proposal</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Judul</th>
                <th>Deskripsi</th>
                <th>File</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($proposals as $proposal)
                <tr>
                    <td>{{ $proposal->judul }}</td>
                    <td>{{ $proposal->deskripsi }}</td>
                    <td>
                        <a href="{{ asset('storage/proposals/' . $proposal->file_proposal) }}" target="_blank">Lihat</a>
                    </td>
                    <td>{{ ucfirst($proposal->status) }}</td>
                    <td>
                        <a href="{{ route('mahasiswa.proposals.show', $proposal->id) }}" class="btn btn-info btn-sm">Detail</a>
                        <a href="{{ route('mahasiswa.proposals.edit', $proposal->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('mahasiswa.proposals.destroy', $proposal->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center">Belum ada proposal</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
