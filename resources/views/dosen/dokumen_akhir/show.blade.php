@extends('layouts.app')

@section('title', 'Detail Progress Skripsi')

@section('content')
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">{{ $mahasiswa->name }}</h1>
                <p class="text-gray-500 mt-1">Review Dokumen Akhir per Bab</p>
            </div>
            <a href="{{ route('dosen.dokumen-akhir.index') }}"
                class="mt-4 md:mt-0 text-gray-600 hover:text-gray-900 flex items-center text-sm font-medium transition">
                ← Kembali ke Daftar
            </a>
        </div>
    </div>

    @if (session('success'))
        <div class="mb-6 p-4 rounded-lg bg-green-50 border-l-4 border-green-500 text-green-700">
            <p class="font-medium">Berhasil!</p>
            <p class="text-sm">{{ session('success') }}</p>
        </div>
    @endif

    <div class="space-y-4">
        @foreach ($chapters as $key => $chapterName)
            @php
                $dokumen = $uploads[$key] ?? null;
                $status = $dokumen ? $dokumen->status : 'none';

                // Styling dinamis berdasarkan status
                $cardBorder = match ($status) {
                    'approved' => 'border-l-4 border-green-500',
                    'rejected' => 'border-l-4 border-red-500',
                    'pending' => 'border-l-4 border-yellow-500',
                    default => 'border-l-4 border-gray-200 opacity-75',
                };
            @endphp

            <div class="bg-white rounded-lg shadow-sm {{ $cardBorder }} p-6 transition hover:shadow-md">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">

                    <div class="flex-1">
                        <div class="flex items-center gap-3">
                            <h3 class="text-lg font-bold text-gray-800">{{ $chapterName }}</h3>

                            @if ($status == 'approved')
                                <span
                                    class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Disetujui</span>
                            @elseif($status == 'rejected')
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">Perlu
                                    Revisi</span>
                            @elseif($status == 'pending')
                                <span
                                    class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">Menunggu
                                    Review</span>
                            @else
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-500">Belum
                                    Upload</span>
                            @endif
                        </div>

                        @if ($dokumen)
                            <p class="text-sm text-gray-500 mt-1">
                                Uploaded: {{ $dokumen->created_at->format('d M Y, H:i') }}
                                @if ($dokumen->judul != 'File Bab ' . $key)
                                    <span class="mx-1">•</span> {{ $dokumen->judul }}
                                @endif
                            </p>

                            @if ($dokumen->catatan_dosen)
                                <div class="mt-3 p-3 bg-gray-50 rounded-md border border-gray-100 text-sm">
                                    <span class="font-semibold text-gray-700">Catatan Anda:</span>
                                    <p class="text-gray-600 mt-1">{{ $dokumen->catatan_dosen }}</p>
                                </div>
                            @endif
                        @else
                            <p class="text-sm text-gray-400 mt-1 italic">Mahasiswa belum mengunggah file untuk bab ini.</p>
                        @endif
                    </div>

                    @if ($dokumen)
                        <div class="flex flex-wrap items-center gap-2">
                            <a href="{{ asset('storage/' . $dokumen->file) }}" target="_blank"
                                class="inline-flex items-center px-4 py-2 bg-gray-100 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                </svg>
                                File
                            </a>

                            <button
                                onclick="openReviewModal({{ $dokumen->id }}, '{{ $chapterName }}', '{{ $dokumen->status }}', '{{ $dokumen->catatan_dosen ?? '' }}')"
                                class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                    </path>
                                </svg>
                                Review
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

    <div id="reviewModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-5 border w-full max-w-lg shadow-lg rounded-xl bg-white">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-bold text-gray-900" id="modalTitle">Review Bab</h3>
                <button onclick="closeReviewModal()" class="text-gray-400 hover:text-gray-500">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>

            <form id="reviewForm" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Status</label>
                    <div class="flex gap-4">
                        <label class="inline-flex items-center">
                            <input type="radio" name="status" value="approved" class="form-radio text-green-600 h-5 w-5">
                            <span class="ml-2 text-gray-700">Approve (Setujui)</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" name="status" value="rejected" class="form-radio text-red-600 h-5 w-5">
                            <span class="ml-2 text-gray-700">Reject (Revisi)</span>
                        </label>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Catatan / Masukan</label>
                    <textarea name="catatan_dosen" id="modalCatatan" rows="4"
                        class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md"
                        placeholder="Tuliskan revisi atau masukan untuk mahasiswa..."></textarea>
                </div>

                <div class="flex justify-end pt-2">
                    <button type="button" onclick="closeReviewModal()"
                        class="mr-2 px-4 py-2 bg-white text-gray-700 border border-gray-300 rounded-md font-semibold text-xs uppercase tracking-widest shadow-sm hover:bg-gray-50">
                        Batal
                    </button>
                    <button type="submit"
                        class="px-4 py-2 bg-green-600 text-white rounded-md font-semibold text-xs uppercase tracking-widest shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        Simpan Review
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openReviewModal(id, title, currentStatus, currentNote) {
            // Set Action URL
            const form = document.getElementById('reviewForm');
            // Pastikan URL sesuai dengan route yang kita buat di web.php
            form.action = `/dosen/dokumen-akhir/${id}/update-status`;

            // Set UI Data
            document.getElementById('modalTitle').innerText = 'Review: ' + title;
            document.getElementById('modalCatatan').value = currentNote;
            document.getElementById('reviewModal').classList.remove('hidden');

            // Set Radio Button
            const radios = document.getElementsByName('status');
            for (let i = 0; i < radios.length; i++) {
                if (radios[i].value === currentStatus) {
                    radios[i].checked = true;
                }
            }
        }

        function closeReviewModal() {
            document.getElementById('reviewModal').classList.add('hidden');
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
            const modal = document.getElementById('reviewModal');
            if (event.target == modal) {
                closeReviewModal();
            }
        }
    </script>
@endsection
