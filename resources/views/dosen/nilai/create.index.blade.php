@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Tambah Nilai Mahasiswa</h3>
    <form action="{{ route('dosen.nilai.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Mahasiswa</label>
            <select name="mahasiswa_id" class="form-control" required>
                <option value="">-- Pilih Mahasiswa --</option>
                @foreach($mahasiswa as $mhs)
                <option value="{{ $mhs->id }}">{{ $mhs->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label>Judul Tugas Akhir</label>
            <input type="text" name="judul_tugas_akhir" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Nilai</label>
            <input type="number" name="nilai" class="form-control" required min="0" max="100">
        </div>
        <div class="mb-3">
            <label>Keterangan</label>
            <textarea name="keterangan" class="form-control"></textarea>
        </div>
        <button type="submit" class="btn btn-success">Simpan</button>
    </form>
</div>
@endsection
