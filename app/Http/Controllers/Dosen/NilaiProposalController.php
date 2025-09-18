<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Nilai;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
class NilaiProposalController extends Controller
{
    public function index()
    {
        $nilai = Nilai::with('mahasiswa')->get();
        $proposalsBelumDinilai = Auth::user()->mahasiswaBimbinganProposal()
            ->whereDoesntHave('nilai')
            ->get();
        return view('dosen.nilai_proposal.index', compact('nilai', 'proposalsBelumDinilai'));
    }

    public function create()
    {
        $proposals = Auth::user()->mahasiswaBimbinganProposal()->get();
        return view('dosen.nilai_proposal.create', compact('proposals'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'proposal_id' => 'required|exists:proposals,id',
            'grade' => 'required|string',
            'keterangan' => 'nullable|string',
        ]);

        $exists = Nilai::where('proposal_id', $request->proposal_id)->exists();

        if ($exists) {
            return redirect()->back()->withErrors(['proposal_id' => 'Proposal ini sudah memiliki nilai.'])->withInput();
        }

        Nilai::create([
            'proposal_id' => $request->proposal_id,
            'dosen_id' => Auth::id(),
            'grade' => $request->grade,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('dosen.nilai-proposal.index')->with('success', 'Nilai berhasil ditambahkan.');
    }
    public function edit($id)
    {
        $nilai = Nilai::findOrFail($id);
        $proposals = Auth::user()->mahasiswaBimbinganProposal()->get();

        return view('dosen.nilai_proposal.edit', compact('nilai', 'proposals'));
    }

    public function update(Request $request, $id)
    {
        $nilai = Nilai::findOrFail($id);
        $request->validate([
            'proposal_id' => [
                'required',
                'exists:proposals,id',
                Rule::unique('nilais')->ignore($nilai->id),
            ],
            'grade' => 'required|string',
            'keterangan' => 'nullable|string',
        ]);

        $nilai = Nilai::findOrFail($id);
        $nilai->update([
            'proposal_id' => $request->proposal_id,
            'grade' => $request->grade,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('dosen.nilai-proposal.index')->with('success', 'Nilai berhasil diperbarui.');
    }
}
