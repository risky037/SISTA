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
     * Form untuk upload dokumen akhir (opsional, jika index sudah ada form upload, bisa dilewati).
     */
    public function create()
    {
        return view('mahasiswa.dokumen.create');
    }

    /**
     * Simpan dokumen akhir ke database dan storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'file'  => 'required|mimes:pdf,doc,docx|max:5120' // max 5MB
        ]);

        // Simpan file ke storage/app/public/dokumen_akhir
        $path = $request->file('file')->store('dokumen_akhir', 'public');

        DokumenAkhir::create([
            'mahasiswa_id' => Auth::id(),
            'judul'        => $request->judul,
            'file'         => $path,
        ]);

        return redirect()->route('mahasiswa.dokumen.index')
            ->with('success', 'Dokumen berhasil diupload.');
    }

    /**
     * Hapus dokumen akhir.
     */
    public function destroy($id)
    {
        $dokumen = DokumenAkhir::where('mahasiswa_id', Auth::id())->findOrFail($id);

        // Hapus file fisik
        if ($dokumen->file && Storage::disk('public')->exists($dokumen->file)) {
            Storage::disk('public')->delete($dokumen->file);
        }

        // Hapus record dari database
        $dokumen->delete();

        return back()->with('success', 'Dokumen berhasil dihapus.');
    }
}
