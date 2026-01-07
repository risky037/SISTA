<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\DokumenAkhir;
use App\Models\User;
use App\Helpers\NotifyHelper;

class DokumenAkhirDosenController extends Controller
{
    /**
     * Menampilkan daftar mahasiswa yang dibimbing dan sudah upload.
     */
    public function index()
    {
        // Ambil ID Dosen yang login
        $dosenId = Auth::id();

        // Ambil mahasiswa yang memiliki setidaknya satu dokumen akhir dengan dosen pembimbing ini
        // Menggunakan distinct agar nama mahasiswa tidak muncul berulang kali
        $mahasiswas = User::whereHas('dokumenAkhir', function ($q) use ($dosenId) {
            $q->where('dosen_pembimbing_id', $dosenId);
        })->with([
                    'dokumenAkhir' => function ($q) use ($dosenId) {
                        // Eager load dokumen hanya milik dosen ini
                        $q->where('dosen_pembimbing_id', $dosenId);
                    }
                ])->get();

        return view('dosen.dokumen_akhir.index', compact('mahasiswas'));
    }

    /**
     * Menampilkan Dashboard Progress Skripsi per Mahasiswa
     */
    public function showByMahasiswa($mahasiswaId)
    {
        $dosenId = Auth::id();
        $mahasiswa = User::findOrFail($mahasiswaId);

        // Ambil semua dokumen mahasiswa ini, key by 'bab'
        $uploads = DokumenAkhir::where('mahasiswa_id', $mahasiswaId)
            ->where('dosen_pembimbing_id', $dosenId)
            ->get()
            ->keyBy('bab');

        // Definisi Bab
        $chapters = [
            1 => 'Bab 1 - Pendahuluan',
            2 => 'Bab 2 - Tinjauan Pustaka',
            3 => 'Bab 3 - Metodologi Penelitian',
            4 => 'Bab 4 - Hasil dan Pembahasan',
            5 => 'Bab 5 - Penutup',
            6 => 'Daftar Pustaka & Lampiran'
        ];

        return view('dosen.dokumen_akhir.show', compact('mahasiswa', 'uploads', 'chapters'));
    }

    /**
     * Update Status & Catatan untuk satu Bab
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected',
            'catatan_dosen' => 'nullable|string'
        ]);

        $dokumen = DokumenAkhir::where('dosen_pembimbing_id', Auth::id())->findOrFail($id);

        $dokumen->status = $request->status;
        $dokumen->catatan_dosen = $request->catatan_dosen;
        $dokumen->save();

        // Kirim Notifikasi ke Mahasiswa
        NotifyHelper::send(
            $dokumen->mahasiswa_id,
            'Review Bab ' . $dokumen->bab,
            'Dosen pembimbing telah me-review dokumen Bab ' . $dokumen->bab . ' Anda.',
            route('mahasiswa.dokumen-akhir.index')
        );

        return back()->with('success', 'Status Bab ' . $dokumen->bab . ' berhasil diperbarui.');
    }
}
