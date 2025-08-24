<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Proposal;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProposalManagementController extends Controller
{
    public function index()
    {
        $proposals = Proposal::with(['mahasiswa', 'dosen'])->paginate(10);
        return view('admin.proposal.index', compact('proposals'));
    }

    public function create()
    {
        $mahasiswa = User::where('role', 'mahasiswa')->get();
        $dosen = User::where('role', 'dosen')->get();
        return view('admin.proposal.create', compact('mahasiswa', 'dosen'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'mahasiswa_id' => 'required|exists:users,id',
            'dosen_pembimbing_id' => 'required|exists:users,id',
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'file_proposal' => 'nullable|mimes:pdf,doc,docx|max:2048',
        ]);

        $filePath = null;
        if ($request->hasFile('file_proposal')) {
            $filePath = $request->file('file_proposal')->store('proposals', 'public');
        }

        Proposal::create([
            'mahasiswa_id' => $request->mahasiswa_id,
            'dosen_pembimbing_id' => $request->dosen_pembimbing_id,
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'file_proposal' => $filePath,
            'status' => 'pending',
        ]);

        return redirect()->route('admin.proposal.index')->with('success', 'Proposal berhasil ditambahkan');
    }

    public function edit(Proposal $proposal)
    {
        $mahasiswa = User::where('role', 'mahasiswa')->get();
        $dosen = User::where('role', 'dosen')->get();
        return view('admin.proposal.edit', compact('proposal', 'mahasiswa', 'dosen'));
    }

    public function update(Request $request, Proposal $proposal)
    {
        $request->validate([
            'mahasiswa_id' => 'required|exists:users,id',
            'dosen_pembimbing_id' => 'required|exists:users,id',
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'file_proposal' => 'nullable|mimes:pdf,doc,docx|max:2048',
            'status' => 'required|in:pending,approved,rejected',
        ]);

        if ($request->hasFile('file_proposal')) {
            if ($proposal->file_proposal) {
                Storage::disk('public')->delete($proposal->file_proposal);
            }
            $filePath = $request->file('file_proposal')->store('proposals', 'public');
            $proposal->file_proposal = $filePath;
        }

        $proposal->update([
            'mahasiswa_id' => $request->mahasiswa_id,
            'dosen_pembimbing_id' => $request->dosen_pembimbing_id,
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'status' => $request->status,
            'catatan_dosen' => $request->catatan_dosen,
            'file_proposal' => $proposal->file_proposal,
        ]);

        return redirect()->route('admin.proposal.index')->with('success', 'Proposal berhasil diperbarui');
    }

    public function destroy(Proposal $proposal)
    {
        if ($proposal->file_proposal) {
            Storage::disk('public')->delete($proposal->file_proposal);
        }
        $proposal->delete();

        return redirect()->route('admin.proposal.index')->with('success', 'Proposal berhasil dihapus');
    }
}
