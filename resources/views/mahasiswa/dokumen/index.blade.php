@extends('layouts.app')

@section('title', 'Dokumen Tugas Akhir')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-800 tracking-tight">Progress Tugas Akhir</h1>
                <p class="text-gray-500 mt-1 text-sm">Upload dokumen Anda secara bertahap mulai dari Bab 1 hingga selesai.</p>
            </div>

            <div class="flex items-center gap-2 bg-white px-4 py-2 rounded-full shadow-sm border border-gray-100">
                <div class="text-sm font-medium text-gray-600">Progress:</div>
                <div class="flex gap-1">
                    @foreach($chapters as $k => $v)
                        @php
                            $chStatus = $uploads[$k]->status ?? 'none';
                            $dotColor = match($chStatus) {
                                'approved' => 'bg-green-500',
                                'rejected' => 'bg-red-500',
                                'pending' => 'bg-amber-400',
                                default => 'bg-gray-200'
                            };
                        @endphp
                        <div class="w-8 h-2 rounded-full {{ $dotColor }}" title="{{ $v }}"></div>
                    @endforeach
                </div>
                <span class="ml-2 text-xs font-bold text-gray-700">{{ count($uploads) }}/{{ count($chapters) }}</span>
            </div>
        </div>

        @if (session('success'))
            <div class="mb-6 p-4 rounded-lg bg-green-50 border-l-4 border-green-500 text-green-700 flex items-center shadow-sm">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="mb-6 p-4 rounded-lg bg-red-50 border-l-4 border-red-500 text-red-700 flex items-center shadow-sm">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                {{ session('error') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            @foreach ($chapters as $key => $chapterName)
                @php
                    $data = $uploads[$key] ?? null;
                    $status = $data ? $data->status : 'empty';

                    // Logic Penguncian (Locking)
                    $isLocked = false;
                    $lockMessage = '';

                    if ($key > 1) {
                        $prevKey = $key - 1;
                        $prevData = $uploads[$prevKey] ?? null;

                        // Kunci jika bab sebelumnya belum ada ATAU statusnya bukan approved
                        if (!$prevData || $prevData->status !== 'approved') {
                            $isLocked = true;
                            $lockMessage = 'Selesaikan Bab ' . $prevKey . ' terlebih dahulu.';
                        }
                    }

                    // Styling Configuration
                    $statusConfig = match ($status) {
                        'approved' => [
                            'border' => 'border-green-200',
                            'bg' => 'bg-green-50/50', // Transparansi dikit biar modern
                            'icon_bg' => 'bg-green-100',
                            'icon_text' => 'text-green-600',
                            'badge' => 'Disetujui',
                            'badge_class' => 'bg-green-100 text-green-700 border border-green-200',
                        ],
                        'rejected' => [
                            'border' => 'border-red-200',
                            'bg' => 'bg-red-50/50',
                            'icon_bg' => 'bg-red-100',
                            'icon_text' => 'text-red-600',
                            'badge' => 'Perlu Revisi',
                            'badge_class' => 'bg-red-100 text-red-700 border border-red-200',
                        ],
                        'pending' => [
                            'border' => 'border-amber-200',
                            'bg' => 'bg-amber-50/50',
                            'icon_bg' => 'bg-amber-100',
                            'icon_text' => 'text-amber-600',
                            'badge' => 'Menunggu Review',
                            'badge_class' => 'bg-amber-100 text-amber-700 border border-amber-200',
                        ],
                        default => [ // Empty
                            'border' => 'border-gray-200',
                            'bg' => 'bg-white',
                            'icon_bg' => 'bg-gray-100',
                            'icon_text' => 'text-gray-400',
                            'badge' => 'Belum Upload',
                            'badge_class' => 'bg-gray-100 text-gray-500 border border-gray-200',
                        ],
                    };

                    // Override style jika Locked
                    if ($isLocked) {
                        $statusConfig['bg'] = 'bg-gray-50';
                        $statusConfig['border'] = 'border-gray-200';
                        $statusConfig['badge'] = 'Terkunci';
                        $statusConfig['badge_class'] = 'bg-gray-200 text-gray-500 border border-gray-300';
                    }
                @endphp

                <div class="relative border rounded-2xl p-6 transition-all duration-200 {{ $isLocked ? 'opacity-75 grayscale-[0.5]' : 'hover:shadow-md' }} {{ $statusConfig['bg'] }} {{ $statusConfig['border'] }}">

                    @if($isLocked)
                        <div class="absolute top-4 right-4">
                            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                        </div>
                    @endif

                    <div class="flex items-start justify-between mb-4">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0 {{ $statusConfig['icon_bg'] }} {{ $statusConfig['icon_text'] }}">
                                @if($isLocked)
                                    <span class="font-bold text-lg text-gray-400">{{ $key }}</span>
                                @else
                                    <span class="font-bold text-lg">{{ $key }}</span>
                                @endif
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-gray-900">{{ $chapterName }}</h3>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold mt-1 {{ $statusConfig['badge_class'] }}">
                                    {{ $statusConfig['badge'] }}
                                </span>
                            </div>
                        </div>
                    </div>

                    @if ($isLocked)
                        <div class="mt-4 p-3 bg-gray-100 rounded-lg border border-gray-200 text-sm text-gray-500 flex items-center justify-center italic">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            {{ $lockMessage }}
                        </div>
                    @else
                        <div class="space-y-4">
                            @if ($data)
                                <div class="text-sm bg-white/60 p-3 rounded-lg border border-gray-100">
                                    <p class="font-medium text-gray-900 truncate">{{ $data->judul }}</p>
                                    <p class="text-xs text-gray-500 mt-1">
                                        Update: {{ $data->updated_at->format('d M Y, H:i') }}
                                    </p>
                                    @if ($data->catatan_dosen)
                                        <div class="mt-2 pt-2 border-t border-gray-100">
                                            <p class="text-xs text-red-500 font-semibold flex items-center">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path></svg>
                                                Catatan Dosen:
                                            </p>
                                            <p class="text-xs text-gray-600 italic mt-1 pl-4">{{ $data->catatan_dosen }}</p>
                                        </div>
                                    @endif
                                </div>
                            @else
                                <p class="text-sm text-gray-400 italic pl-1">Belum ada dokumen diunggah.</p>
                            @endif

                            <div class="flex gap-2 pt-2">
                                @if ($data)
                                    <a href="{{ asset('storage/' . $data->file) }}" target="_blank"
                                        class="flex-1 inline-flex justify-center items-center px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 hover:text-blue-600 transition-colors">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        Lihat
                                    </a>
                                @endif

                                @if ($status !== 'approved')
                                    <button
                                        onclick="openUploadModal({{ $key }}, '{{ $chapterName }}', '{{ $data ? $data->judul : '' }}', '{{ $data ? $data->deskripsi : '' }}', '{{ $data ? $data->dosen_pembimbing_id : '' }}')"
                                        class="flex-1 inline-flex justify-center items-center px-4 py-2 {{ $data ? 'bg-amber-600 hover:bg-amber-700' : 'bg-blue-600 hover:bg-blue-700' }} border border-transparent rounded-lg text-sm font-medium text-white shadow-sm transition-colors">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                        {{ $data ? 'Revisi' : 'Upload' }}
                                    </button>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>

    <div id="uploadModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity backdrop-blur-sm" onclick="closeUploadModal()"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-gray-50 px-4 py-4 sm:px-6 border-b border-gray-100 flex justify-between items-center">
                    <h3 class="text-lg leading-6 font-bold text-gray-900" id="modalTitle">Upload Dokumen</h3>
                    <button onclick="closeUploadModal()" class="text-gray-400 hover:text-gray-500 focus:outline-none">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <div class="bg-white px-4 pt-5 pb-4 sm:p-6">
                    <form id="uploadForm" action="{{ route('mahasiswa.dokumen-akhir.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="bab" id="inputBab">

                        <div class="space-y-5">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Judul Dokumen</label>
                                <input type="text" name="judul" id="inputJudul" required
                                    class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm text-sm py-2.5"
                                    placeholder="Masukkan judul bab...">
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Dosen Pembimbing</label>
                                <select name="dosen_pembimbing_id" id="inputDosen" required
                                    class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm text-sm py-2.5 bg-gray-50">
                                    <option value="">-- Pilih Dosen --</option>
                                    @foreach ($dosens as $dosen)
                                        <option value="{{ $dosen->id }}">{{ $dosen->name }}</option>
                                    @endforeach
                                </select>
                                <p class="mt-1 text-xs text-gray-500">*Pastikan dosen pembimbing sesuai dengan SK.</p>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">File (PDF/DOCX)</label>
                                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:bg-gray-50 transition-colors">
                                    <div class="space-y-1 text-center">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <div class="flex text-sm text-gray-600 justify-center">
                                            <label for="file-upload" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none">
                                                <span>Upload a file</span>
                                                <input id="file-upload" name="file" type="file" class="sr-only" required>
                                            </label>
                                        </div>
                                        <p class="text-xs text-gray-500">PDF, DOC, DOCX up to 10MB</p>
                                        <p id="fileNameDisplay" class="text-xs font-semibold text-gray-800 mt-2 hidden"></p>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Catatan Tambahan (Opsional)</label>
                                <textarea name="deskripsi" id="inputDeskripsi" rows="3"
                                    class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm text-sm"
                                    placeholder="Pesan untuk dosen..."></textarea>
                            </div>
                        </div>

                        <div class="mt-8 flex gap-3 flex-row-reverse">
                            <button type="submit"
                                class="w-full sm:w-auto inline-flex justify-center rounded-lg border border-transparent shadow-sm px-6 py-2.5 bg-blue-600 text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                                Upload Dokumen
                            </button>
                            <button type="button" onclick="closeUploadModal()"
                                class="w-full sm:w-auto inline-flex justify-center rounded-lg border border-gray-300 shadow-sm px-6 py-2.5 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                                Batal
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Ambil ID Dosen default dari Controller (hasil Bab 1)
        const defaultDosenId = "{{ $defaultDosenId ?? '' }}";

        function openUploadModal(babId, babName, currentJudul, currentDeskripsi, currentDosenId) {
            const modal = document.getElementById('uploadModal');
            modal.classList.remove('hidden');

            // Animasi masuk sederhana
            const modalPanel = modal.querySelector('.transform');
            modalPanel.classList.remove('opacity-0', 'translate-y-4', 'sm:translate-y-0', 'sm:scale-95');
            modalPanel.classList.add('opacity-100', 'translate-y-0', 'sm:scale-100');

            document.getElementById('inputBab').value = babId;
            document.getElementById('modalTitle').innerText = 'Upload ' + babName;

            document.getElementById('inputJudul').value = currentJudul || '';
            document.getElementById('inputDeskripsi').value = currentDeskripsi || '';

            // Logic Auto-fill Dosen
            const dosenSelect = document.getElementById('inputDosen');

            if (currentDosenId) {
                // Jika sedang edit/revisi, pakai data yang tersimpan
                dosenSelect.value = currentDosenId;
            } else if (babId > 1 && defaultDosenId) {
                // Jika upload baru (bukan bab 1) dan ada default dosen, pakai default
                dosenSelect.value = defaultDosenId;
            } else {
                // Reset
                dosenSelect.value = "";
            }
        }

        function closeUploadModal() {
            const modal = document.getElementById('uploadModal');
            const modalPanel = modal.querySelector('.transform');

            // Animasi keluar (opsional, tapi bagus untuk UX)
            modalPanel.classList.remove('opacity-100', 'translate-y-0', 'sm:scale-100');
            modalPanel.classList.add('opacity-0', 'translate-y-4', 'sm:translate-y-0', 'sm:scale-95');

            setTimeout(() => {
                modal.classList.add('hidden');
                document.getElementById('uploadForm').reset();
                document.getElementById('fileNameDisplay').classList.add('hidden');
            }, 200);
        }

        // Tampilkan nama file saat dipilih
        document.getElementById('file-upload').addEventListener('change', function(e) {
            const fileName = e.target.files[0]?.name;
            const display = document.getElementById('fileNameDisplay');
            if (fileName) {
                display.textContent = 'Terpilih: ' + fileName;
                display.classList.remove('hidden');
            }
        });
    </script>
@endpush
