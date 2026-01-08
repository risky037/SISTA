<?php

namespace App\Http\Controllers\Dosen;

use App\Helpers\NotifyHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Nilai;
use App\Models\Proposal;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
class NilaiProposalController extends Controller
{
    public function index()
    {
        $dosenId = Auth::id();

        $belumDinilai = Proposal::with('mahasiswa')
            ->where('dosen_pembimbing_id', $dosenId)
            ->where('status', '!=', 'pending')
            ->whereDoesntHave('nilai')
            ->get();

        $sudahDinilai = Nilai::with(['proposal.mahasiswa'])
            ->where('dosen_id', $dosenId)
            ->whereNotNull('proposal_id')
            ->latest()
            ->get();

        return view('dosen.nilai_proposal.index', compact('belumDinilai', 'sudahDinilai'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'proposal_id' => 'required|exists:proposals,id',
            'grade' => 'required|string',
            'keterangan' => 'nullable|string',
        ]);

        $proposal = Proposal::findOrFail($request->proposal_id);

        if ($proposal->dosen_pembimbing_id != Auth::id()) {
            return back()->with('error', 'Anda tidak berhak menilai proposal ini.');
        }

        Nilai::create([
            'proposal_id' => $request->proposal_id,
            'dosen_id' => Auth::id(),
            'grade' => $request->grade,
            'keterangan' => $request->keterangan,
        ]);

        NotifyHelper::send(
            $proposal->mahasiswa_id,
            'Nilai Proposal Keluar',
            'Dosen pembimbing telah memberikan nilai untuk proposal Anda.',
            route('mahasiswa.nilai.index')
        );

        return redirect()->back()->with('success', 'Nilai berhasil disimpan.');
    }

    public function update(Request $request, $id)
    {
        $nilai = Nilai::findOrFail($id);

        if ($nilai->dosen_id != Auth::id()) {
            abort(403);
        }

        $request->validate([
            'grade' => 'required|string',
            'keterangan' => 'nullable|string',
        ]);

        $nilai->update([
            'grade' => $request->grade,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->back()->with('success', 'Nilai berhasil diperbarui.');
    }
}
