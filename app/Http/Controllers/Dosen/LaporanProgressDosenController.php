<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Proposal;
use App\Models\DokumenAkhir;
use App\Models\Bimbingan;
use App\Models\Nilai;

class LaporanProgressDosenController extends Controller
{
    public function index()
    {
        $dosenId = Auth::id();

        $totalProposal = Proposal::where('dosen_pembimbing_id', $dosenId)->count();
        $proposalStatus = Proposal::where('dosen_pembimbing_id', $dosenId)
            ->selectRaw("status, COUNT(*) as total")
            ->groupBy('status')
            ->pluck('total', 'status');

        $totalDokumen = DokumenAkhir::where('dosen_pembimbing_id', $dosenId)->count();
        $dokumenStatus = DokumenAkhir::where('dosen_pembimbing_id', $dosenId)
            ->selectRaw("status, COUNT(*) as total")
            ->groupBy('status')
            ->pluck('total', 'status');

        $totalBimbingan = Bimbingan::where('dosen_id', $dosenId)->count();

        $totalNilaiProposal = Nilai::whereNotNull('proposal_id')->where('dosen_id', $dosenId)->count();
        $totalNilaiDokumen = Nilai::whereNotNull('dokumen_akhir_id')->where('dosen_id', $dosenId)->count();

        return view('dosen.laporan.index', compact(
            'totalProposal',
            'proposalStatus',
            'totalDokumen',
            'dokumenStatus',
            'totalBimbingan',
            'totalNilaiProposal',
            'totalNilaiDokumen'
        ));
    }
}
