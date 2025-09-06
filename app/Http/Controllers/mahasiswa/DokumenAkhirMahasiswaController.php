<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\DokumenAkhir;

class DokumenAkhirMahasiswaController extends Controller
{
    /**
     * Tampilkan daftar dokumen akhir milik mahasiswa yang login.
     */
    public function index()
    {
        $dokumen = DokumenAkhir::own()->latest()->get();
        return view('mahasiswa.dokumen.index', compact('dokumen'));
    }

    /**
     * Form upload dokumen akhir.
     */
    public function create()
    {
        $dokumen = DokumenAkhir::own()->latest()->get();
        return view('mahasiswa.dokumen.create', compact('dokumen'));
    }

    /**
     * Simpan dokumen akhir ke database & storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'file' => 'required|mimes:pdf,doc,docx|max:5120', // max 5MB
        ]);

        $path = $request->file('file')->store('dokumen_akhir', 'public');

        DokumenAkhir::create([
            'mahasiswa_id' => Auth::id(),
            'judul' => $request->judul,
            'file' => $path,
        ]);

        return redirect()->route('mahasiswa.dokumen-akhir.index')
            ->with('success', 'Dokumen berhasil diupload.');
    }

    /**
     * Tampilkan detail dokumen.
     */
    public function show($id)
    {
        $dokumen = DokumenAkhir::where('mahasiswa_id', Auth::id())->findOrFail($id);

        return view('mahasiswa.dokumen.show', compact('dokumen'));
    }

    /**
     * Form edit dokumen.
     */
    public function edit($id)
    {
        $dokumen = DokumenAkhir::where('mahasiswa_id', Auth::id())->findOrFail($id);

        return view('mahasiswa.dokumen.edit', compact('dokumen'));
    }

    /**
     * Update dokumen akhir.
     */
    public function update(Request $request, $id)
    {
        $dokumen = DokumenAkhir::where('mahasiswa_id', Auth::id())->findOrFail($id);

        $request->validate([
            'judul' => 'required|string|max:255',
            'file' => 'nullable|mimes:pdf,doc,docx|max:5120',
        ]);

        $dokumen->judul = $request->judul;

        if ($request->hasFile('file')) {
            // hapus file lama
            if ($dokumen->file && Storage::disk('public')->exists($dokumen->file)) {
                Storage::disk('public')->delete($dokumen->file);
            }

            $path = $request->file('file')->store('dokumen_akhir', 'public');
            $dokumen->file = $path;
        }

        $dokumen->save();

        return redirect()->route('mahasiswa.dokumen-akhir.index')
            ->with('success', 'Dokumen berhasil diperbarui.');
    }

    /**
     * Hapus dokumen akhir.
     */
    public function destroy($id)
    {
        $dokumen = DokumenAkhir::where('mahasiswa_id', Auth::id())->findOrFail($id);

        if ($dokumen->file && Storage::disk('public')->exists($dokumen->file)) {
            Storage::disk('public')->delete($dokumen->file);
        }

        $dokumen->delete();

        return back()->with('success', 'Dokumen berhasil dihapus.');
    }
}
