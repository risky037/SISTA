@extends('layouts.app')

@section('title', 'Daftar Proposal')

@section('content')
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">@yield('title')</h1>
            <p class="text-gray-500 text-sm mt-1">
                Halaman untuk mengelola proposal skripsi Anda.</p>
        </div>
        <nav class="text-sm font-medium text-gray-500 bg-gray-100 px-4 py-2 rounded-lg">
            <ol class="flex items-center gap-2">
                <li>
                    <a href="{{ route('mahasiswa.dashboard') }}" class="hover:text-green-600 transition-colors">
                        Home
                    </a>
                </li>
                <li class="text-gray-300">/</li>
                <li class="text-green-600">@yield('title')</li>
            </ol>
        </nav>
    </div>

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div class="flex items-center gap-2 px-4 py-2 bg-white rounded-xl border border-gray-100 shadow-sm w-fit">
            <span class="text-xs font-bold text-gray-400 uppercase tracking-widest">Total Proposal:</span>
            <span class="text-lg font-black text-green-600">{{ $proposals->count() }}</span>
        </div>
        <a href="{{ route('mahasiswa.proposals.create') }}"
            class="inline-flex items-center justify-center gap-2 rounded-xl bg-green-600 px-6 py-3 text-sm font-bold text-white hover:bg-green-700 transition-all shadow-lg shadow-green-100 active:scale-95 group">
            <svg class="w-4 h-4 transition-transform group-hover:rotate-90" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2">
                <path d="M12 5v14M5 12h14" />
            </svg>
            Ajukan Proposal
        </a>
    </div>

    @if ($proposals->count())
        <div class="grid gap-4 md:hidden">
            @foreach ($proposals as $proposal)
                @php
                    $statusClass = match ($proposal->status) {
                        'pending' => 'bg-yellow-50 text-yellow-600 border-yellow-200',
                        'approved', 'diterima' => 'bg-green-50 text-green-600 border-green-200',
                        'rejected', 'ditolak' => 'bg-red-50 text-red-600 border-red-200',
                        default => 'bg-gray-50 text-gray-500 border-gray-200',
                    };
                @endphp

                <div class="rounded-2xl border border-gray-100 bg-white p-5 shadow-sm">
                    <div class="flex justify-between items-start mb-3">
                        <span
                            class="text-[10px] font-black uppercase tracking-widest px-3 py-1 rounded-full border {{ $statusClass }}">
                            {{ ucfirst($proposal->status) }}
                        </span>
                        <span class="text-[11px] text-gray-400 font-medium">
                            {{ $proposal->created_at->format('d M Y') }}
                        </span>
                    </div>

                    <h3 class="font-bold text-gray-800 text-lg leading-tight mb-2">
                        {{ $proposal->judul }}
                    </h3>

                    <p class="text-xs text-gray-500 mb-4 line-clamp-2 leading-relaxed">
                        {{ $proposal->deskripsi }}
                    </p>

                    <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-xl mb-4">
                        <div
                            class="w-8 h-8 rounded-full bg-white border border-gray-200 flex items-center justify-center text-gray-400 text-xs">
                            <svg class="w-4 h-4 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <circle cx="12" cy="7" r="4" />
                                <path d="M6 21c0-3.3 2.7-6 6-6s6 2.7 6 6" />
                            </svg>
                        </div>
                        <div class="text-[11px]">
                            <p class="text-gray-400 font-bold uppercase tracking-tighter">Dosen Pembimbing</p>
                            <p class="text-gray-700 font-semibold">{{ $proposal->dosen->name ?? 'Menunggu Plotting' }}</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-2">
                        <a href="{{ asset('storage/proposals/' . $proposal->file_proposal) }}" target="_blank"
                            class="flex items-center justify-center gap-2 text-xs font-bold px-4 py-2.5 rounded-xl bg-blue-50 text-blue-600 hover:bg-blue-100 transition-colors">
                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                                <path d="M14 2v6h6" />
                                <path d="M8 13h2m-2 3h4m2-3h2" />
                            </svg>
                            <span>Lihat File</span>
                        </a>

                        <a href="{{ route('mahasiswa.proposals.show', $proposal->id) }}"
                            class="flex items-center justify-center gap-2 text-xs font-bold px-4 py-2.5 rounded-xl bg-gray-50 text-gray-600 hover:bg-gray-100 transition-colors">
                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7z" />
                                <circle cx="12" cy="12" r="3" />
                            </svg>
                            <span>Detail</span>
                        </a>

                        @if ($proposal->status === 'pending' || $proposal->status === 'rejected' || $proposal->status === 'ditolak')
                            <a href="{{ route('mahasiswa.proposals.edit', $proposal->id) }}"
                                class="flex items-center justify-center gap-2 text-xs font-bold px-4 py-2.5 rounded-xl bg-yellow-50 text-yellow-600 hover:bg-yellow-100 transition-colors">
                                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2">
                                    <path d="M12 20h9" />
                                    <path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4z" />
                                </svg>
                                <span>Edit</span>
                            </a>

                            <form action="{{ route('mahasiswa.proposals.destroy', $proposal->id) }}" method="POST"
                                class="delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="w-full flex items-center justify-center gap-2 text-xs font-bold px-4 py-2.5 rounded-xl bg-red-50 text-red-600 hover:bg-red-100 transition-colors">
                                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2">
                                        <path d="M3 6h18" />
                                        <path d="M8 6V4h8v2" />
                                        <path d="M6 6l1 14h10l1-14" />
                                    </svg>
                                    <span>Hapus</span>
                                </button>
                            </form>
                        @endif
                    </div>

                </div>
            @endforeach
        </div>

        <div class="hidden md:block overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm">
            <table class="min-w-full text-sm">
                <thead>
                    <tr class="bg-gray-50/50 border-b border-gray-100">
                        <th class="px-6 py-4 text-[11px] font-black uppercase tracking-widest text-gray-400 text-left">Info
                            Proposal</th>
                        <th class="px-6 py-4 text-[11px] font-black uppercase tracking-widest text-gray-400 text-left">Dosen
                            Pembimbing</th>
                        <th class="px-6 py-4 text-[11px] font-black uppercase tracking-widest text-gray-400 text-center">
                            Status</th>
                        <th class="px-6 py-4 text-[11px] font-black uppercase tracking-widest text-gray-400 text-center">
                            Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach ($proposals as $proposal)
                        @php
                            $statusClass = match ($proposal->status) {
                                'pending' => 'bg-yellow-50 text-yellow-600 border-yellow-200',
                                'approved', 'diterima' => 'bg-green-50 text-green-600 border-green-200',
                                'rejected', 'ditolak' => 'bg-red-50 text-red-600 border-red-200',
                                default => 'bg-gray-50 text-gray-500 border-gray-200',
                            };
                        @endphp
                        <tr class="hover:bg-green-50/20 transition-colors group">
                            <td class="px-6 py-4">
                                <div class="flex flex-col">
                                    <span
                                        class="font-bold text-gray-800 group-hover:text-green-700 transition-colors">{{ $proposal->judul }}</span>
                                    <div class="flex items-center gap-3 mt-1">
                                        <span class="text-[11px] text-gray-400 flex items-center font-medium">
                                            <svg class="w-3.5 h-3.5 mr-1" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2">
                                                <rect x="3" y="4" width="18" height="18" rx="2" />
                                                <path d="M16 2v4M8 2v4M3 10h18" />
                                            </svg>
                                            {{ $proposal->created_at->format('d M Y') }}
                                        </span>
                                        <a href="{{ asset('storage/proposals/' . $proposal->file_proposal) }}"
                                            target="_blank"
                                            class="text-[11px] font-bold text-blue-600 hover:text-blue-800 flex items-center">
                                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2">
                                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                                                <path d="M14 2v6h6" />
                                                <path d="M8 13h2m-2 3h4m2-3h2" />
                                            </svg>
                                            Lihat PDF
                                        </a>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-8 h-8 rounded-lg bg-gray-50 flex items-center justify-center text-gray-400 border border-gray-100">
                                        <svg class="w-4 h-4 text-gray-400" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2">
                                            <circle cx="12" cy="7" r="4" />
                                            <path d="M6 21c0-3.3 2.7-6 6-6s6 2.7 6 6" />
                                        </svg>
                                    </div>
                                    <span
                                        class="font-semibold text-gray-600 text-xs">{{ $proposal->dosen->name ?? 'Belum Ditentukan' }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span
                                    class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest border {{ $statusClass }}">
                                    {{ $proposal->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex justify-center items-center gap-1">
                                    <a href="{{ route('mahasiswa.proposals.show', $proposal->id) }}"
                                        class="text-green-600 hover:text-green-900 bg-green-50 p-2 rounded-lg transition"
                                        title="Detail">
                                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2">
                                            <path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7z" />
                                            <circle cx="12" cy="12" r="3" />
                                        </svg>
                                    </a>

                                    @if ($proposal->status === 'pending' || $proposal->status === 'rejected' || $proposal->status === 'ditolak')
                                        <a href="{{ route('mahasiswa.proposals.edit', $proposal->id) }}"
                                            class="text-blue-600 hover:text-blue-900 bg-blue-50 p-2 rounded-lg transition"
                                            title="Edit Data">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                </path>
                                            </svg>
                                        </a>

                                        <form action="{{ route('mahasiswa.proposals.destroy', $proposal->id) }}"
                                            method="POST" class="inline delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="text-red-600 hover:text-red-900 bg-red-50 p-2 rounded-lg transition"
                                                title="Hapus">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                    </path>
                                                </svg>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div
            class="flex flex-col items-center justify-center rounded-2xl border border-dashed border-gray-300 bg-white p-12 text-center shadow-sm">
            <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mb-6">
                <svg class="w-10 h-10 text-gray-200" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="1.5">
                    <path d="M6 2h9l5 5v15a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2z" />
                    <path d="M14 2v6h6" />
                    <path d="M8 13h8M8 17h6" />
                </svg>
            </div>
            <h3 class="text-lg font-bold text-gray-800 mb-2">Belum Ada Pengajuan</h3>
            <p class="text-gray-400 text-sm max-w-xs mb-8">
                Anda belum mengajukan proposal skripsi. Silakan klik tombol di bawah untuk memulai.
            </p>
            <a href="{{ route('mahasiswa.proposals.create') }}"
                class="rounded-xl bg-green-600 px-8 py-3 text-sm font-bold text-white hover:bg-green-700 shadow-lg shadow-green-100 transition-all active:scale-95">
                Mulai Ajukan Proposal
            </a>
        </div>
    @endif
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.delete-form').forEach(form => {
                form.addEventListener('submit', function(event) {
                    event.preventDefault();
                    Swal.fire({
                        title: 'Yakin hapus?',
                        text: "Anda tidak akan bisa mengembalikan proposal ini!",
                        icon: 'warning',
                        showCancelButton: !0,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit()
                        }
                    })
                })
            })
        });
    </script>
@endpush
