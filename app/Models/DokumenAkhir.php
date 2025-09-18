<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class DokumenAkhir extends Model
{
    use HasFactory;

    protected $table = 'dokumen_akhirs';

    protected $fillable = [
        'mahasiswa_id',
        'dosen_pembimbing_id',
        'judul',
        'file',
        'status',
        'keterangan',
    ];


    /**
     * Relasi ke model User (mahasiswa).
     */
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
        return $this->hasOne(Nilai::class, 'dokumen_akhir_id');
    }

    /**
     * Relasi opsional ke Proposal (jika ada).
     */
    public function proposal()
    {
        return $this->hasOne(Proposal::class, 'dokumen_id');
    }

    /**
     * Helper untuk ambil URL file dokumen.
     */
    public function getFileUrlAttribute()
    {
        return $this->file ? asset('storage/' . $this->file) : null;
    }

    /**
     * Scope: hanya ambil dokumen milik mahasiswa yang login.
     */
    public function scopeOwn($query)
    {
        return $query->where('mahasiswa_id', Auth::id());
    }

    /**
     * Scope: filter berdasarkan judul.
     */
    public function scopeSearchJudul($query, $keyword)
    {
        return $query->where('judul', 'like', '%' . $keyword . '%');
    }

    /**
     * Accessor: tampilkan judul dengan format Title Case.
     */
    public function getFormattedJudulAttribute()
    {
        return ucwords(strtolower($this->judul));
    }
}
