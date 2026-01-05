<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Template;

class TemplateMahasiswaController extends Controller
{
    public function index()
    {
        $templates = Template::latest()->paginate(10);
        return view('mahasiswa.template.index', compact('templates'));
    }
}
