<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;


Route::get('/dashboard-mahasiswa', function () {
    return view('dashboard mahasiswa');
});


Route::get('/', function () {
    return view('dashboard-mahasiswa');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

use App\Http\Controllers\MahasiswaController;

Route::resource('mahasiswa', MahasiswaController::class);
Route::get('/dashboard-mahasiswa', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard-mahasiswa.index');

require __DIR__.'/auth.php';
