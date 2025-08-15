<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

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
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Mahasiswa
        User::create([
            'name' => 'Mahasiswa',
            'email' => 'mahasiswa@email.com',
            'password' => Hash::make('password'),
            'role' => 'mahasiswa',
        ]);

        // Dosen
        User::create([
            'name' => 'Dosen',
            'email' => 'dosen@email.com',
            'password' => Hash::make('password'),
            'role' => 'dosen',
        ]);
    }
}
