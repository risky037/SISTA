<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Helpers\NotifyHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\DokumenAkhir;
use App\Models\User;

class DokumenAkhirMahasiswaController extends Controller
{
    /**
     * Tampilkan daftar dokumen akhir milik mahasiswa yang login.
     */
    public function index()
    {
        $uploads = DokumenAkhir::own()->get()->keyBy('bab');

        $chapters = [
            1 => 'Bab 1 - Pendahuluan',
            2 => 'Bab 2 - Tinjauan Pustaka',
            3 => 'Bab 3 - Metodologi Penelitian',
            4 => 'Bab 4 - Hasil dan Pembahasan',
            5 => 'Bab 5 - Penutup',
            6 => 'Daftar Pustaka & Lampiran'
        ];

        $dosens = User::where('role', 'dosen')->get();

        return view('mahasiswa.dokumen.index', compact('uploads', 'chapters', 'dosens'));
    }

    /**
     * Form upload dokumen akhir.
     */
    public function create()
    {
        $dokumen = DokumenAkhir::own()->latest()->get();
        $dosens = User::where('role', 'dosen')->get();

        return view('mahasiswa.dokumen.create', compact('dokumen', 'dosens'));
    }

    /**
     * Simpan dokumen akhir ke database & storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'bab' => 'required|integer|min:1|max:6',
            'file' => 'required|mimes:pdf,doc,docx|max:5120',
            'dosen_pembimbing_id' => 'required|exists:users,id',
            'deskripsi' => 'nullable|string',
        ]);

        $path = $request->file('file')->store('dokumen_akhir', 'public');

        $dokumen = DokumenAkhir::updateOrCreate(
            [
                'mahasiswa_id' => Auth::id(),
                'bab' => $request->bab,
            ],
            [
                'dosen_pembimbing_id' => $request->dosen_pembimbing_id,
                'judul' => 'File Bab ' . $request->bab,
                'file' => $path,
                'status' => 'pending',
                'deskripsi' => $request->deskripsi,
            ]
        );

        $admins = User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            NotifyHelper::send(
                $admin->id,
                'Dokumen Akhir Diupload',
                auth()->user()->name . ' telah mengunggah dokumen akhir.',
                route('admin.proposal.index')
            );
        }

        if ($dokumen->dosen_pembimbing_id) {
            NotifyHelper::send(
                $dokumen->dosen_pembimbing_id,
                'Dokumen Akhir Mahasiswa',
                auth()->user()->name . ' telah mengunggah dokumen akhir.',
                route('dosen.dokumen-akhir.index')
            );
        }

        return redirect()->back()->with('success', 'Bab ' . $request->bab . ' berhasil diupload.');
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

        $dosens = \App\Models\User::where('role', 'dosen')->get();

        return view('mahasiswa.dokumen.edit', compact('dokumen', 'dosens'));
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
