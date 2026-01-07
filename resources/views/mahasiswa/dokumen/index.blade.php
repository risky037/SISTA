@extends('layouts.app')

@section('title', 'Dokumen Akhir Skripsi')

@push('styles')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .modal-animate-in {
            animation: fadeIn 0.3s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
@endpush

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-8">
            <div>
                <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Dokumen Tugas Akhir</h1>
                <p class="text-gray-500 mt-2 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Kelola kemajuan skripsi Anda dengan mengunggah dokumen per bab secara sistematis.
                </p>
            </div>
            <div class="mt-4 md:mt-0">
                <span
                    class="inline-flex items-center px-4 py-2 bg-blue-50 text-blue-700 rounded-full text-sm font-medium border border-blue-100">
                    Tahun Akademik 2023/2024
                </span>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm">
                <p class="text-sm text-gray-500 font-medium">Total Bab</p>
                <p class="text-2xl font-bold text-gray-800">{{ count($chapters) }}</p>
            </div>
            <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm">
                <p class="text-sm text-gray-500 font-medium">Sudah Disetujui</p>
                <p class="text-2xl font-bold text-green-600">{{ collect($uploads)->where('status', 'approved')->count() }}
                </p>
            </div>
            <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm">
                <p class="text-sm text-gray-500 font-medium">Perlu Revisi</p>
                <p class="text-2xl font-bold text-red-600">{{ collect($uploads)->where('status', 'rejected')->count() }}</p>
            </div>
        </div>

        <div class="space-y-4">
            @foreach ($chapters as $key => $chapterName)
                @php
                    $data = $uploads[$key] ?? null;
                    $status = $data ? $data->status : 'belum_upload';

                    $config = match ($status) {
                        'approved' => ['color' => 'green', 'label' => 'Disetujui', 'icon' => 'check-circle'],
                        'rejected' => ['color' => 'red', 'label' => 'Butuh Revisi', 'icon' => 'exclamation-circle'],
                        'pending' => ['color' => 'yellow', 'label' => 'Menunggu Review', 'icon' => 'clock'],
                        default => ['color' => 'gray', 'label' => 'Belum Diunggah', 'icon' => 'minus-circle'],
                    };
                @endphp

                <div
                    class="group bg-white border border-gray-200 rounded-xl transition-all duration-200 hover:shadow-md hover:border-blue-300">
                    <div class="p-5 flex flex-col md:flex-row items-start md:items-center justify-between gap-4">

                        <div class="flex items-start space-x-4">
                            <div class="p-3 bg-{{ $config['color'] }}-100 rounded-lg text-{{ $config['color'] }}-600">
                                <i class="fas fa-{{ $config['icon'] }} text-xl"></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-gray-900 group-hover:text-blue-600 transition-colors">
                                    {{ $chapterName }}</h3>
                                <div class="mt-1 flex flex-col space-y-1">
                                    @if ($data)
                                        <span class="text-xs text-gray-400 flex items-center">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            Update: {{ $data->updated_at->diffForHumans() }}
                                        </span>
                                        @if ($data->catatan_dosen)
                                            <div class="mt-2 p-2 bg-red-50 border-l-2 border-red-400">
                                                <p class="text-xs text-red-700 leading-relaxed italic">
                                                    <span class="font-bold">Catatan Dosen:</span> {{ $data->catatan_dosen }}
                                                </p>
                                            </div>
                                        @endif
                                    @else
                                        <span class="text-sm text-gray-400 italic">Silakan unggah dokumen dalam format
                                            PDF.</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="flex-shrink-0">
                            <span
                                class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-{{ $config['color'] }}-100 text-{{ $config['color'] }}-700 border border-{{ $config['color'] }}-200">
                                {{ $config['label'] }}
                            </span>
                        </div>

                        <div
                            class="flex items-center space-x-3 w-full md:w-auto justify-end border-t md:border-t-0 pt-3 md:pt-0">
                            @if ($data)
                                <a href="{{ asset('storage/' . $data->file) }}" target="_blank"
                                    class="inline-flex items-center text-sm font-medium text-blue-600 hover:text-blue-800 transition">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                        </path>
                                    </svg>
                                    Lihat File
                                </a>
                            @endif

                            @if ($status != 'approved')
                                <button
                                    onclick="openModal(
                                             {{ $key }},
                                            '{{ $chapterName }}',
                                            '{{ $data->judul ?? '' }}',
                                            '{{ $data->deskripsi ?? '' }}',
                                            '{{ $data->dosen_pembimbing_id ?? '' }}')"
                                    class="inline-flex items-center px-4 py-2 {{ $data ? 'bg-amber-500 hover:bg-amber-600' : 'bg-blue-600 hover:bg-blue-700' }} text-white text-sm font-bold rounded-lg shadow-sm transition-all focus:ring-4 focus:ring-blue-200">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                                    </svg>
                                    {{ $data ? 'Upload Ulang' : 'Upload File' }}
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div id="uploadModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog"
            aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" onclick="closeModal()"></div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div
                    class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full modal-animate-in">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div
                                class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 sm:mx-0 sm:h-10 sm:w-10">
                                <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12">
                                    </path>
                                </svg>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                <h3 class="text-xl leading-6 font-bold text-gray-900" id="modalTitle">Unggah Dokumen</h3>

                                <form id="formUpload" action="{{ route('mahasiswa.dokumen-akhir.store') }}" method="POST"
                                    enctype="multipart/form-data" class="mt-6">
                                    @csrf
                                    <input type="hidden" name="bab" id="inputBab">

                                    <div class="mb-4">
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Judul Laporan /
                                            Penelitian</label>
                                        <input type="text" name="judul" id="inputJudul" required
                                            class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm p-2.5"
                                            placeholder="Contoh: Analisis Sentimen Twitter Menggunakan Algoritma Naive Bayes">
                                        <p class="mt-1 text-xs text-gray-400 font-normal italic">*Gunakan judul yang sudah
                                            disetujui pembimbing.</p>
                                    </div>

                                    <div class="mb-4">
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Dosen
                                            Pembimbing</label>
                                        <select name="dosen_pembimbing_id" id="inputDosen"
                                            class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                                            @foreach ($dosens as $dosen)
                                                <option value="{{ $dosen->id }}">{{ $dosen->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="mb-4">
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">File Dokumen
                                            (PDF/DOCX)</label>
                                        <div
                                            class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-blue-400 transition-colors">
                                            <div class="space-y-1 text-center">
                                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor"
                                                    fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                                    <path
                                                        d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                                        stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round" />
                                                </svg>
                                                <div class="flex text-sm text-gray-600">
                                                    <label for="file-upload"
                                                        class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                                        <span>Klik untuk upload</span>
                                                        <input id="file-upload" name="file" type="file"
                                                            class="sr-only" required onchange="updateFileName(this)">
                                                    </label>
                                                </div>
                                                <p id="fileNameDisplay" class="text-xs text-gray-500">PDF atau DOCX hingga
                                                    5MB</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi / Catatan
                                            Tambahan</label>
                                        <textarea name="deskripsi" id="inputDeskripsi" rows="3"
                                            class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm"
                                            placeholder="Tuliskan revisi apa yang sudah dilakukan..."></textarea>
                                    </div>

                                    <div class="mt-5 sm:mt-6 sm:grid sm:grid-cols-2 sm:gap-3 sm:flow-row-reverse">
                                        <button type="submit"
                                            class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:text-sm">
                                            Simpan Dokumen
                                        </button>
                                        <button type="button" onclick="closeModal()"
                                            class="mt-3 w-full inline-flex justify-center rounded-lg border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:text-sm">
                                            Batal
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // SweetAlert2 Session Notifications
        document.addEventListener('DOMContentLoaded', function() {
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: '{{ session('success') }}',
                    timer: 3000,
                    showConfirmButton: false,
                    toast: true,
                    position: 'top-end'
                });
            @endif

            @if ($errors->any())
                Swal.fire({
                    icon: 'error',
                    title: 'Terjadi Kesalahan',
                    text: '{{ $errors->first() }}',
                    confirmButtonColor: '#2563eb'
                });
            @endif
        });

        function openModal(babId, babName) {
            const modal = document.getElementById('uploadModal');
            modal.classList.remove('hidden');
            document.getElementById('inputBab').value = babId;
            document.getElementById('modalTitle').innerText = 'Upload ' + babName;
            document.getElementById('inputJudul').value = judul;
            document.body.style.overflow = 'hidden'; // Prevent scroll
        }

        function closeModal() {
            const modal = document.getElementById('uploadModal');
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto'; // Re-enable scroll
        }

        function updateFileName(input) {
            const display = document.getElementById('fileNameDisplay');
            if (input.files.length > 0) {
                display.innerText = "File terpilih: " + input.files[0].name;
                display.classList.add('text-blue-600', 'font-bold');
            }
        }
    </script>
@endsection
