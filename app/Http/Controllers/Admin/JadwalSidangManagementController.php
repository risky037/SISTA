<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\NotifyHelper;
use App\Http\Controllers\Controller;
use App\Models\Bimbingan;
use App\Models\User;
use Illuminate\Http\Request;

class JadwalSidangManagementController extends Controller
{
    public function index()
    {
        $jadwals = Bimbingan::with(['mahasiswa', 'dosen'])->paginate(10);
        return view('admin.jadwal.index', compact('jadwals'));
    }

    public function create()
    {
        $mahasiswa = User::where('role', 'mahasiswa')->get();
        $dosen = User::where('role', 'dosen')->get();
        return view('admin.jadwal.create', compact('mahasiswa', 'dosen'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'mahasiswa_id' => 'required|exists:users,id',
            'dosen_id' => 'required|exists:users,id',
            'tanggal_bimbingan' => 'required|date',
            'waktu_mulai' => 'required',
            'waktu_selesai' => 'required|after:waktu_mulai',
        ]);

        $jadwal = Bimbingan::create([
            'mahasiswa_id' => $request->mahasiswa_id,
            'dosen_id' => $request->dosen_id,
            'tanggal_bimbingan' => $request->tanggal_bimbingan,
            'waktu_mulai' => $request->waktu_mulai,
            'waktu_selesai' => $request->waktu_selesai,
            'status' => 'pending',
        ]);

        NotifyHelper::send(
            $jadwal->dosen_id,
            'Jadwal Baru dari Admin',
            'Anda memiliki jadwal baru dari admin untuk bimbingan/sidang.',
            route('dosen.bimbingan.index')
        );

        return redirect()->route('admin.jadwal.index')->with('success', 'Jadwal sidang berhasil dibuat');
    }

    public function edit(Bimbingan $jadwal)
    {
        $mahasiswa = User::where('role', 'mahasiswa')->get();
        $dosen = User::where('role', 'dosen')->get();
        return view('admin.jadwal.edit', compact('jadwal', 'mahasiswa', 'dosen'));
    }

    public function update(Request $request, Bimbingan $jadwal)
    {
        $request->validate([
            'mahasiswa_id' => 'required|exists:users,id',
            'dosen_id' => 'required|exists:users,id',
            'tanggal_bimbingan' => 'required|date',
            'waktu_mulai' => 'required',
            'waktu_selesai' => 'required|after:waktu_mulai',
        ]);

        $jadwal->update([
            'mahasiswa_id' => $request->mahasiswa_id,
            'dosen_id' => $request->dosen_id,
            'tanggal_bimbingan' => $request->tanggal_bimbingan,
            'waktu_mulai' => $request->waktu_mulai,
            'waktu_selesai' => $request->waktu_selesai,
            'status' => $request->status ?? $jadwal->status,
        ]);

        return redirect()->route('admin.jadwal.index')->with('success', 'Jadwal sidang berhasil diupdate');
    }

    public function destroy(Bimbingan $jadwal)
    {
        $jadwal->delete();
        return redirect()->route('admin.jadwal.index')->with('success', 'Jadwal sidang berhasil dihapus');
    }
}
