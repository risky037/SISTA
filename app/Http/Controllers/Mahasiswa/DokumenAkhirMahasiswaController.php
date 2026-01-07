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

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'bab' => 'required|integer|min:1|max:6',
            'file' => 'required|mimes:pdf,doc,docx|max:10240',
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
                'judul' => $request->judul,
                'file' => $path,
                'status' => 'pending',
                'deskripsi' => $request->deskripsi,
                'catatan_dosen' => null,
            ]
        );

        $admins = User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            NotifyHelper::send(
                $admin->id,
                'Update Skripsi: ' . Auth::user()->name,
                Auth::user()->name . " mengunggah dokumen untuk Bab " . $request->bab,
                route('admin.dokumen-akhir.index')
            );
        }

        if ($dokumen->dosen_pembimbing_id) {
            NotifyHelper::send(
                $dokumen->dosen_pembimbing_id,
                'Bimbingan Baru: Bab ' . $request->bab,
                Auth::user()->name . ' menunggu review untuk Bab ' . $request->bab,
                route('dosen.dokumen-akhir.show-mahasiswa', Auth::id())
            );
        }

        return redirect()->back()->with('success', 'Dokumen Bab ' . $request->bab . ' berhasil diunggah.');
    }
}
