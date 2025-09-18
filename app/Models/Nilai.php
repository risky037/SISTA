<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nilai extends Model
{
    use HasFactory;

    protected $table = 'nilais';
    protected $fillable = [
        'proposal_id',
        'dokumen_akhir_id',
        'dosen_id',
        'grade',
        'keterangan',
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(User::class, 'mahasiswa_id');
    }

    public function dosen()
    {
        return $this->belongsTo(User::class, 'dosen_id');
    }

    public function proposal()
    {
        return $this->belongsTo(Proposal::class, 'proposal_id');
    }

    public function dokumenAkhir()
    {
        return $this->belongsTo(DokumenAkhir::class, 'dokumen_akhir_id');
    }
}
