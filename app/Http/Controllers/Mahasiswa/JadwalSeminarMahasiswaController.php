<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Bimbingan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JadwalSeminarMahasiswaController extends Controller
{
    /**
     * Menampilkan daftar jadwal seminar (bimbingan yang sudah disetujui) untuk mahasiswa.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $bimbingans = Bimbingan::with('dosen')
            ->where('mahasiswa_id', Auth::id())
            ->where('status', 'approved')
            ->orderBy('tanggal_bimbingan')
            ->orderBy('waktu_mulai')
            ->get();

        return view('mahasiswa.jadwal_seminar.index', compact('bimbingans'));
    }
}
