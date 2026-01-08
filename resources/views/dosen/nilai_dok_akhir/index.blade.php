@extends('layouts.app')

@section('title', 'Penilaian Dokumen Akhir')

@section('content')

    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Penilaian Dokumen Akhir</h1>
            <p class="text-gray-500 text-sm mt-1">Kelola nilai Skripsi/Tesis mahasiswa bimbingan Anda.</p>
        </div>
        <nav class="text-sm text-gray-500">
            <ol class="list-reset flex">
                <li><a href="{{ route('dosen.dashboard') }}" class="hover:text-green-600">Home</a></li>
                <li><span class="mx-2">/</span></li>
                <li class="text-gray-700">Nilai Dokumen Akhir</li>
            </ol>
        </nav>
    </div>

    @if (session('success'))
        <div
            class="mb-4 bg-green-50 text-green-700 p-4 rounded-lg border-l-4 border-green-500 shadow-sm flex items-center justify-between">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span>{{ session('success') }}</span>
            </div>
            <button onclick="this.parentElement.remove()" class="text-green-700 hover:text-green-900">&times;</button>
        </div>
    @endif

    @if (session('error'))
        <div class="mb-4 bg-red-50 text-red-700 p-4 rounded-lg border-l-4 border-red-500 shadow-sm flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">


        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl shadow-sm border border-green-100 h-full overflow-hidden">
                <div class="p-4 border-b border-green-100 bg-green-50">
                    <h2 class="font-semibold text-green-800 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" />
                            <path fill-rule="evenodd"
                                d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z"
                                clip-rule="evenodd" />
                        </svg>
                        Menunggu Penilaian
                    </h2>
                </div>

                <div class="p-0">
                    @forelse ($belumDinilai as $dokumen)
                        <div
                            class="p-4 border-b border-gray-100 last:border-0 hover:bg-green-50/50 transition duration-150 group">
                            <div class="flex justify-between items-start mb-2">
                                <span
                                    class="text-xs font-bold px-2 py-1 bg-green-100 text-green-700 rounded-full border border-green-200">
                                    {{ $dokumen->mahasiswa->NIM ?? 'NIM' }}
                                </span>
                                <span
                                    class="text-xs font-medium text-gray-500 bg-gray-100 px-2 py-1 rounded border border-gray-200 group-hover:bg-white transition">
                                    {{ $dokumen->nama_bab ?? 'Bab ' . $dokumen->bab }}
                                </span>
                            </div>
                            <h3 class="font-bold text-gray-800">{{ $dokumen->mahasiswa->name }}</h3>
                            <p class="text-sm text-gray-600 line-clamp-2 mt-1 mb-3" title="{{ $dokumen->judul }}">
                                {{ $dokumen->judul }}
                            </p>

                            <div class="flex gap-2 mt-3">
                                @if ($dokumen->file)
                                    <a href="{{ $dokumen->file_url }}" target="_blank"
                                        class="flex-1 text-center px-3 py-2 text-xs border border-green-200 text-green-700 rounded-lg hover:bg-green-100 transition font-medium">
                                        Lihat File
                                    </a>
                                @endif
                                <button
                                    onclick="openGradeModal('{{ $dokumen->id }}', '{{ $dokumen->mahasiswa->name }}', '{{ addslashes($dokumen->judul) }}', '{{ $dokumen->nama_bab ?? 'Bab ' . $dokumen->bab }}')"
                                    class="flex-1 text-center px-3 py-2 text-xs bg-green-600 text-white rounded-lg hover:bg-green-700 shadow-sm transition hover:shadow-md font-medium">
                                    Beri Nilai
                                </button>
                            </div>
                        </div>
                    @empty
                        <div class="p-8 text-center text-gray-400">
                            <div class="bg-green-50 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-300" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <p class="text-sm">Semua dokumen telah dinilai!</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>


        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-sm border border-green-100 overflow-hidden">
                <div class="p-4 border-b border-green-100 flex justify-between items-center bg-green-50">
                    <h2 class="font-semibold text-green-800">Riwayat Penilaian</h2>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="text-xs text-gray-500 uppercase bg-gray-50 border-b border-gray-100">
                            <tr>
                                <th class="px-6 py-3">Mahasiswa</th>
                                <th class="px-6 py-3">Dokumen</th>
                                <th class="px-6 py-3 text-center">Nilai</th>
                                <th class="px-6 py-3">Keterangan</th>
                                <th class="px-6 py-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($sudahDinilai as $nilai)
                                <tr class="bg-white hover:bg-green-50/30 transition">
                                    <td class="px-6 py-4 font-medium text-gray-900">
                                        {{ $nilai->dokumenAkhir->mahasiswa->name ?? '-' }}
                                        <div class="text-xs text-green-600 font-normal mt-0.5">
                                            {{ $nilai->dokumenAkhir->mahasiswa->NIM ?? '' }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex flex-col">
                                            <span class="text-xs font-semibold text-green-700 mb-1">
                                                {{ $nilai->dokumenAkhir->nama_bab ?? 'Bab ' . ($nilai->dokumenAkhir->bab ?? '-') }}
                                            </span>
                                            <span class="max-w-xs truncate text-gray-600"
                                                title="{{ $nilai->dokumenAkhir->judul ?? '-' }}">
                                                {{ $nilai->dokumenAkhir->judul ?? '-' }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-center">

                                        <span
                                            class="px-3 py-1 rounded-full text-xs font-bold border
                                            {{ in_array($nilai->grade, ['A', 'A+'])
                                                ? 'bg-green-100 text-green-700 border-green-200'
                                                : (in_array($nilai->grade, ['B+', 'B', 'B-'])
                                                    ? 'bg-blue-100 text-blue-700 border-blue-200'
                                                    : (in_array($nilai->grade, ['C+', 'C', 'C-'])
                                                        ? 'bg-yellow-100 text-yellow-700 border-yellow-200'
                                                        : 'bg-red-100 text-red-700 border-red-200')) }}">
                                            {{ $nilai->grade }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-gray-500 max-w-xs truncate">
                                        {{ $nilai->keterangan ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <button
                                            onclick="openEditModal('{{ $nilai->id }}', '{{ $nilai->dokumenAkhir->mahasiswa->name }}', '{{ $nilai->grade }}', '{{ addslashes($nilai->keterangan) }}')"
                                            class="text-green-600 hover:text-green-800 font-medium text-xs hover:underline transition">
                                            Edit
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                        Belum ada riwayat penilaian dokumen.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    <div id="gradeModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog"
        aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"
                onclick="closeGradeModal()"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div
                class="inline-block align-bottom bg-white rounded-xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full border-t-4 border-green-600">
                <form action="{{ route('dosen.nilai-dokumen-akhir.store') }}" method="POST" id="gradeForm">
                    @csrf
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                <h3 class="text-xl leading-6 font-bold text-gray-900" id="modal-title">
                                    Input Nilai Dokumen
                                </h3>


                                <div class="mt-4 p-4 bg-green-50 rounded-lg border border-green-100">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <p class="text-xs text-green-600 font-semibold uppercase tracking-wide">
                                                Mahasiswa</p>
                                            <p class="text-md font-bold text-gray-800" id="modalStudentName">-</p>
                                        </div>
                                        <span
                                            class="text-xs font-bold text-green-700 bg-white px-2 py-1 rounded border border-green-200 shadow-sm"
                                            id="modalBabInfo">-</span>
                                    </div>
                                    <div class="mt-3 pt-3 border-t border-green-200">
                                        <p class="text-xs text-green-600 font-semibold uppercase tracking-wide">Judul</p>
                                        <p class="text-sm text-gray-700 mt-1 italic" id="modalDocTitle">-</p>
                                    </div>
                                </div>

                                <input type="hidden" name="dokumen_akhir_id" id="modalDocId">

                                <div class="mt-5">
                                    <label for="grade" class="block text-sm font-medium text-gray-700">Grade / Nilai
                                        Huruf</label>
                                    <select name="grade" id="modalGradeSelect" required
                                        class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm rounded-lg border transition">
                                        <option value="">-- Pilih Nilai --</option>
                                        @foreach (['A+', 'A', 'A-', 'B+', 'B', 'B-', 'C+', 'C', 'C-', 'D', 'E'] as $g)
                                            <option value="{{ $g }}">{{ $g }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mt-4">
                                    <label for="keterangan" class="block text-sm font-medium text-gray-700">Catatan /
                                        Keterangan</label>
                                    <textarea name="keterangan" id="modalKeterangan" rows="3"
                                        class="mt-1 shadow-sm focus:ring-green-500 focus:border-green-500 block w-full sm:text-sm border border-gray-300 rounded-lg p-2 transition"
                                        placeholder="Tambahkan catatan revisi atau komentar nilai..."></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse border-t border-gray-100">
                        <button type="submit"
                            class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:ml-3 sm:w-auto sm:text-sm transition">
                            Simpan Nilai
                        </button>
                        <button type="button" onclick="closeGradeModal()"
                            class="mt-3 w-full inline-flex justify-center rounded-lg border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition">
                            Batal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function openGradeModal(docId, studentName, docTitle, babInfo) {
            const form = document.getElementById('gradeForm');
            form.action = "{{ route('dosen.nilai-dokumen-akhir.store') }}";
            const existingMethod = form.querySelector('input[name="_method"]');
            if (existingMethod) existingMethod.remove();
            document.getElementById('modalDocId').value = docId;
            document.getElementById('modalStudentName').textContent = studentName;
            document.getElementById('modalDocTitle').textContent = docTitle;
            document.getElementById('modalBabInfo').textContent = babInfo;
            document.getElementById('modalGradeSelect').value = "";
            document.getElementById('modalKeterangan').value = "";
            document.getElementById('modal-title').textContent = "Input Nilai Dokumen";
            document.getElementById('gradeModal').classList.remove('hidden');
        }

        function openEditModal(nilaiId, studentName, currentGrade, currentKeterangan) {
            const form = document.getElementById('gradeForm');
            let url = "{{ route('dosen.nilai-dokumen-akhir.update', ':id') }}";
            url = url.replace(':id', nilaiId);
            form.action = url;
            let methodInput = form.querySelector('input[name="_method"]');
            if (!methodInput) {
                methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                methodInput.value = 'PUT';
                form.appendChild(methodInput);
            }
            document.getElementById('modalStudentName').textContent = studentName;
            document.getElementById('modalDocTitle').textContent = "Edit Data Nilai";
            document.getElementById('modalBabInfo').textContent = "-";
            document.getElementById('modalGradeSelect').value = currentGrade;
            document.getElementById('modalKeterangan').value = currentKeterangan;
            document.getElementById('modal-title').textContent = "Edit Nilai";
            document.getElementById('gradeModal').classList.remove('hidden');
        }

        function closeGradeModal() {
            document.getElementById('gradeModal').classList.add('hidden');
        }
    </script>
@endpush
