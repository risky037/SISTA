<?php

use App\Http\Controllers\Admin\AdminManagementController;
use App\Http\Controllers\Admin\JadwalSidangManagementController;
use App\Http\Controllers\Admin\MahasiswaManagementController;
use App\Http\Controllers\Admin\DosenManagementController;
use App\Http\Controllers\Admin\ProposalManagementController;
use App\Http\Controllers\Admin\TemplateManagementController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Dosen\BimbinganDosenController;
use App\Http\Controllers\Dosen\LaporanProgressDosenController;
use App\Http\Controllers\Dosen\ProposalDosenController;
use App\Http\Controllers\Mahasiswa\JadwalSeminarMahasiswaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return view('welcome');
})->name('home')->middleware('guest');

Route::post('/login', [AuthenticatedSessionController::class, 'store'])->middleware('guest');

Route::prefix('admin')->middleware(['auth', 'role:admin'])->name('admin.')->group(function () {
    Route::get('/dashboard', fn() => view('admin.dashboard'))->name('dashboard');
    Route::resource('users/admin', AdminManagementController::class)->names('management.admin');
    Route::resource('users/mahasiswa', MahasiswaManagementController::class)->names('management.mahasiswa');
    Route::resource('users/dosen', DosenManagementController::class)->names('management.dosen');
    Route::resource('jadwal', JadwalSidangManagementController::class)->names('jadwal');
    Route::resource('proposal', ProposalManagementController::class)->names('proposal');
    Route::resource('templates', TemplateManagementController::class)->names('template');
});

Route::prefix('mahasiswa')->middleware(['auth', 'role:mahasiswa'])->name('mahasiswa.')->group(function () {
    Route::get('/dashboard', fn() => view('mahasiswa.dashboard'))->name('dashboard');

    Route::get('jadwal', [JadwalSeminarMahasiswaController::class, 'index'])->name('jadwal-seminar');
});

Route::prefix('dosen')->middleware(['auth', 'role:dosen'])->name('dosen.')->group(function () {
    Route::get('/dashboard', fn() => view('dosen.dashboard'))->name('dashboard');

    Route::get('bimbingan', [BimbinganDosenController::class, 'index'])->name('bimbingan.index');
    Route::get('jadwal', [BimbinganDosenController::class, 'indexJadwal'])->name('jadwalbimbingan.index');
    Route::post('bimbingan/{id}/status', [BimbinganDosenController::class, 'updateStatus'])->name('bimbingan.updateStatus');
    Route::post('bimbingan/{id}/catatan', [BimbinganDosenController::class, 'addCatatan'])->name('bimbingan.addCatatan');

    Route::resource('proposals', ProposalDosenController::class)->only(['index', 'show'])->names('proposals');
    Route::post('proposals/{id}/status', [ProposalDosenController::class, 'updateStatus'])->name('proposals.updateStatus');

    Route::resource('laporan-progress', LaporanProgressDosenController::class)->only(['index', 'show', 'update']);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';





// GAK PENTING
// Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {
//     Route::resource('users', UserController::class);
// });

// Route::resource('proposals', ProposalController::class);
// Route::resource('bimbingans', BimbinganController::class);
// Route::resource('laporan-progress', LaporanProgressController::class);

