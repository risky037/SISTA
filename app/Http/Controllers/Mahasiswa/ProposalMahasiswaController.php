<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Helpers\NotifyHelper;
use App\Http\Controllers\Controller;
use App\Jobs\SendNotificationJob;
use Illuminate\Http\Request;
use App\Models\Proposal;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProposalMahasiswaController extends Controller
{
    public function index()
    {
        $proposals = Proposal::with('dosen')->where('mahasiswa_id', Auth::id())->latest()->get();
        return view('mahasiswa.Proposal.index', compact('proposals'));
    }

    public function create()
    {
        $dosens = User::where('role', 'dosen')->get();
        return view('mahasiswa.Proposal.create', compact('dosens'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'file_proposal' => 'required|mimes:pdf|max:10240',
            'dosen_pembimbing_id' => 'required|exists:users,id',
        ]);

        $fileName = time() . '-' . $request->file('file_proposal')->getClientOriginalName();
        $request->file('file_proposal')->storeAs('proposals', $fileName, 'public');

        $proposal = Proposal::create([
            'mahasiswa_id' => Auth::id(),
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'file_proposal' => $fileName,
            'status' => 'pending',
            'dosen_pembimbing_id' => $request->dosen_pembimbing_id,
        ]);

        $admins = User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            NotifyHelper::send(
                $admin->id,
                'Pengajuan Proposal Baru',
                auth()->user()->name . ' telah mengunggah proposal.',
                route('admin.proposal.index')
            );
        }

        if ($proposal->dosen_pembimbing_id) {
            NotifyHelper::send(
                $proposal->dosen_pembimbing_id,
                'Proposal Mahasiswa Baru',
                auth()->user()->name . ' telah mengunggah proposal.',
                route('dosen.proposals.index')
            );
        }

        return redirect()->route('mahasiswa.proposals.index')->with('success', 'Proposal berhasil diajukan!');
    }

    public function show($id)
    {
        $proposal = Proposal::with('dosen')->where('id', $id)->where('mahasiswa_id', Auth::id())->firstOrFail();
        return view('mahasiswa.Proposal.show', compact('proposal'));
    }

    public function edit($id)
    {
        $proposal = Proposal::where('id', $id)->where('mahasiswa_id', Auth::id())->firstOrFail();
        $dosens = User::where('role', 'dosen')->get();
        return view('mahasiswa.Proposal.edit', compact('proposal', 'dosens'));
    }

    public function update(Request $request, $id)
    {
        $proposal = Proposal::where('id', $id)->where('mahasiswa_id', Auth::id())->firstOrFail();

        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'file_proposal' => 'nullable|mimes:pdf|max:10240',
            'dosen_pembimbing_id' => 'required|exists:users,id',
        ]);

        $proposal->judul = $request->judul;
        $proposal->deskripsi = $request->deskripsi;
        $proposal->dosen_pembimbing_id = $request->dosen_pembimbing_id;

        if ($request->hasFile('file_proposal')) {
            if ($proposal->file_proposal && Storage::disk('public')->exists('proposals/' . $proposal->file_proposal)) {
                Storage::disk('public')->delete('proposals/' . $proposal->file_proposal);
            }

            $fileName = time() . '-' . $request->file('file_proposal')->getClientOriginalName();
            $request->file('file_proposal')->storeAs('proposals', $fileName, 'public');
            $proposal->file_proposal = $fileName;
        }

        $proposal->save();

        return redirect()->route('mahasiswa.proposals.index')->with('success', 'Proposal berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $proposal = Proposal::where('id', $id)->where('mahasiswa_id', Auth::id())->firstOrFail();

        if ($proposal->file_proposal && Storage::disk('public')->exists('proposals/' . $proposal->file_proposal)) {
            Storage::disk('public')->delete('proposals/' . $proposal->file_proposal);
        }

        $proposal->delete();

        return redirect()->route('mahasiswa.proposals.index')->with('success', 'Proposal berhasil dihapus!');
    }
}
