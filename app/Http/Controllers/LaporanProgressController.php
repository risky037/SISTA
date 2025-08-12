<?php

namespace App\Http\Controllers;

use App\Models\LaporanProgress;
use Illuminate\Http\Request;

class LaporanProgressController extends Controller
{
    public function index()
    {
        $laporan = LaporanProgress::with(['mahasiswa', 'dosen'])->latest()->get();
        return view('laporan.index', compact('laporan'));
    }

    public function create()
    {
        return view('laporan.create');
    }

    public function store(Request $request)
    {
        // Nanti diisi validasi + simpan laporan
    }

    public function show(LaporanProgress $laporanProgress)
    {
        return view('laporan.show', compact('laporanProgress'));
    }

    public function edit(LaporanProgress $laporanProgress)
    {
        return view('laporan.edit', compact('laporanProgress'));
    }

    public function update(Request $request, LaporanProgress $laporanProgress)
    {
        // Nanti diisi update data
    }

    public function destroy(LaporanProgress $laporanProgress)
    {
        $laporanProgress->delete();
        return redirect()->route('laporan-progress.index');
    }
}