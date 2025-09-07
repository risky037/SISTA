<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nilai extends Model
{
    use HasFactory;

    protected $table = 'nilais'; // tabel di database
    protected $fillable = [
        'mahasiswa_id',
        'dosen_id',
        'judul_tugas_akhir',
        'nilai',
        'keterangan'
    ];

    // Relasi ke mahasiswa
    public function mahasiswa()
    {
        return $this->belongsTo(User::class, 'mahasiswa_id');
    }

    // Relasi ke dosen
    public function dosen()
    {
        return $this->belongsTo(User::class, 'dosen_id');
    }
}
