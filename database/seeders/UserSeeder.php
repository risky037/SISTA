<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Admin',
            'email' => 'admin@email.com',
            'no_hp' => '081234567890',
            'role' => 'admin',
            'NIM' => null,
            'NIDN' => null,
            'prodi' => null,
            'bidang_keahlian' => null,
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
        ]);

        // Mahasiswa
        User::create([
            'name' => 'Mahasiswa',
            'email' => 'mahasiswa@email.com',
            'no_hp' => '089876543210',
            'role' => 'mahasiswa',
            'NIM' => '12345678901',
            'NIDN' => null,
            'prodi' => 'Informatika',
            'bidang_keahlian' => null,
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
        ]);

        // Dosen
        User::create([
            'name' => 'Dosen Pembimbing',
            'email' => 'dosen@email.com',
            'no_hp' => '085012345678',
            'role' => 'dosen',
            'NIM' => null,
            'NIDN' => '9876543210',
            'prodi' => null,
            'bidang_keahlian' => 'Pengembangan Web',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
        ]);
    }
}