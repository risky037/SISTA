<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Nilai;
use Illuminate\Support\Facades\Auth;

class NilaiMahasiswaController extends Controller
{
    /**
     * Tampilkan daftar semua nilai milik mahasiswa yang login.
     */
    public function index()
    {
        // Ambil nilai berdasarkan proposal mahasiswa yang sedang dibimbing oleh dosen yang sesuai dengan yang login
        $nilai = Nilai::with('proposal') // Pastikan 'proposal' di-relasikan dengan baik pada model Nilai
            ->whereHas('proposal', function ($query) {
                $query->where('mahasiswa_id', Auth::id()); // Pastikan mahasiswa yang login yang dibimbing oleh dosen
            })
            ->get();
        return view('mahasiswa.nilai.index', compact('nilai'));
    }

    /**
     * Tampilkan detail nilai tertentu.
     */
    public function show($id)
    {
        $nilai = Nilai::where('id', $id)
            ->whereHas('proposal', function ($query) {
                $query->where('mahasiswa_id', Auth::id()); // Pastikan hanya nilai milik mahasiswa yang login
            })
            ->firstOrFail();

        return view('mahasiswa.nilai.show', compact('nilai'));
    }
}
