<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\Nilai;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NilaiDosenController extends Controller
{
    public function index()
    {
        $nilai = Nilai::with('mahasiswa')->get();
        return view('dosen.nilai.index', compact('nilai'));
    }

    public function create()
    {
        $mahasiswa = User::where('role', 'mahasiswa')->get();
        return view('dosen.nilai.create', compact('mahasiswa'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'mahasiswa_id' => 'required|exists:users,id',
            'judul_tugas_akhir' => 'required|string',
            'nilai' => 'required|integer|min:0|max:100',
            'keterangan' => 'nullable|string',
        ]);

        Nilai::create([
            'mahasiswa_id' => $request->mahasiswa_id,
            'dosen_id' => Auth::id(),
            'judul_tugas_akhir' => $request->judul_tugas_akhir,
            'nilai' => $request->nilai,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('dosen.nilai.index')->with('success', 'Nilai berhasil ditambahkan.');
    }
}
