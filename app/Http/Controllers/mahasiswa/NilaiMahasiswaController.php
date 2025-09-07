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
        $nilai = Nilai::where('mahasiswa_id', Auth::id())->get();
        return view('mahasiswa.nilai.index', compact('nilai'));
    }

    /**
     * Tampilkan detail nilai tertentu.
     */
    public function show($id)
    {
        $nilai = Nilai::where('mahasiswa_id', Auth::id())
                      ->where('id', $id)
                      ->firstOrFail();

        return view('mahasiswa.nilai.show', compact('nilai'));
    }
}
