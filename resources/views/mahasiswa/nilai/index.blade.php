@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-4">Daftar Nilai Saya</h3>

    @if($nilai->count() > 0)
        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Komponen</th>
                        <th>Nilai</th>
                        <th>Keterangan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($nilai as $index => $n)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $n->komponen ?? '-' }}</td>
                            <td><strong>{{ $n->nilai ?? '-' }}</strong></td>
                            <td>{{ $n->keterangan ?? '-' }}</td>
                            <td>
                                <a href="{{ route('mahasiswa.nilai.show', $n->id) }}" 
                                   class="btn btn-sm btn-primary">
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="alert alert-info">
            Belum ada nilai yang tersedia.
        </div>
    @endif
</div>
@endsection
