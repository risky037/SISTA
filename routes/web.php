<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

// Route::view('/pendaftaran', 'pendaftaran')->name('pendaftaran');
// Route::view('/dosen', 'dosen')->name('dosen');
// Route::view('/jadwal', 'jadwal')->name('jadwal');
// Route::view('/laporan', 'laporan')->name('laporan');
// Route::view('/revisi', 'revisi')->name('revisi');
// Route::view('/upload', 'upload')->name('upload');
// Route::view('/arsip', 'arsip')->name('arsip');
// Route::view('/bantuan', 'bantuan')->name('bantuan');
