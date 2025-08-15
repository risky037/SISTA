<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Dashboard Mahasiswa – Sistem Informasi Tugas Akhir</title>

    <!-- Tailwind CSS & FontAwesome -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />

    <style>
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-thumb { background-color: #4a5568; border-radius: 3px; }
    </style>
</head>
<body class="bg-gray-100 font-sans text-gray-800">
    <div class="flex min-h-screen">
        
        <!-- Sidebar -->
        <aside class="flex flex-col w-64 bg-white border-r border-gray-200">
            <div class="flex items-center gap-2 px-4 py-3 border-b border-gray-200">
                <i class="fas fa-user-graduate text-green-600 text-2xl"></i>
                <span class="text-lg font-normal text-gray-900">Dashboard Mahasiswa</span>
            </div>

            <nav class="flex-1 overflow-y-auto px-2 py-4 text-gray-600 text-sm">
                <div class="mb-4 uppercase text-xs font-semibold text-gray-400">Menu</div>
                <ul class="space-y-1">
                    <li><button onclick="showContent('proposal')" class="menu-btn"><i class="fas fa-upload"></i> Ajukan Proposal</button></li>
                    <li><button onclick="showContent('status')" class="menu-btn"><i class="fas fa-search"></i> Status Proposal</button></li>
                    <li><button onclick="showContent('revisi')" class="menu-btn"><i class="fas fa-paperclip"></i> Upload Revisi</button></li>
                    <li><button onclick="showContent('jadwal')" class="menu-btn"><i class="fas fa-calendar-alt"></i> Jadwal Bimbingan</button></li>
                    <li><button onclick="showContent('template')" class="menu-btn"><i class="fas fa-download"></i> Download Template</button></li>
                    <li><button onclick="showContent('profil')" class="menu-btn"><i class="fas fa-user"></i> Profil Mahasiswa</button></li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col">
            
            <!-- Top Bar -->
            <header class="flex items-center justify-between bg-green-700 px-6 py-3 text-white">
                <div class="flex items-center gap-2">
                    <i class="fas fa-id-card"></i>
                    <span class="font-mono text-sm">NIM: 12345678</span>
                </div>
                <span>Budi Mahasiswa</span>
            </header>

            <!-- Dynamic Content -->
            <main class="flex-1 overflow-y-auto p-6 bg-gray-100">
                <div id="content" class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-md">
                    <p>Silakan pilih salah satu menu di sidebar untuk menampilkan informasi lengkap.</p>
                </div>
            </main>
        </div>
    </div>

    <!-- Script -->
    <script>
        document.querySelectorAll('.menu-btn').forEach(btn => {
            btn.classList.add("w-full", "text-left", "flex", "items-center", "gap-2", "px-4", "py-2", "rounded", "hover:bg-gray-100");
        });

        function showContent(menu) {
            const content = document.getElementById('content');

            const templates = {
                proposal: `
                    <h2 class="section-title"><i class="fas fa-upload text-green-600"></i> Formulir Pengajuan Proposal</h2>
                    <form class="space-y-4">
                        <div>
                            <label class="block font-semibold mb-1">Judul Proposal</label>
                            <input type="text" class="input-field" placeholder="Masukkan judul tugas akhir..." />
                        </div>
                        <div>
                            <label class="block font-semibold mb-1">Abstrak</label>
                            <textarea rows="4" class="input-field" placeholder="Tulis abstrak proposal..."></textarea>
                        </div>
                        <div>
                            <label class="block font-semibold mb-1">Pilih Dosen Pembimbing</label>
                            <select class="input-field">
                                <option>-- Pilih --</option>
                                <option>Dr. Andi Saputra, M.Kom</option>
                                <option>Prof. Lina Nuraini, S.T., M.T.</option>
                            </select>
                        </div>
                        <button type="submit" class="btn-primary">Ajukan</button>
                    </form>
                `,
                status: `
                    <h2 class="section-title"><i class="fas fa-search text-green-600"></i> Status Proposal</h2>
                    <ul class="space-y-2">
                        <li><strong>Judul:</strong> Sistem Informasi Skripsi Mahasiswa</li>
                        <li><strong>Status:</strong> <span class="text-green-700">Disetujui</span></li>
                        <li><strong>Tanggal Pengajuan:</strong> 5 Juli 2025</li>
                        <li><strong>Catatan:</strong> Lanjutkan ke tahap bimbingan pertama</li>
                    </ul>
                `,
                revisi: `
                    <h2 class="section-title"><i class="fas fa-paperclip text-green-600"></i> Upload Revisi Proposal</h2>
                    <form class="space-y-4">
                        <div>
                            <label class="block font-semibold mb-1">Upload File (PDF)</label>
                            <input type="file" class="input-field" />
                        </div>
                        <div>
                            <label class="block font-semibold mb-1">Catatan Revisi</label>
                            <textarea rows="3" class="input-field" placeholder="Tulis catatan revisi..."></textarea>
                        </div>
                        <button type="submit" class="btn-primary">Upload Revisi</button>
                    </form>
                `,
                jadwal: `
                    <h2 class="section-title"><i class="fas fa-calendar-alt text-green-600"></i> Jadwal Bimbingan</h2>
                    <table class="w-full border border-gray-300">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="table-head">Hari</th>
                                <th class="table-head">Jam</th>
                                <th class="table-head">Dosen</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="table-cell">Senin</td>
                                <td class="table-cell">09:00 - 10:00</td>
                                <td class="table-cell">Dr. Andi Saputra</td>
                            </tr>
                            <tr>
                                <td class="table-cell">Rabu</td>
                                <td class="table-cell">13:00 - 14:00</td>
                                <td class="table-cell">Prof. Lina Nuraini</td>
                            </tr>
                        </tbody>
                    </table>
                `,
                template: `
                    <h2 class="section-title"><i class="fas fa-download text-green-600"></i> Download Template Skripsi</h2>
                    <p>Gunakan template resmi berikut untuk menyusun skripsi:</p>
                    <ul class="list-disc ml-5 mt-2 space-y-1">
                        <li><a href="#" class="text-green-700 hover:underline">📄 Template DOCX</a></li>
                        <li><a href="#" class="text-green-700 hover:underline">📄 Template PDF</a></li>
                    </ul>
                `,
                profil: `
                    <h2 class="section-title"><i class="fas fa-user text-green-600"></i> Profil Mahasiswa</h2>
                    <ul class="space-y-2">
                        <li><strong>NIM:</strong> 12345678</li>
                        <li><strong>Nama:</strong> Budi Mahasiswa</li>
                        <li><strong>Prodi:</strong> Teknik Informatika</li>
                        <li><strong>Email:</strong> budi@example.com</li>
                        <li><strong>No. HP:</strong> 081234567890</li>
                    </ul>
                `
            };

            content.innerHTML = templates[menu] || `<p>Pilih menu di sidebar untuk menampilkan informasi.</p>`;
        }
    </script>

    <style>
        .menu-btn { cursor: pointer; }
        .section-title { font-size: 1.25rem; font-weight: 600; margin-bottom: 1rem; display: flex; align-items: center; gap: 0.5rem; }
        .input-field { width: 100%; border: 1px solid #d1d5db; border-radius: 0.25rem; padding: 0.5rem 0.75rem; }
        .btn-primary { background-color: #16a34a; color: white; padding: 0.5rem 1rem; border-radius: 0.25rem; }
        .btn-primary:hover { background-color: #15803d; }
        .table-head { border: 1px solid #d1d5db; padding: 0.5rem; text-align: left; }
        .table-cell { border: 1px solid #d1d5db; padding: 0.5rem; }
    </style>
</body>
</html>
