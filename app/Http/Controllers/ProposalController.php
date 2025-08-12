<?php

namespace App\Http\Controllers;

use App\Models\Proposal;
use Illuminate\Http\Request;

class ProposalController extends Controller
{
    public function index()
    {
        // List semua proposal (filter by role nanti di middleware)
        $proposals = Proposal::with(['mahasiswa', 'dosen'])->latest()->get();
        return view('proposals.index', compact('proposals'));
    }

    public function create()
    {
        return view('proposals.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'file_proposal' => 'required|mimes:pdf|max:2048',
        ]);

        $fileName = time() . '_' . $request->file('file_proposal')->getClientOriginalName();
        $request->file('file_proposal')->move(public_path('uploads/proposals'), $fileName);

        Proposal::create([
            'mahasiswa_id' => auth()->id(),
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'file_proposal' => $fileName,
            'status' => 'pending',
        ]);

        return redirect()->route('proposals.index')->with('success', 'Proposal berhasil diajukan.');
    }

    public function show(Proposal $proposal)
    {
        return view('proposals.show', compact('proposal'));
    }

    public function edit(Proposal $proposal)
    {
        return view('proposals.edit', compact('proposal'));
    }

    public function update(Request $request, Proposal $proposal)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
        ]);

        $proposal->update($request->only(['judul', 'deskripsi']));

        return redirect()->route('proposals.index')->with('success', 'Proposal berhasil diperbarui.');
    }

    public function destroy(Proposal $proposal)
    {
        $proposal->delete();
        return redirect()->route('proposals.index')->with('success', 'Proposal berhasil dihapus.');
    }
}
