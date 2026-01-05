<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Nilai;
use App\Models\DokumenAkhir;
use Illuminate\Support\Facades\Auth;

class NilaiMahasiswaController extends Controller
{
    public function index()
    {
        $nilaiProposal = Nilai::with('proposal')
            ->whereHas('proposal', function ($q) {
                $q->where('mahasiswa_id', Auth::id());
            })
            ->get();

        $nilaiDokumenAkhir = Nilai::with('dokumenAkhir')
            ->whereHas('dokumenAkhir', function ($q) {
                $q->where('mahasiswa_id', Auth::id());
            })
            ->get();

        return view('mahasiswa.nilai.index', compact('nilaiProposal', 'nilaiDokumenAkhir'));
    }

    public function show($id)
    {
        $nilai = Nilai::with(['proposal', 'dokumenAkhir'])
            ->where('id', $id)
            ->where(function ($query) {
                $query->whereHas('proposal', function ($q) {
                    $q->where('mahasiswa_id', Auth::id());
                })->orWhereHas('dokumenAkhir', function ($q) {
                    $q->where('mahasiswa_id', Auth::id());
                });
            })
            ->firstOrFail();

        return view('mahasiswa.nilai.show', compact('nilai'));
    }
}
