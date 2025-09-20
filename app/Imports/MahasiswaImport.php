<?php

namespace App\Imports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class MahasiswaImport implements ToModel, WithHeadingRow, WithValidation, WithBatchInserts, WithChunkReading
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new User([
            'name' => $row['name'],
            'email' => $row['email'],
            'password' => \Hash::make($row['password'] ?? 'UICImantap2025'),
            'no_hp' => $row['no_hp'] ?? null,
            'NIM' => $row['nim'],
            'prodi' => $row['prodi'],
            'role' => 'mahasiswa',
            'foto' => $row['foto'] ?? null,
        ]);
    }

    public function rules(): array
    {
        return [
            'nim' => 'required|numeric|digits_between:12,15|unique:users,NIM',
            'email' => 'required|email|unique:users,email',
            'name' => 'required|string|max:255',
            'prodi' => 'required|string',
            'no_hp' => 'nullable|numeric',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'nim.unique' => 'NIM baris :attribute sudah ada di database.',
            'email.unique' => 'Email baris :attribute sudah ada di database.',
            'nim.required' => 'Kolom NIM tidak boleh kosong.',
            'email.required' => 'Kolom email tidak boleh kosong.',
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