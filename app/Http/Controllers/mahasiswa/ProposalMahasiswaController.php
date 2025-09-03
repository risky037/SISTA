<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Proposal;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProposalMahasiswaController extends Controller
{
    public function index()
    {
        $proposals = Proposal::where('mahasiswa_id', Auth::id())->latest()->get();
        return view('mahasiswa.Proposal.index', compact('Proposals'));
    }

    public function create()
    {
        return view('mahasiswa.Proposal.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'file_proposal' => 'required|mimes:pdf|max:2048',
        ]);

        $fileName = time() . '-' . $request->file('file_proposal')->getClientOriginalName();
        $request->file('file_Proposal')->storeAs('public/proposals', $fileName);

        Proposal::create([
            'mahasiswa_id' => Auth::id(),
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'file_proposal' => $fileName,
            'status' => 'pending',
        ]);

        return redirect()->route('mahasiswa.Proposal.index')->with('success', 'Proposal berhasil diajukan!');
    }

    public function show($id)
    {
        $proposal = Proposal::where('id', $id)->where('mahasiswa_id', Auth::id())->firstOrFail();
        return view('mahasiswa.Proposal.show', compact('Proposal'));
    }

    public function edit($id)
    {
        $proposal = Proposal::where('id', $id)->where('mahasiswa_id', Auth::id())->firstOrFail();
        return view('mahasiswa.Proposal.edit', compact('Proposal'));
    }

    public function update(Request $request, $id)
    {
        $proposal = Proposal::where('id', $id)->where('mahasiswa_id', Auth::id())->firstOrFail();

        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'file_proposal' => 'nullable|mimes:pdf|max:2048',
        ]);

        $proposal->judul = $request->judul;
        $proposal->deskripsi = $request->deskripsi;

        if ($request->hasFile('file_proposal')) {
            if ($proposal->file_proposal && Storage::exists('public/proposals/' . $proposal->file_proposal)) {
                Storage::delete('public/proposals/' . $proposal->file_proposal);
            }
            $fileName = time() . '-' . $request->file('file_proposal')->getClientOriginalName();
            $request->file('file_proposal')->storeAs('public/proposals', $fileName);
            $proposal->file_proposal = $fileName;
        }

        $proposal->save();

        return redirect()->route('mahasiswa.Proposal.index')->with('success', 'Proposal berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $proposal = Proposal::where('id', $id)->where('mahasiswa_id', Auth::id())->firstOrFail();

        if ($proposal->file_proposal && Storage::exists('public/Proposals/' . $Proposal->file_Proposal)) {
            Storage::delete('public/Proposals/' . $proposal->file_proposal);
        }

        $proposal->delete();

        return redirect()->route('mahasiswa.Proposal.index')->with('success', 'Proposal berhasil dihapus!');
    }
}
