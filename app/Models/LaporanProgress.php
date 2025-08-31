<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanProgress extends Model
{
    use HasFactory;

    protected $fillable = [
        'mahasiswa_id',
        'judul_laporan',
        'deskripsi',
        'file_laporan',
        'status',
        'catatan_dosen',
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(User::class, 'mahasiswa_id');
    }

    public function proposal()
    {
        return $this->hasOne(Proposal::class, 'mahasiswa_id', 'mahasiswa_id');
    }

}
