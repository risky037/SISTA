<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\NotifyHelper;
use App\Http\Controllers\Controller;
use App\Models\Pengumuman;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PengumumanController extends Controller
{
    public function index()
    {
        $pengumumans = Pengumuman::latest()->paginate(10);
        return view('admin.pengumuman.index', compact('pengumumans'));
    }

    public function create()
    {
        return view('admin.pengumuman.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nomor_surat' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'file_pdf' => 'required|mimes:pdf|max:2048',
            'informasi' => 'required|string',
        ]);

        $filePath = $request->file('file_pdf')->store('pengumuman', 'public');

        $pengumuman = Pengumuman::create([
            'nomor_surat' => $request->nomor_surat,
            'tanggal' => $request->tanggal,
            'file_path' => $filePath,
            'informasi' => $request->informasi,
        ]);

        $this->notifyStudents($pengumuman);

        return redirect()->route('admin.pengumuman.index')
            ->with('success', 'Pengumuman berhasil dibuat dan dikirim ke mahasiswa.');
    }

    public function edit(Pengumuman $pengumuman)
    {
        return view('admin.pengumuman.edit', compact('pengumuman'));
    }

    public function update(Request $request, Pengumuman $pengumuman)
    {
        $request->validate([
            'nomor_surat' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'file_pdf' => 'nullable|mimes:pdf|max:2048',
            'informasi' => 'required|string',
        ]);

        $data = [
            'nomor_surat' => $request->nomor_surat,
            'tanggal' => $request->tanggal,
            'informasi' => $request->informasi,
        ];

        if ($request->hasFile('file_pdf')) {
            if ($pengumuman->file_path && Storage::disk('public')->exists($pengumuman->file_path)) {
                Storage::disk('public')->delete($pengumuman->file_path);
            }
            $data['file_path'] = $request->file('file_pdf')->store('pengumuman', 'public');
        }

        $pengumuman->update($data);

        return redirect()->route('admin.pengumuman.index')
            ->with('success', 'Pengumuman berhasil diperbarui.');
    }

    public function destroy(Pengumuman $pengumuman)
    {
        if ($pengumuman->file_path && Storage::disk('public')->exists($pengumuman->file_path)) {
            Storage::disk('public')->delete($pengumuman->file_path);
        }

        $pengumuman->delete();

        return redirect()->route('admin.pengumuman.index')
            ->with('success', 'Pengumuman berhasil dihapus.');
    }

    private function notifyStudents($pengumuman)
    {
        User::where('role', 'mahasiswa')->chunk(100, function ($mahasiswas) use ($pengumuman) {
            foreach ($mahasiswas as $mahasiswa) {
                NotifyHelper::send(
                    $mahasiswa->id,
                    'Pengumuman Baru: ' . $pengumuman->nomor_surat,
                    'Terdapat pengumuman baru: ' . Str::limit($pengumuman->informasi, 50),
                    asset('storage/' . $pengumuman->file_path)
                );
            }
        });
    }
}
