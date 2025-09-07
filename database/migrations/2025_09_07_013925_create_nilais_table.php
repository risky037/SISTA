<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('nilais', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('mahasiswa_id');
        $table->unsignedBigInteger('dosen_id')->nullable();
        $table->string('judul_tugas_akhir');
        $table->integer('nilai')->nullable();
        $table->text('keterangan')->nullable();
        $table->timestamps();

        $table->foreign('mahasiswa_id')->references('id')->on('users')->onDelete('cascade');
        $table->foreign('dosen_id')->references('id')->on('users')->onDelete('set null');
    });
}

    public function down(): void
    {
        Schema::dropIfExists('nilais');
    }
};
