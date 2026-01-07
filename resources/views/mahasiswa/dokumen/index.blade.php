@extends('layouts.app')

@section('title', 'Dokumen Tugas Akhir')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Dokumen Tugas Akhir</h1>
                <p class="text-gray-600 mt-1">Kelola dan pantau progress upload skripsi Anda per Bab.</p>
            </div>
            <div class="flex items-center gap-3">
                <div class="px-4 py-2 bg-blue-50 text-blue-700 rounded-lg text-sm font-semibold border border-blue-100">
                    Total Upload: {{ count($uploads) }}/{{ count($chapters) }}
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 font-medium">Disetujui</p>
                    <p class="text-3xl font-bold text-green-600">
                        {{ collect($uploads)->where('status', 'approved')->count() }}</p>
                </div>
                <div class="p-3 bg-green-100 rounded-full text-green-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 font-medium">Menunggu Review</p>
                    <p class="text-3xl font-bold text-amber-500">
                        {{ collect($uploads)->where('status', 'pending')->count() }}</p>
                </div>
                <div class="p-3 bg-amber-100 rounded-full text-amber-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 font-medium">Revisi</p>
                    <p class="text-3xl font-bold text-red-600">{{ collect($uploads)->where('status', 'rejected')->count() }}
                    </p>
                </div>
                <div class="p-3 bg-red-100 rounded-full text-red-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                        </path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="grid gap-6">
            @foreach ($chapters as $key => $chapterName)
                @php
                    $data = $uploads[$key] ?? null;
                    $status = $data ? $data->status : 'empty';

                    $statusConfig = match ($status) {
                        'approved' => [
                            'class' => 'bg-green-50 border-green-200',
                            'text' => 'text-green-700',
                            'badge' => 'Disetujui',
                            'badge_class' => 'bg-green-100 text-green-800',
                        ],
                        'rejected' => [
                            'class' => 'bg-red-50 border-red-200',
                            'text' => 'text-red-700',
                            'badge' => 'Perlu Revisi',
                            'badge_class' => 'bg-red-100 text-red-800',
                        ],
                        'pending' => [
                            'class' => 'bg-amber-50 border-amber-200',
                            'text' => 'text-amber-700',
                            'badge' => 'Menunggu Review',
                            'badge_class' => 'bg-amber-100 text-amber-800',
                        ],
                        default => [
                            'class' => 'bg-white border-gray-200',
                            'text' => 'text-gray-500',
                            'badge' => 'Belum Upload',
                            'badge_class' => 'bg-gray-100 text-gray-600',
                        ],
                    };
                @endphp

                <div class="border rounded-xl p-5 transition-all hover:shadow-md {{ $statusConfig['class'] }}">
                    <div class="flex flex-col md:flex-row justify-between md:items-center gap-4">
                        <div class="flex-1">
                            <div class="flex items-center gap-3 mb-2">
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusConfig['badge_class'] }}">
                                    {{ $statusConfig['badge'] }}
                                </span>
                                <h3 class="text-lg font-bold text-gray-900">{{ $chapterName }}</h3>
                            </div>

                            @if ($data)
                                <div class="text-sm text-gray-600 space-y-1">
                                    <p><span class="font-medium">Judul:</span> {{ $data->judul }}</p>
                                    <p class="text-xs text-gray-500">
                                        Diunggah: {{ $data->updated_at->format('d M Y, H:i') }}
                                        @if ($data->deskripsi)
                                            <br><span
                                                class="italic text-gray-500">"{{ Str::limit($data->deskripsi, 100) }}"</span>
                                        @endif
                                    </p>
                                </div>
                                @if ($data->catatan_dosen)
                                    <div class="mt-3 bg-white p-3 rounded-lg border border-red-100 shadow-sm">
                                        <p class="text-sm text-red-600 font-medium mb-1">Catatan Dosen:</p>
                                        <p class="text-sm text-gray-700 italic">{{ $data->catatan_dosen }}</p>
                                    </div>
                                @endif
                            @else
                                <p class="text-sm text-gray-400 italic">Belum ada dokumen yang diunggah untuk bab ini.</p>
                            @endif
                        </div>

                        <div class="flex items-center gap-3">
                            @if ($data)
                                <a href="{{ asset('storage/' . $data->file) }}" target="_blank"
                                    class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                        </path>
                                    </svg>
                                    Lihat File
                                </a>
                            @endif

                            @if ($status !== 'approved')
                                <button
                                    onclick="openUploadModal({{ $key }}, '{{ $chapterName }}', '{{ $data ? $data->judul : '' }}', '{{ $data ? $data->deskripsi : '' }}', '{{ $data ? $data->dosen_pembimbing_id : '' }}')"
                                    class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 shadow-sm">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                                    </svg>
                                    {{ $data ? 'Revisi / Upload Ulang' : 'Upload File' }}
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div id="uploadModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog"
        aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity backdrop-blur-sm"
                onclick="closeUploadModal()"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div
                class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
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
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modalTitle">Upload Dokumen</h3>
                            <div class="mt-4">
                                <form id="uploadForm" action="{{ route('mahasiswa.dokumen-akhir.store') }}"
                                    method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="bab" id="inputBab">

                                    <div class="space-y-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Judul
                                                Dokumen</label>
                                            <input type="text" name="judul" id="inputJudul" required
                                                class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm text-sm"
                                                placeholder="Contoh: Bab 1 - Latar Belakang (Revisi)">
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Dosen
                                                Pembimbing</label>
                                            <select name="dosen_pembimbing_id" id="inputDosen" required
                                                class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm text-sm">
                                                <option value="">-- Pilih Dosen --</option>
                                                @foreach ($dosens as $dosen)
                                                    <option value="{{ $dosen->id }}">{{ $dosen->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Catatan /
                                                Deskripsi</label>
                                            <textarea name="deskripsi" id="inputDeskripsi" rows="3"
                                                class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm text-sm"
                                                placeholder="Tambahkan catatan untuk dosen..."></textarea>
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">File
                                                (PDF/DOCX)</label>
                                            <input type="file" name="file" required
                                                class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition">
                                        </div>
                                    </div>

                                    <div class="mt-5 sm:mt-6 sm:grid sm:grid-cols-2 sm:gap-3 sm:flow-row-reverse">
                                        <button type="submit"
                                            class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:text-sm">
                                            Upload
                                        </button>
                                        <button type="button" onclick="closeUploadModal()"
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
@endsection
@push('scripts')
    <script>
        function openUploadModal(babId, babName, currentJudul, currentDeskripsi, currentDosenId) {
            document.getElementById('uploadModal').classList.remove('hidden');
            document.getElementById('inputBab').value = babId;
            document.getElementById('modalTitle').innerText = 'Upload ' + babName;

            document.getElementById('inputJudul').value = currentJudul || '';
            document.getElementById('inputDeskripsi').value = currentDeskripsi || '';
            if (currentDosenId) {
                document.getElementById('inputDosen').value = currentDosenId;
            }
        }

        function closeUploadModal() {
            document.getElementById('uploadModal').classList.add('hidden');
            document.getElementById('uploadForm').reset();
        }
    </script>
@endpush
