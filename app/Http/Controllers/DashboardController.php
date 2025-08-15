<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $mahasiswas = Mahasiswa::all();
        return view('dashboard-mahasiswa', [
            'title' => 'Dashboard Mahasiswa',
            'mahasiswas' => $mahasiswas
        ]);
    }
}
