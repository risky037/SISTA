<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'no_hp',
        'role',
        'NIM',
        'NIDN',
        'prodi',
        'bidang_keahlian',
        'foto',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Relationship - Mahasiswa mengajukan banyak proposal
     */
    public function proposalsAsMahasiswa()
    {
        return $this->hasMany(Proposal::class, 'mahasiswa_id');
    }

    /**
     * Relationship - Dosen membimbing banyak proposal
     */
    public function proposalsAsDosen()
    {
        return $this->hasMany(Proposal::class, 'dosen_pembimbing_id');
    }

    /**
     * Relationship - Mahasiswa booking banyak bimbingan
     */
    public function bimbingansAsMahasiswa()
    {
        return $this->hasMany(Bimbingan::class, 'mahasiswa_id');
    }

    /**
     * Relationship - Dosen menerima banyak bimbingan
     */
    public function bimbingansAsDosen()
    {
        return $this->hasMany(Bimbingan::class, 'dosen_id');
    }

    /**
     * Relationship - Mahasiswa mengirim banyak laporan progress
     */
    public function laporanProgress()
    {
        return $this->hasMany(LaporanProgress::class, 'mahasiswa_id');
    }

    public function mahasiswaBimbinganProposal()
    {
        return $this->hasMany(Proposal::class, 'dosen_pembimbing_id')->with('mahasiswa');
    }

    // Nilai yang diberikan oleh dosen ini
    public function nilaiDiberikan()
    {
        return $this->hasMany(Nilai::class, 'dosen_id');
    }

    // Nilai yang diterima oleh mahasiswa ini (melalui proposal)
    public function nilaiDiterima()
    {
        return $this->hasManyThrough(
            Nilai::class,
            Proposal::class,
            'mahasiswa_id', // Foreign key di Proposal
            'proposal_id',  // Foreign key di Nilai
            'id',           // Local key di User
            'id'            // Local key di Proposal
        );
    }
    public function dokumenAkhirsAsMahasiswa()
    {
        return $this->hasMany(DokumenAkhir::class, 'mahasiswa_id');
    }

    public function dokumenAkhirsAsDosen()
    {
        return $this->hasMany(DokumenAkhir::class, 'dosen_pembimbing_id');
    }

}
