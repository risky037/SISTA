<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Proposal extends Model
{
    use HasFactory;

    protected $fillable = [
        'mahasiswa_id',
        'dosen_pembimbing_id',
        'judul',
        'deskripsi',
        'file_proposal',
        'status',
        'catatan_dosen',
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(User::class, 'mahasiswa_id');
    }

    public function dosen()
    {
        return $this->belongsTo(User::class, 'dosen_pembimbing_id');
    }

    public function nilai()
    {
        return $this->hasOne(Nilai::class);
    }

}
