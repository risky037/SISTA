<?php

namespace App\Http\Controllers\Dosen;

use App\Helpers\NotifyHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Nilai;
use App\Models\DokumenAkhir;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class NilaiDokumenAkhirController extends Controller
{
    public function index()
    {
        $dosenId = Auth::id();

        $belumDinilai = DokumenAkhir::with('mahasiswa')
            ->where('dosen_pembimbing_id', $dosenId)
            ->where('status', '!=', 'pending')
            ->whereDoesntHave('nilai')
            ->get();

        $sudahDinilai = Nilai::with(['dokumenAkhir.mahasiswa'])
            ->where('dosen_id', $dosenId)
            ->whereNotNull('dokumen_akhir_id')
            ->latest()
            ->get();

        return view('dosen.nilai_dok_akhir.index', compact('belumDinilai', 'sudahDinilai'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'dokumen_akhir_id' => 'required|exists:dokumen_akhirs,id',
            'grade' => 'required|string',
            'keterangan' => 'nullable|string',
        ]);

        $dokumenAkhir = DokumenAkhir::findOrFail($request->dokumen_akhir_id);

        if ($dokumenAkhir->dosen_pembimbing_id != Auth::id()) {
            return back()->with('error', 'Anda tidak berhak menilai dokumen ini.');
        }

        if ($dokumenAkhir->status == 'pending') {
            return back()->with('error', 'Dokumen masih pending, harap review terlebih dahulu.');
        }

        $exists = Nilai::where('dokumen_akhir_id', $request->dokumen_akhir_id)->exists();
        if ($exists) {
            return back()->with('error', 'Dokumen akhir ini sudah memiliki nilai.');
        }

        Nilai::create([
            'dokumen_akhir_id' => $request->dokumen_akhir_id,
            'dosen_id' => Auth::id(),
            'grade' => $request->grade,
            'keterangan' => $request->keterangan,
        ]);

        NotifyHelper::send(
            $dokumenAkhir->mahasiswa_id,
            'Nilai Dokumen Akhir',
            'Dosen pembimbing telah memberikan nilai untuk dokumen akhir Anda.',
            route('mahasiswa.nilai.index')
        );

        return redirect()->back()->with('success', 'Nilai dokumen akhir berhasil disimpan.');
    }

    public function update(Request $request, $id)
    {
        $nilai = Nilai::findOrFail($id);

        if ($nilai->dosen_id != Auth::id()) {
            abort(403);
        }

        $request->validate([
            'grade' => 'required|string',
            'keterangan' => 'nullable|string',
        ]);

        $nilai->update([
            'grade' => $request->grade,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->back()->with('success', 'Nilai berhasil diperbarui.');
    }
}
