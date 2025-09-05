@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Upload Dokumen Akhir</h2>

    {{-- Pesan sukses --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Pesan error --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Terjadi kesalahan!</strong>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Form Upload --}}
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('mahasiswa.dokumen.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group mb-3">
                    <label for="judul">Judul Dokumen</label>
                    <input type="text" name="judul" id="judul" class="form-control" required>
                </div>
                <div class="form-group mb-3">
                    <label for="file">File Dokumen (PDF/DOC/DOCX)</label>
                    <input type="file" name="file" id="file" class="form-control" accept=".pdf,.doc,.docx" required>
                </div>
                <button type="submit" class="btn btn-primary">Upload</button>
            </form>
        </div>
    </div>

    {{-- Daftar Dokumen --}}
    <h4>Daftar Dokumen Anda</h4>
    <div class="card">
        <div class="card-body p-0">
            <table class="table table-striped mb-0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Judul</th>
                        <th>File</th>
                        <th>Upload</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($dokumen as $key => $item)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $item->formatted_judul }}</td>
                            <td>
                                <a href="{{ $item->file_url }}" target="_blank" class="btn btn-sm btn-success">
                                    Lihat File
                                </a>
                            </td>
                            <td>{{ $item->created_at->format('d M Y H:i') }}</td>
                            <td>
                                <form action="{{ route('mahasiswa.dokumen.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin hapus dokumen ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">Belum ada dokumen diupload.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
