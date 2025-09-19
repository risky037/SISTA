<?php

use App\Http\Controllers\Admin\AdminManagementController;
use App\Http\Controllers\Admin\JadwalSidangManagementController;
use App\Http\Controllers\Admin\MahasiswaManagementController;
use App\Http\Controllers\Admin\DosenManagementController;
use App\Http\Controllers\Admin\ProposalManagementController;
use App\Http\Controllers\Admin\TemplateManagementController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Dosen\BimbinganDosenController;
use App\Http\Controllers\Dosen\DokumenAkhirDosenController;
use App\Http\Controllers\Dosen\LaporanProgressDosenController;
use App\Http\Controllers\Dosen\NilaiDokumenAkhirController;
use App\Http\Controllers\Dosen\NilaiProposalController;
use App\Http\Controllers\Dosen\ProposalDosenController;
use App\Http\Controllers\Mahasiswa\JadwalSeminarMahasiswaController;
use App\Http\Controllers\Mahasiswa\DokumenAkhirMahasiswaController;
use App\Http\Controllers\Mahasiswa\ProposalMahasiswaController;
use App\Http\Controllers\Mahasiswa\NilaiMahasiswaController;
use App\Http\Controllers\Mahasiswa\TemplateMahasiswaController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn() => view('welcome'))->name('home')->middleware('guest');
Route::post('/login', [AuthenticatedSessionController::class, 'store'])->middleware('guest');

Route::prefix('admin')->middleware(['auth', 'role:admin'])->name('admin.')->group(function () {
    Route::get('/dashboard', fn() => view('admin.dashboard'))->name('dashboard');
    Route::resource('admin', AdminManagementController::class)->names('management.admin');
    Route::resource('mahasiswa', MahasiswaManagementController::class)->names('management.mahasiswa');
    Route::resource('dosen', DosenManagementController::class)->names('management.dosen');
    Route::resource('jadwal-sidang', JadwalSidangManagementController::class)->names('jadwal')->parameters(['jadwal-sidang' => 'jadwal']);
    Route::resource('proposal', ProposalManagementController::class)->names('proposal');
    Route::resource('template', TemplateManagementController::class)->names('template');
});

Route::prefix('mahasiswa')->middleware(['auth', 'role:mahasiswa'])->name('mahasiswa.')->group(function () {
    Route::get('/dashboard', fn() => view('mahasiswa.dashboard'))->name('dashboard');
    Route::get('jadwal-seminar', [JadwalSeminarMahasiswaController::class, 'index'])->name('jadwal-seminar');
    Route::resource('proposal', ProposalMahasiswaController::class)->names('proposals');
    Route::post('proposal/{id}/status', [ProposalMahasiswaController::class, 'updateStatus'])->name('proposals.updateStatus');
    Route::resource('dokumen-akhir', DokumenAkhirMahasiswaController::class)->names('dokumen-akhir');
    Route::resource('nilai', NilaiMahasiswaController::class)->only(['index', 'show'])->names('nilai');
    Route::get('template', [TemplateMahasiswaController::class, 'index'])->name('template.index');
});

Route::prefix('dosen')->middleware(['auth', 'role:dosen'])->name('dosen.')->group(function () {
    Route::get('/dashboard', fn() => view('dosen.dashboard'))->name('dashboard');
    Route::get('bimbingan', [BimbinganDosenController::class, 'index'])->name('bimbingan.index');
    Route::get('jadwal-bimbingan', [BimbinganDosenController::class, 'indexJadwal'])->name('jadwalbimbingan.index');
    Route::post('bimbingan/{id}/status', [BimbinganDosenController::class, 'updateStatus'])->name('bimbingan.updateStatus');
    Route::post('bimbingan/{id}/catatan', [BimbinganDosenController::class, 'addCatatan'])->name('bimbingan.addCatatan');
    Route::resource('proposal', ProposalDosenController::class)->only(['index', 'show'])->names('proposals');
    Route::post('proposal/{id}/status', [ProposalDosenController::class, 'updateStatus'])->name('proposals.updateStatus');
    Route::resource('laporan-progress', LaporanProgressDosenController::class)->only(['index', 'show', 'update']);
    Route::get('dokumen-akhir', [DokumenAkhirDosenController::class, 'index'])->name('dokumen-akhir.index');
    Route::get('dokumen-akhir/{id}', [DokumenAkhirDosenController::class, 'show'])->name('dokumen-akhir.show');
    Route::post('dokumen-akhir/{id}/status', [DokumenAkhirDosenController::class, 'updateStatus'])->name('dokumen-akhir.updateStatus');
    Route::resource('nilai-proposal', NilaiProposalController::class)->names('nilai-proposal');
    Route::resource('nilai-dokumen-akhir', NilaiDokumenAkhirController::class)->names('nilai-dokumen-akhir');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::view('/bantuan', 'static.general', ['page' => 'bantuan'])->name('bantuan');
    Route::view('/tentang', 'static.general', ['page' => 'tentang'])->name('tentang');
});

require __DIR__ . '/auth.php';