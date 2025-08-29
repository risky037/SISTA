@extends('layouts.app')

@section('content')
    <div class="p-6">
        <h2 class="text-2xl font-bold mb-4">Daftar Mahasiswa Bimbingan</h2>

        @if (session('success'))
            <div class="bg-green-100 text-green-800 p-3 rounded mb-3">
                {{ session('success') }}
            </div>
        @endif

        <table class="w-full border border-gray-200 rounded shadow">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-2 text-left">Mahasiswa</th>
                    <th class="p-2">Tanggal</th>
                    <th class="p-2">Jam</th>
                    <th class="p-2">Status</th>
                    <th class="p-2">Catatan Dosen</th>
                    <th class="p-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($bimbingans as $bimbingan)
                    <tr class="border-t">
                        <td class="p-2">{{ $bimbingan->mahasiswa->name }}</td>
                        <td class="p-2">{{ $bimbingan->tanggal_bimbingan }}</td>
                        <td class="p-2">{{ $bimbingan->waktu_mulai }} - {{ $bimbingan->waktu_selesai }}</td>
                        <td class="p-2">{{ ucfirst($bimbingan->status) }}</td>
                        <td class="p-2">{{ $bimbingan->catatan_dosen ?? '-' }}</td>
                        <td class="p-2 flex gap-2">
                            {{-- Form Update Status --}}
                            <form action="{{ route('dosen.bimbingan.updateStatus', $bimbingan->id) }}" method="POST">
                                @csrf
                                <select name="status" class="border rounded p-1 text-sm">
                                    <option value="pending" @selected($bimbingan->status == 'pending')>Pending</option>
                                    <option value="approved" @selected($bimbingan->status == 'approved')>Disetujui</option>
                                    <option value="rejected" @selected($bimbingan->status == 'rejected')>Ditolak</option>
                                </select>
                                <button type="submit"
                                    class="bg-blue-500 text-white px-2 py-1 rounded text-sm">Update</button>
                            </form>

                            {{-- Form Catatan --}}
                            <form action="{{ route('dosen.bimbingan.addCatatan', $bimbingan->id) }}" method="POST">
                                @csrf
                                <input type="text" name="catatan_dosen" placeholder="Tambahkan catatan"
                                    class="border rounded p-1 text-sm" required>
                                <button type="submit"
                                    class="bg-green-500 text-white px-2 py-1 rounded text-sm">Simpan</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
