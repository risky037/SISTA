<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\DokumenAkhir;

class DokumenAkhirDosenController extends Controller
{
    public function index()
    {
        $dokumen = DokumenAkhir::with('mahasiswa')
            ->where('dosen_pembimbing_id', Auth::id())
            ->latest()
            ->get();

        return view('dosen.dokumen_akhir.index', compact('dokumen'));
    }

    public function show($id)
    {
        $dok = DokumenAkhir::with('mahasiswa')
            ->where('dosen_pembimbing_id', Auth::id())
            ->where('id', $id)
            ->firstOrFail();

        return view('dosen.dokumen_akhir.show', compact('dok'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected',
            'catatan_dosen' => 'nullable|string',
        ]);

        $dok = DokumenAkhir::where('dosen_pembimbing_id', Auth::id())
            ->where('id', $id)
            ->firstOrFail();

        $dok->status = $request->status;
        $dok->catatan_dosen = $request->catatan_dosen;
        $dok->save();

        return redirect()
            ->route('dosen.dokumen-akhir.index')
            ->with('success', 'Status dokumen akhir berhasil diperbarui. <a href="' . route('dosen.nilai-dokumen-akhir.index') . '" class="underline text-green-700 hover:text-green-900 font-semibold">Beri nilai sekarang!</a>');
    }
}
