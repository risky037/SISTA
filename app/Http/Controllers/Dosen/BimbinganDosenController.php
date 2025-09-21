<?php

namespace App\Http\Controllers\Dosen;

use App\Helpers\NotifyHelper;
use App\Http\Controllers\Controller;
use App\Models\Bimbingan;
use App\Models\User;
use Illuminate\Http\Request;

class BimbinganDosenController extends Controller
{
    public function index()
    {
        $bimbingans = Bimbingan::with('mahasiswa')
            ->where('dosen_id', auth()->id())
            ->latest()
            ->get();

        return view('dosen.bimbingan.index', compact('bimbingans'));
    }

    public function updateStatus(Request $request, $id)
    {
        $bimbingan = Bimbingan::where('dosen_id', auth()->id())->findOrFail($id);

        $request->validate([
            'status' => 'required|in:pending,approved,rejected',
            'catatan_dosen' => 'nullable|string',
        ]);

        $bimbingan->update([
            'status' => $request->status,
            'catatan_dosen' => $request->catatan_dosen,
        ]);

        $admins = User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            NotifyHelper::send(
                $admin->id,
                'Status Bimbingan Mahasiswa',
                'Jadwal bimbingan ' . $bimbingan->mahasiswa->name . ' telah ' . $bimbingan->status . ' oleh dosen.',
                route('admin.jadwal.index')
            );
        }

        if ($bimbingan->status === 'approved') {
            NotifyHelper::send(
                $bimbingan->mahasiswa_id,
                'Jadwal Bimbingan Terbit',
                'Jadwal bimbingan Anda telah disetujui. Silakan cek jadwal Anda.',
                route('mahasiswa.jadwal-seminar')
            );
        }

        if (!empty($request->catatan_dosen)) {
            NotifyHelper::send(
                $bimbingan->mahasiswa_id,
                'Catatan Baru dari Dosen Pembimbing',
                'Dosen Anda telah menambahkan catatan baru pada bimbingan Anda: "' . $request->catatan_dosen . '"',
                route('mahasiswa.jadwal-seminar', $bimbingan->id)
            );
        }

        return redirect()->route('dosen.bimbingan.index')->with('success', 'Status dan catatan berhasil diperbarui');
    }
    public function indexJadwal()
    {
        $bimbingans = Bimbingan::with('mahasiswa')
            ->where('dosen_id', auth()->id())
            ->where('status', 'approved')
            ->latest()
            ->get();

        return view('dosen.jadwal.index', compact('bimbingans'));
    }

}
