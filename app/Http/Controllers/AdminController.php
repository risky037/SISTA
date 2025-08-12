<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function manageMahasiswa()
    {
        // Tampilkan daftar mahasiswa
    }

    public function manageDosen()
    {
        // Tampilkan daftar dosen
    }
}