<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBimbingansTable extends Migration
{
    public function up()
    {
        Schema::create('bimbingans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mahasiswa_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('dosen_id')->constrained('users')->onDelete('cascade');
            $table->date('tanggal_bimbingan');
            $table->time('waktu_mulai');
            $table->time('waktu_selesai');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('catatan_dosen')->nullable();
            $table->timestamps();

            $table->index(['dosen_id', 'tanggal_bimbingan']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('bimbingans');
    }
}
