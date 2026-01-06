<?php

namespace App\Http\Controllers;

use App\Models\Pengumuman;
use Illuminate\Http\Request;

class UserPengumumanController extends Controller
{
    public function index()
    {
        $pengumumans = Pengumuman::latest()->paginate(10);
        return view('mahasiswa.pengumuman.index', compact('pengumumans'));
    }
    public function show(Pengumuman $pengumuman)
    {
        return view('mahasiswa.pengumuman.show', compact('pengumuman'));
    }
}
