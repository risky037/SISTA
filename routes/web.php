<?php

use App\Http\Controllers\Admin\AdminManagementController;
use App\Http\Controllers\Admin\MahasiswaManagementController;
use App\Http\Controllers\Admin\DosenManagementController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\BimbinganController;
use App\Http\Controllers\LaporanProgressController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProposalController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('welcome');
})->name('home')->middleware('guest');

Route::post('/login', [AuthenticatedSessionController::class, 'store'])->middleware('guest');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('dashboard.admin');
    })->name('admin.dashboard')->middleware('role:admin');

    Route::get('/dosen/dashboard', function () {
        return view('dashboard.dosen');
    })->name('dosen.dashboard')->middleware('role:dosen');

    Route::get('/mahasiswa/dashboard', function () {
        return view('dashboard.mahasiswa');
    })->name('mahasiswa.dashboard')->middleware('role:mahasiswa');
});

Route::resource('proposals', ProposalController::class);
Route::resource('bimbingans', BimbinganController::class);
Route::resource('laporan-progress', LaporanProgressController::class);

Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('users', UserController::class);
});

Route::prefix('admin')->middleware(['auth', 'role:admin'])->name('admin.')->group(function () {
    Route::resource('management/admin', AdminManagementController::class)->names('management.admin');
    Route::resource('management/mahasiswa', MahasiswaManagementController::class)->names('management.mahasiswa');
    Route::resource('management/dosen', DosenManagementController::class)->names('management.dosen');
});


require __DIR__ . '/auth.php';
