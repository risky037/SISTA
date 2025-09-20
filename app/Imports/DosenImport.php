<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class DosenImport implements ToModel, WithHeadingRow, WithValidation, WithBatchInserts, WithChunkReading
{
    public function model(array $row)
    {
        return new User([
            'name' => $row['name'],
            'email' => $row['email'],
            'password' => Hash::make($row['password'] ?? 'UICImantap2025'),
            'no_hp' => $row['no_hp'] ?? null,
            'NIDN' => $row['nidn'],
            'bidang_keahlian' => $row['bidang_keahlian'],
            'role' => 'dosen',
            'foto' => $row['foto'] ?? null,
        ]);
    }

    public function rules(): array
    {
        return [
            'nidn' => 'required|numeric|digits_between:8,10|unique:users,NIDN',
            'email' => 'required|email|unique:users,email',
            'name' => 'required|string|max:255',
            'bidang_keahlian' => 'required|string',
            'no_hp' => 'nullable|numeric',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'nidn.required' => 'NIDN tidak boleh kosong.',
            'nidn.unique' => 'NIDN baris :attribute sudah ada di database.',
            'email.unique' => 'Email baris :attribute sudah ada di database.',
            'email.required' => 'Email tidak boleh kosong.',
        ];
    }

    public function batchSize(): int
    {
        return 1000;
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}
