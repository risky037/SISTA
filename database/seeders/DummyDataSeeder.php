<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Faker\Factory as Faker;
use App\Models\User;
use App\Models\Bimbingan;
use App\Models\Proposal;
use App\Models\Template;
use App\Models\DokumenAkhir;
use App\Models\Nilai;
use App\Models\Notification;

class DummyDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        $prodiNames = ['Informatika', 'Sistem Informasi', 'Teknik Komputer'];
        $bidangKeahlianNames = ['Kecerdasan Buatan', 'Jaringan Komputer', 'Basis Data', 'Pengembangan Web'];
        $gradeNames = ['A', 'B', 'C', 'D', 'E'];

        $dosen = [];
        for ($i = 0; $i < 5; $i++) {
            $dosen[] = User::create([
                'name' => $faker->name('male') . ' ' . $faker->lastName,
                'email' => $faker->unique()->safeEmail,
                'no_hp' => $faker->phoneNumber,
                'role' => 'dosen',
                'NIDN' => $faker->unique()->numerify('##########'),
                'bidang_keahlian' => $faker->randomElement($bidangKeahlianNames),
                'password' => Hash::make('password'),
            ]);
        }

        $mahasiswa = [];
        for ($i = 0; $i < 20; $i++) {
            $mahasiswa[] = User::create([
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'no_hp' => $faker->phoneNumber,
                'role' => 'mahasiswa',
                'NIM' => $faker->unique()->numerify('###########'),
                'prodi' => $faker->randomElement($prodiNames),
                'password' => Hash::make('password'),
            ]);
        }

        // Buat data bimbingan
        foreach ($mahasiswa as $mhs) {
            if (rand(0, 1)) {
                $dosenPembimbing = $faker->randomElement($dosen);
                $bimbinganStatus = $faker->randomElement(['pending', 'approved', 'rejected']);
                Bimbingan::create([
                    'mahasiswa_id' => $mhs->id,
                    'dosen_id' => $dosenPembimbing->id,
                    'tanggal_bimbingan' => $faker->dateTimeBetween('-1 month', '+1 month')->format('Y-m-d'),
                    'waktu_mulai' => $faker->time('H:i:s'),
                    'waktu_selesai' => $faker->time('H:i:s'),
                    'status' => $bimbinganStatus,
                    'catatan_dosen' => $bimbinganStatus === 'approved' ? $faker->sentence : null,
                ]);
            }
        }

        // Buat data proposal
        $proposals = collect(); // Gunakan koleksi untuk menyimpan proposal yang dibuat
        foreach ($mahasiswa as $mhs) {
            $proposalStatus = $faker->randomElement(['pending', 'diterima', 'ditolak']);
            $dosenPembimbing = $faker->randomElement($dosen);
            $proposal = Proposal::create([
                'mahasiswa_id' => $mhs->id,
                'dosen_pembimbing_id' => $dosenPembimbing->id,
                'judul' => 'Proposal ' . $faker->jobTitle,
                'deskripsi' => $faker->paragraph,
                'file_proposal' => 'proposal/' . Str::slug($mhs->name) . '_proposal.pdf',
                'status' => $proposalStatus,
                'catatan_dosen' => $proposalStatus !== 'pending' ? $faker->sentence : null,
            ]);

            $proposals->push($proposal); // Simpan proposal yang dibuat ke koleksi

            // Buat data nilai untuk proposal yang sudah diterima atau ditolak
            if ($proposalStatus !== 'pending') {
                Nilai::create([
                    'proposal_id' => $proposal->id,
                    'dosen_id' => $dosenPembimbing->id,
                    'grade' => $faker->randomElement($gradeNames),
                    'keterangan' => $faker->sentence,
                ]);
            }
        }

        // Buat data dokumen akhir
        $dokumenAkhirCollection = collect();
        foreach ($mahasiswa as $mhs) {
            if (rand(0, 1)) {
                $dosenPembimbing = $faker->randomElement($dosen);
                $dokumenStatus = $faker->randomElement(['pending', 'approved', 'rejected']);
                $dokumen = DokumenAkhir::create([
                    'mahasiswa_id' => $mhs->id,
                    'dosen_pembimbing_id' => $dosenPembimbing->id,
                    'judul' => 'Skripsi ' . $faker->jobTitle,
                    'deskripsi' => $faker->paragraph,
                    'file' => 'skripsi/' . Str::slug($mhs->name) . '_skripsi.pdf',
                    'status' => $dokumenStatus,
                    'catatan_dosen' => $dokumenStatus !== 'pending' ? $faker->sentence : null,
                ]);
                $dokumenAkhirCollection->push($dokumen);

                if ($dokumenStatus !== 'pending') {
                    Nilai::create([
                        'dokumen_akhir_id' => $dokumen->id,
                        'dosen_id' => $dosenPembimbing->id,
                        'grade' => $faker->randomElement($gradeNames),
                        'keterangan' => $faker->sentence,
                    ]);
                }
            }
        }

        // Buat data template
        for ($i = 0; $i < 3; $i++) {
            Template::create([
                'nama_template' => 'Template Proposal ' . $prodiNames[$i],
                'prodi' => $prodiNames[$i],
                'tipe_file' => 'pdf',
                'file_path' => 'template/template_' . Str::slug($prodiNames[$i]) . '.pdf',
                'aturan_format' => $faker->paragraph,
            ]);
        }

        // Buat data notifikasi
        foreach ($proposals as $proposal) {
            Notification::create([
                'user_id' => $proposal->mahasiswa_id,
                'title' => 'Proposal Anda telah disetujui',
                'message' => 'Selamat, proposal Anda telah disetujui oleh dosen pembimbing.',
                'link' => '/proposal/' . $proposal->id,
                'is_read' => $faker->boolean(50),
            ]);
        }
        // Tambahan dummy data untuk user dosen@email.com dan mahasiswa@email.com
        $dosenFixed = User::where('email', 'dosen@email.com')->first();
        $mahasiswaFixed = User::where('email', 'mahasiswa@email.com')->first();

        if ($dosenFixed && $mahasiswaFixed && !Proposal::where('mahasiswa_id', $mahasiswaFixed->id)->exists()) {
            // Buat proposal
            $proposalStatus = $faker->randomElement(['pending', 'diterima', 'ditolak']);
            $proposal = Proposal::create([
                'mahasiswa_id' => $mahasiswaFixed->id,
                'dosen_pembimbing_id' => $dosenFixed->id,
                'judul' => 'Proposal ' . $faker->jobTitle,
                'deskripsi' => $faker->paragraph,
                'file_proposal' => 'proposal/' . Str::slug($mahasiswaFixed->name) . '_proposal.pdf',
                'status' => $proposalStatus,
                'catatan_dosen' => $proposalStatus !== 'pending' ? $faker->sentence : null,
            ]);

            if ($proposalStatus !== 'pending') {
                Nilai::create([
                    'proposal_id' => $proposal->id,
                    'dosen_id' => $dosenFixed->id,
                    'grade' => $faker->randomElement($gradeNames),
                    'keterangan' => $faker->sentence,
                ]);
            }

            // Bimbingan
            Bimbingan::create([
                'mahasiswa_id' => $mahasiswaFixed->id,
                'dosen_id' => $dosenFixed->id,
                'tanggal_bimbingan' => $faker->dateTimeBetween('-1 month', '+1 month')->format('Y-m-d'),
                'waktu_mulai' => $faker->time('H:i:s'),
                'waktu_selesai' => $faker->time('H:i:s'),
                'status' => 'approved',
                'catatan_dosen' => $faker->sentence,
            ]);

            // Dokumen akhir
            $dokumenStatus = $faker->randomElement(['pending', 'approved', 'rejected']);
            $dokumen = DokumenAkhir::create([
                'mahasiswa_id' => $mahasiswaFixed->id,
                'dosen_pembimbing_id' => $dosenFixed->id,
                'judul' => 'Skripsi ' . $faker->jobTitle,
                'deskripsi' => $faker->paragraph,
                'file' => 'skripsi/' . Str::slug($mahasiswaFixed->name) . '_skripsi.pdf',
                'status' => $dokumenStatus,
                'catatan_dosen' => $dokumenStatus !== 'pending' ? $faker->sentence : null,
            ]);

            if ($dokumenStatus !== 'pending') {
                Nilai::create([
                    'dokumen_akhir_id' => $dokumen->id,
                    'dosen_id' => $dosenFixed->id,
                    'grade' => $faker->randomElement($gradeNames),
                    'keterangan' => $faker->sentence,
                ]);
            }

            // Notifikasi
            Notification::create([
                'user_id' => $mahasiswaFixed->id,
                'title' => 'Proposal Anda telah disetujui',
                'message' => 'Proposal Anda telah ditinjau oleh dosen pembimbing.',
                'link' => '/proposal/' . $proposal->id,
                'is_read' => false,
            ]);
        }

    }
}