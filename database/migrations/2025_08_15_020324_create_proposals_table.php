<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('proposals', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->text('abstrak');
            $table->string('dosen_pembimbing');
            $table->string('status')->default('Diajukan'); // Diajukan, Disetujui, Ditolak
            $table->date('tanggal_pengajuan')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('proposals');
    }
};
