<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\Proposal;
use Illuminate\Http\Request;

class ProposalDosenController extends Controller
{
    public function index()
    {
        $proposals = Proposal::with('mahasiswa')
            ->where('dosen_pembimbing_id', auth()->id())
            ->latest()
            ->get();

        return view('dosen.proposals.index', compact('proposals'));
    }

    public function show($id)
    {
        $proposal = Proposal::with('mahasiswa')->findOrFail($id);
        return view('dosen.proposals.show', compact('proposal'));
    }

    public function updateStatus(Request $request, $id)
    {
        $proposal = Proposal::where('dosen_pembimbing_id', auth()->id())->findOrFail($id);

        $request->validate([
            'status' => 'required|in:pending,revisi,diterima,ditolak',
            'catatan_dosen' => 'nullable|string'
        ]);

        $proposal->update([
            'status' => $request->status,
            'catatan_dosen' => $request->catatan_dosen,
        ]);

        $pesan = 'Status proposal diperbarui. ';

        if ($request->status === 'diterima') {
            $pesan .= '<a href="' . route('dosen.nilai-proposal.create') . '" class="underline text-green-700 hover:text-green-900 font-semibold">Beri nilai sekarang!</a>';
        }

        return redirect()->route('dosen.proposals.index')->with('success', $pesan);
    }

}
