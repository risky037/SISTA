@extends('layouts.app')

@section('title', 'Review Dokumen Akhir')

@section('content')
    <div class="flex justify-between items-center mb-4">
        <div>
            <h1 class="text-gray-800 text-xl font-semibold">@yield('title')</h1>
            <p class="text-gray-500 text-sm">Halaman untuk melihat detail Dokumen Akhir Mahasiswa.</p>
        </div>
        <nav class="text-sm text-gray-500">
            <ol class="list-reset flex">
                <li><a href="{{ route('dosen.dashboard') }}" class="hover:text-green-600">Home</a></li>
                <li><span class="mx-2">/</span></li>
                <li><a href="{{ route('dosen.dokumen-akhir.index') }}" class="hover:text-green-600">Dokumen
                        Akhir</a></li>
                <li><span class="mx-2">/</span></li>
                <li class="text-gray-700">@yield('title')</li>
            </ol>
        </nav>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">{{ $mahasiswa->name }}</h1>
                <p class="text-gray-500 mt-1">NIM: {{ $mahasiswa->NIM ?? '-' }} | Program Studi:
                    {{ $mahasiswa->prodi ?? '-' }}</p>
            </div>
        </div>
    </div>

    <div class="space-y-6">
        @foreach ($chapters as $key => $chapterName)
            @php
                $dokumen = $uploads[$key] ?? null;
                $status = $dokumen ? $dokumen->status : 'none';

                $borderClass = match ($status) {
                    'approved' => 'border-l-4 border-green-500',
                    'rejected' => 'border-l-4 border-red-500',
                    'pending' => 'border-l-4 border-amber-500',
                    default => 'border-l-4 border-gray-200',
                };
            @endphp

            <div class="bg-white rounded-xl shadow-sm {{ $borderClass }} p-6">
                <div class="flex flex-col lg:flex-row justify-between gap-6">
                    <div class="flex-1">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-bold text-gray-800">{{ $chapterName }}</h3>
                            @if ($status == 'approved')
                                <span
                                    class="px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700">DISETUJUI</span>
                            @elseif($status == 'rejected')
                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-red-100 text-red-700">REVISI</span>
                            @elseif($status == 'pending')
                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-700">MENUNGGU
                                    REVIEW</span>
                            @else
                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-gray-100 text-gray-500">BELUM
                                    UPLOAD</span>
                            @endif
                        </div>

                        @if ($dokumen)
                            <div class="bg-gray-50 rounded-lg p-4 border border-gray-100 mb-4">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <p class="text-xs text-gray-500 uppercase font-semibold">Judul Dokumen</p>
                                        <p class="text-gray-900 font-medium">{{ $dokumen->judul }}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500 uppercase font-semibold">Waktu Upload</p>
                                        <p class="text-gray-900">{{ $dokumen->created_at->format('d M Y, H:i') }}</p>
                                    </div>
                                </div>
                                @if ($dokumen->deskripsi)
                                    <div class="mt-3 pt-3 border-t border-gray-200">
                                        <p class="text-xs text-gray-500 uppercase font-semibold mb-1">Catatan Mahasiswa</p>
                                        <p class="text-gray-700 italic text-sm">"{{ $dokumen->deskripsi }}"</p>
                                    </div>
                                @endif
                            </div>

                            @if ($dokumen->catatan_dosen)
                                <div class="bg-blue-50 rounded-lg p-4 border border-blue-100">
                                    <p class="text-xs text-blue-600 uppercase font-semibold mb-1">Catatan Anda (Review
                                        Terakhir)</p>
                                    <p class="text-gray-800 text-sm">{{ $dokumen->catatan_dosen }}</p>
                                </div>
                            @endif
                        @else
                            <div class="text-center py-6 bg-gray-50 rounded-lg border border-dashed border-gray-300">
                                <p class="text-gray-400 text-sm">Mahasiswa belum mengunggah dokumen untuk bab ini.</p>
                            </div>
                        @endif
                    </div>

                    @if ($dokumen)
                        <div class="flex lg:flex-col gap-3 justify-center lg:justify-start lg:w-48">
                            <a href="{{ asset('storage/' . $dokumen->file) }}" target="_blank"
                                class="w-full flex items-center justify-center px-4 py-2 bg-white border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 font-medium text-sm transition shadow-sm">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                    </path>
                                </svg>
                                Lihat File
                            </a>

                            <button
                                onclick="openReviewModal({{ $dokumen->id }}, '{{ $chapterName }}', '{{ $dokumen->status }}', '{{ $dokumen->catatan_dosen ?? '' }}')"
                                class="w-full flex items-center justify-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium text-sm transition shadow-sm">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                    </path>
                                </svg>
                                Beri Review
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

    <!-- Modal -->
    <div id="reviewModal" class="fixed inset-0 z-50 hidden items-center justify-center">

        <div id="modalBackdrop"
            class="absolute inset-0 bg-black/40 backdrop-blur-sm opacity-0 transition-opacity duration-300"
            onclick="closeReviewModal()"></div>

        <div id="modalBox"
            class="relative w-full max-w-lg mx-auto bg-white rounded-2xl shadow-xl
               transform opacity-0 scale-95 translate-y-4
               transition-all duration-300 ease-out">

            <form id="reviewForm" method="POST">
                @csrf
                @method('PUT')

                <div class="flex items-center justify-between px-6 py-4 border-b">
                    <h3 class="text-lg font-semibold text-gray-800" id="modalTitle">
                        Review Dokumen
                    </h3>
                    <button type="button" onclick="closeReviewModal()"
                        class="text-gray-400 hover:text-gray-600 transition">
                        ✕
                    </button>
                </div>

                <div class="px-6 py-5 space-y-5">
                    <div>
                        <p class="text-sm font-medium text-gray-700 mb-2">Keputusan</p>
                        <div class="grid grid-cols-2 gap-4">
                            <label class="cursor-pointer">
                                <input type="radio" name="status" value="approved" class="peer sr-only">
                                <div
                                    class="rounded-xl border p-4 text-center transition
                                       peer-checked:border-green-500 peer-checked:bg-green-50
                                       hover:bg-green-50">
                                    <p class="font-semibold text-gray-800">Setujui</p>
                                    <p class="text-xs text-gray-500 mt-1">Lanjut ke bab berikutnya</p>
                                </div>
                            </label>

                            <label class="cursor-pointer">
                                <input type="radio" name="status" value="rejected" class="peer sr-only">
                                <div
                                    class="rounded-xl border p-4 text-center transition
                                       peer-checked:border-red-500 peer-checked:bg-red-50
                                       hover:bg-red-50">
                                    <p class="font-semibold text-gray-800">Revisi</p>
                                    <p class="text-xs text-gray-500 mt-1">Minta perbaikan</p>
                                </div>
                            </label>
                        </div>
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-700 mb-2 block">
                            Catatan Pembimbing
                        </label>
                        <textarea id="modalCatatan" name="catatan_dosen" rows="4"
                            class="w-full rounded-xl border-gray-300 focus:ring-blue-500 focus:border-blue-500 text-sm"
                            placeholder="Tuliskan catatan atau revisi..."></textarea>
                    </div>
                </div>

                <div class="flex justify-end gap-3 px-6 py-4 bg-gray-50 rounded-b-2xl">
                    <button type="button" onclick="closeReviewModal()"
                        class="px-4 py-2 rounded-lg border text-gray-600 hover:bg-gray-100 transition">
                        Batal
                    </button>
                    <button type="submit"
                        class="px-4 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700 transition shadow">
                        Simpan Review
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        const modal = document.getElementById('reviewModal');
        const backdrop = document.getElementById('modalBackdrop');
        const box = document.getElementById('modalBox');

        function openReviewModal(id, title, status, note) {
            const form = document.getElementById('reviewForm');
            form.action = `/dosen/dokumen-akhir/${id}/update-status`;

            document.getElementById('modalTitle').innerText = 'Review: ' + title;
            document.getElementById('modalCatatan').value = note ?? '';

            modal.classList.remove('hidden');
            modal.classList.add('flex');

            // Trigger animation
            requestAnimationFrame(() => {
                backdrop.classList.remove('opacity-0');
                box.classList.remove('opacity-0', 'scale-95', 'translate-y-4');
                box.classList.add('opacity-100', 'scale-100', 'translate-y-0');
            });

            // Set radio
            document.getElementsByName('status').forEach(radio => {
                radio.checked = radio.value === status;
            });
        }

        function closeReviewModal() {
            backdrop.classList.add('opacity-0');
            box.classList.add('opacity-0', 'scale-95', 'translate-y-4');

            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }, 300);
        }

        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: '{{ session('success') }}',
                timer: 3000,
                showConfirmButton: false
            });
        @endif
    </script>
@endpush
