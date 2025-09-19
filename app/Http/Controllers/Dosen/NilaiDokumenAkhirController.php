<?php

namespace App\Http\Controllers\Dosen;

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
        $nilai = Nilai::with('dokumenAkhir.mahasiswa')->whereNotNull('dokumen_akhir_id')->get();

        $dokumenBelumDinilai = DokumenAkhir::where('dosen_pembimbing_id', auth()->id())
            ->where('status', '!=', 'pending')
            ->whereDoesntHave('nilai')
            ->get();

        $jumlahDokumenPending = DokumenAkhir::where('dosen_pembimbing_id', auth()->id())
            ->where('status', 'pending')
            ->count();

        return view('dosen.nilai_dok_akhir.index', compact('nilai', 'dokumenBelumDinilai', 'jumlahDokumenPending'));
    }

    public function create()
    {
        $dokumenAkhir = DokumenAkhir::where('dosen_pembimbing_id', Auth::id())->get();
        return view('dosen.nilai_dok_akhir.create', compact('dokumenAkhir'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'dokumen_akhir_id' => 'required|exists:dokumen_akhirs,id',
            'grade' => 'required|string',
            'keterangan' => 'nullable|string',
        ]);

        $dokumenAkhir = DokumenAkhir::findOrFail($request->dokumen_akhir_id);

        if ($dokumenAkhir->status == 'pending') {
            return redirect()->back()->withErrors(['dokumen_akhir_id' => 'Dokumen akhir ini masih pending, harap review terlebih dahulu.'])->withInput();
        }

        $exists = Nilai::where('dokumen_akhir_id', $request->dokumen_akhir_id)->exists();
        if ($exists) {
            return redirect()->back()->withErrors(['dokumen_akhir_id' => 'Dokumen akhir ini sudah memiliki nilai.'])->withInput();
        }

        Nilai::create([
            'dokumen_akhir_id' => $request->dokumen_akhir_id,
            'dosen_id' => Auth::id(),
            'grade' => $request->grade,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('dosen.nilai-dokumen-akhir.index')->with('success', 'Nilai dokumen akhir berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $nilai = Nilai::findOrFail($id);
        $dokumenAkhir = DokumenAkhir::where('dosen_pembimbing_id', Auth::id())->get();

        return view('dosen.nilai_dok_akhir.edit', compact('nilai', 'dokumenAkhir'));
    }

    public function update(Request $request, $id)
    {
        $nilai = Nilai::findOrFail($id);

        $request->validate([
            'dokumen_akhir_id' => [
                'required',
                'exists:dokumen_akhirs,id',
                Rule::unique('nilais')->ignore($nilai->id)->whereNotNull('dokumen_akhir_id'),
            ],
            'grade' => 'required|string',
            'keterangan' => 'nullable|string',
        ]);

        $nilai->update([
            'dokumen_akhir_id' => $request->dokumen_akhir_id,
            'grade' => $request->grade,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('dosen.nilai-dokumen-akhir.index')->with('success', 'Nilai dokumen akhir berhasil diperbarui.');
    }
}
