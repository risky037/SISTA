<?php

namespace App\Http\Controllers;

use App\Models\Bimbingan;
use Illuminate\Http\Request;

class BimbinganController extends Controller
{
    public function index()
    {
        $bimbingan = Bimbingan::with(['mahasiswa', 'dosen'])->latest()->get();
        return view('bimbingan.index', compact('bimbingan'));
    }

    public function create()
    {
        return view('bimbingan.create');
    }

    public function store(Request $request)
    {
        // Nanti diisi validasi + simpan bimbingan
    }

    public function show(Bimbingan $bimbingan)
    {
        return view('bimbingan.show', compact('bimbingan'));
    }

    public function edit(Bimbingan $bimbingan)
    {
        return view('bimbingan.edit', compact('bimbingan'));
    }

    public function update(Request $request, Bimbingan $bimbingan)
    {
        // Nanti diisi update data
    }

    public function destroy(Bimbingan $bimbingan)
    {
        $bimbingan->delete();
        return redirect()->route('bimbingan.index');
    }
}