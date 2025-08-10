<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLaporanProgressTable extends Migration
{
    public function up()
    {
        Schema::create('laporan_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mahasiswa_id')->constrained('users')->onDelete('cascade');
            $table->string('judul_laporan');
            $table->text('deskripsi')->nullable();
            $table->string('file_laporan')->nullable();
            $table->enum('status', ['submitted', 'reviewed'])->default('submitted');
            $table->text('catatan_dosen')->nullable();
            $table->timestamps();

            $table->index('status');
        });
    }

    public function down()
    {
        Schema::dropIfExists('laporan_progress');
    }
}
