<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Bimbingan;
use App\Models\Proposal;
use App\Models\Template;
use App\Models\Nilai;
use App\Models\Notification;

class DummyDataSeeder extends Seeder
{
    public function run(): void
    {
        $demoLink = "javascript:alert('Ini adalah link demo. Di sistem nyata, ini akan mengarahkan Anda ke detail halaman.')";

        $dataDosen = [
            ['name' => 'Dr. Ir. Budi Santoso, M.Kom', 'nidn' => '0012038501', 'bidang' => 'Kecerdasan Buatan', 'email' => 'budi.santoso@univ.ac.id'],
            ['name' => 'Siti Aminah, S.T., M.T.', 'nidn' => '0025078802', 'bidang' => 'Jaringan Komputer', 'email' => 'siti.aminah@univ.ac.id'],
            ['name' => 'Ahmad Hidayat, M.Cs', 'nidn' => '0015098203', 'bidang' => 'Pengembangan Web', 'email' => 'ahmad.h@univ.ac.id'],
            ['name' => 'Dr. Rina Wijaya, M.IT', 'nidn' => '0004117904', 'bidang' => 'Basis Data', 'email' => 'rina.w@univ.ac.id'],
        ];

        $dosenModels = [];
        foreach ($dataDosen as $d) {
            $dosenModels[] = User::create([
                'name' => $d['name'],
                'email' => $d['email'],
                'no_hp' => '0812' . rand(10000000, 99999999),
                'role' => 'dosen',
                'NIDN' => $d['nidn'],
                'bidang_keahlian' => $d['bidang'],
                'password' => Hash::make('password'),
            ]);
        }

        $dataMahasiswa = [
            ['name' => 'Rizky Pratama', 'nim' => '20210001', 'prodi' => 'Informatika', 'email' => 'rizky@student.ac.id'],
            ['name' => 'Putri Indah', 'nim' => '20210002', 'prodi' => 'Sistem Informasi', 'email' => 'putri@student.ac.id'],
            ['name' => 'Fajar Nugraha', 'nim' => '20210003', 'prodi' => 'Teknik Komputer', 'email' => 'fajar@student.ac.id'],
            ['name' => 'Dewi Lestari', 'nim' => '20210004', 'prodi' => 'Informatika', 'email' => 'dewi@student.ac.id'],
        ];

        $mhsModels = [];
        foreach ($dataMahasiswa as $m) {
            $mhsModels[] = User::create([
                'name' => $m['name'],
                'email' => $m['email'],
                'no_hp' => '0857' . rand(10000000, 99999999),
                'role' => 'mahasiswa',
                'NIM' => $m['nim'],
                'prodi' => $m['prodi'],
                'password' => Hash::make('password'),
            ]);
        }

        $judulSkripsi = [
            'Implementasi Algoritma CNN untuk Deteksi Masker Medis',
            'Analisis Perbandingan Framework Flutter dan React Native',
            'Sistem Pendukung Keputusan Pemilihan Karyawan Terbaik Berbasis AHP',
            'Optimasi Jaringan WiFi Menggunakan Metode Load Balancing',
            'Pengembangan Aplikasi E-Commerce Berbasis Microservices'
        ];

        foreach ($mhsModels as $key => $mhs) {
            $dsn = $dosenModels[$key % count($dosenModels)]; // Bagi rata dosen
            $judul = $judulSkripsi[$key % count($judulSkripsi)];

            $proposal = Proposal::create([
                'mahasiswa_id' => $mhs->id,
                'dosen_pembimbing_id' => $dsn->id,
                'judul' => $judul,
                'deskripsi' => 'Penelitian ini berfokus pada analisis efisiensi sistem dalam skala besar menggunakan teknologi terbaru.',
                'file_proposal' => 'proposal/dummy_file.pdf',
                'status' => 'diterima',
                'catatan_dosen' => 'Judul menarik, lanjutkan ke bab berikutnya.',
            ]);

            Nilai::create([
                'proposal_id' => $proposal->id,
                'dosen_id' => $dsn->id,
                'grade' => 'A',
                'keterangan' => 'Presentasi sangat baik dan penguasaan materi mendalam.',
            ]);

            Bimbingan::create([
                'mahasiswa_id' => $mhs->id,
                'dosen_id' => $dsn->id,
                'tanggal_bimbingan' => now()->subDays(rand(1, 10))->format('Y-m-d'),
                'waktu_mulai' => '10:00:00',
                'waktu_selesai' => '11:00:00',
                'status' => 'approved',
                'catatan_dosen' => 'Perbaiki metodologi pada poin 3.2.',
            ]);

            Notification::create([
                'user_id' => $mhs->id,
                'title' => 'Proposal Disetujui',
                'message' => 'Selamat, proposal "' . $judul . '" telah disetujui.',
                'link' => $demoLink,
                'is_read' => false,
            ]);
        }

        $prodis = ['Informatika', 'Sistem Informasi', 'Teknik Komputer'];
        foreach ($prodis as $p) {
            Template::create([
                'nama_template' => 'Panduan Penulisan Skripsi ' . $p,
                'prodi' => $p,
                'tipe_file' => 'pdf',
                'file_path' => 'template/guide.pdf',
                'aturan_format' => 'Margin: 4433, Font: Times New Roman, Spasi: 1.5.',
            ]);
        }
    }
}
