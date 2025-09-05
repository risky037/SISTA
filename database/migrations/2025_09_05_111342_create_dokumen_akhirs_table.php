<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDokumenAkhirsTable extends Migration
{
    public function up(): void
    {
        Schema::create('dokumen_akhirs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('mahasiswa_id');
            $table->string('judul');
            $table->string('file');
            $table->enum('tipe_dokumen', ['skripsi', 'tesis', 'dokumen_akhir'])->default('dokumen_akhir');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('keterangan')->nullable(); // catatan dosen/admin
            $table->timestamps();

            // relasi ke tabel users (role mahasiswa)
            $table->foreign('mahasiswa_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dokumen_akhirs');
    }
}
