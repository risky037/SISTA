<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\DokumenAkhir;
use Illuminate\Http\Request;

class AdminDokumenAkhirController extends Controller
{
    public function index()
    {
        $mahasiswas = User::whereHas('dokumenAkhir')->with(['dokumenAkhir', 'dokumenAkhir.dosen'])->get();

        return view('admin.dokumen_akhir.index', compact('mahasiswas'));
    }

    public function show($id)
    {
        $mahasiswa = User::findOrFail($id);
        $uploads = DokumenAkhir::where('mahasiswa_id', $id)->get()->keyBy('bab');

        $chapters = [
            1 => 'Bab 1 - Pendahuluan',
            2 => 'Bab 2 - Tinjauan Pustaka',
            3 => 'Bab 3 - Metodologi Penelitian',
            4 => 'Bab 4 - Hasil dan Pembahasan',
            5 => 'Bab 5 - Penutup',
            6 => 'Daftar Pustaka & Lampiran'
        ];

        return view('admin.dokumen_akhir.show', compact('mahasiswa', 'uploads', 'chapters'));
    }
}
