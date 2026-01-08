@extends('layouts.app')

@section('title', 'Penilaian Proposal')

@push('styles')
    <style>
        [x-cloak] {
            display: none !important;
        }

        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }

        @media (max-width: 768px) {
            .animate-slide-up {
                animation: slideUp 0.3s ease-out forwards;
            }

            @keyframes slideUp {
                from {
                    transform: translateY(100%);
                    opacity: 0;
                }

                to {
                    transform: translateY(0);
                    opacity: 1;
                }
            }
        }
    </style>
@endpush

@section('content')
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">@yield('title')</h1>
            <p class="text-gray-500 text-sm mt-1">Kelola nilai Proposal mahasiswa bimbingan Anda.</p>
        </div>
        <nav class="text-sm font-medium text-gray-500 bg-gray-100 px-4 py-2 rounded-lg">
            <ol class="list-reset flex items-center gap-2">
                <li><a href="{{ route('dosen.dashboard') }}" class="hover:text-green-600">Home</a></li>
                <li><span class="mx-2">/</span></li>
                <li class="text-green-600">@yield('title')</li>
            </ol>
        </nav>
    </div>

    @if (session('success') || session('error'))
        <div x-data="{ show: true }" x-show="show" x-transition
            class="mb-6 p-4 rounded-xl border-l-4 shadow-sm flex items-center justify-between {{ session('success') ? 'bg-green-50 border-green-500 text-green-700' : 'bg-red-50 border-red-500 text-red-700' }}">
            <div class="flex items-center gap-3 font-medium text-sm">
                <i class="fas {{ session('success') ? 'fa-check-circle' : 'fa-exclamation-circle' }}"></i>
                <span>{{ session('success') ?? session('error') }}</span>
            </div>
            <button @click="show = false" class="text-current opacity-50 hover:opacity-100">&times;</button>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8" x-data="{
        open: false,
        editMode: false,
        studentName: '',
        proposalTitle: '',
        grade: '',
        keterangan: '',
        proposalId: '',
        actionUrl: '',

        openGrade(id, name, title) {
            this.editMode = false;
            this.studentName = name;
            this.proposalTitle = title;
            this.proposalId = id;
            this.grade = '';
            this.keterangan = '';
            this.actionUrl = '{{ route('dosen.nilai-proposal.store') }}';
            this.open = true;
        },

        openEdit(id, name, currentGrade, currentNote, title) {
            this.editMode = true;
            this.studentName = name;
            this.proposalTitle = title || 'Edit Penilaian Terdaftar';
            this.grade = currentGrade;
            this.keterangan = currentNote;
            this.actionUrl = `/dosen/nilai-proposal/${id}`;
            this.open = true;
        }
    }">

        {{-- LEFT COLUMN: QUEUE --}}
        <div class="lg:col-span-1 space-y-4">
            <div class="flex items-center justify-between px-1">
                <h2 class="font-bold text-gray-800 flex items-center gap-2">
                    <span class="w-2 h-6 bg-green-500 rounded-full"></span>
                    Menunggu Nilai
                </h2>
                <span
                    class="bg-green-100 text-green-700 text-[10px] font-bold px-2 py-0.5 rounded-full border border-green-200">
                    {{ count($belumDinilai) }} Mahasiswa
                </span>
            </div>

            <div class="space-y-4 max-h-[70vh] lg:max-h-none overflow-y-auto pr-1 custom-scrollbar">
                @forelse ($belumDinilai as $proposal)
                    <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition">
                        <div class="flex justify-between items-start mb-3">
                            <span
                                class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">{{ $proposal->mahasiswa->nim }}</span>
                            <span
                                class="text-[10px] text-gray-400 font-medium">{{ $proposal->updated_at->format('d/m/Y') }}</span>
                        </div>
                        <h3 class="font-bold text-gray-800 leading-tight mb-1">{{ $proposal->mahasiswa->name }}</h3>
                        <p class="text-xs text-gray-500 line-clamp-2 italic mb-5">"{{ $proposal->judul }}"</p>

                        <div class="flex gap-2">
                            @if ($proposal->file_proposal)
                                <a href="{{ asset('storage/proposals/' . $proposal->file_proposal) }}" target="_blank"
                                    class="flex-1 bg-gray-50 text-gray-600 text-[10px] font-bold py-2.5 rounded-xl border border-gray-200 text-center hover:bg-gray-100 transition uppercase tracking-wider">File</a>
                            @endif
                            <button
                                @click="openGrade('{{ $proposal->id }}', '{{ $proposal->mahasiswa->name }}', '{{ addslashes($proposal->judul) }}')"
                                class="flex-[2] bg-green-600 text-white text-[10px] font-bold py-2.5 rounded-xl shadow-lg shadow-green-100 hover:bg-green-700 transition uppercase tracking-widest">
                                Beri Nilai
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="bg-gray-50 border-2 border-dashed border-gray-200 rounded-2xl p-8 text-center">
                        <i class="fas fa-clipboard-check text-gray-300 text-3xl mb-3"></i>
                        <p class="text-sm text-gray-400 font-medium">Belum ada proposal baru untuk dinilai.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <div class="lg:col-span-2 space-y-4">
            <h2 class="font-bold text-gray-800 flex items-center gap-2 px-1">
                <span class="w-2 h-6 bg-blue-500 rounded-full"></span>
                Riwayat Penilaian
            </h2>

            <div class="hidden md:block bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <table class="w-full text-left">
                    <thead class="bg-gray-50/50 text-[10px] font-bold text-gray-400 uppercase tracking-widest border-b">
                        <tr>
                            <th class="px-6 py-4">Mahasiswa</th>
                            <th class="px-6 py-4">Judul Proposal</th>
                            <th class="px-6 py-4 text-center">Grade</th>
                            <th class="px-6 py-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse ($sudahDinilai as $nilai)
                            <tr class="hover:bg-gray-50/50 transition">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <p class="font-bold text-gray-800 text-sm">{{ $nilai->proposal->mahasiswa->name }}</p>
                                    <p class="text-[10px] text-gray-400 uppercase font-medium">
                                        {{ $nilai->proposal->mahasiswa->nim }}</p>
                                </td>
                                <td class="px-6 py-4">
                                    <p class="text-xs text-gray-600 truncate max-w-[250px]"
                                        title="{{ $nilai->proposal->judul }}">{{ $nilai->proposal->judul }}</p>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @php
                                        $gradeColor = match (true) {
                                            str_contains($nilai->grade, 'A')
                                                => 'bg-green-100 text-green-700 border-green-200',
                                            str_contains($nilai->grade, 'B')
                                                => 'bg-blue-100 text-blue-700 border-blue-200',
                                            str_contains($nilai->grade, 'C')
                                                => 'bg-yellow-100 text-yellow-700 border-yellow-200',
                                            default => 'bg-red-100 text-red-700 border-red-200',
                                        };
                                    @endphp
                                    <span
                                        class="px-3 py-1 rounded-lg text-xs font-black border {{ $gradeColor }}">{{ $nilai->grade }}</span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <button
                                        @click="openEdit('{{ $nilai->id }}', '{{ $nilai->proposal->mahasiswa->name }}', '{{ $nilai->grade }}', '{{ addslashes($nilai->keterangan ?? '') }}', '{{ addslashes($nilai->proposal->judul) }}')"
                                        class="p-2 text-blue-500 hover:bg-blue-50 rounded-lg transition">
                                        <i class="fas fa-pencil-alt text-xs"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center text-gray-400">Belum ada riwayat penilaian.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="md:hidden space-y-3">
                @foreach ($sudahDinilai as $nilai)
                    <div class="bg-white p-4 rounded-xl border border-gray-100 shadow-sm flex justify-between items-center">
                        <div class="min-w-0 flex-1 pr-4">
                            <p class="font-bold text-gray-800 text-xs truncate">{{ $nilai->proposal->mahasiswa->name }}</p>
                            <p class="text-[10px] text-gray-400 truncate">{{ $nilai->proposal->judul }}</p>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="text-xs font-black text-gray-800">{{ $nilai->grade }}</span>
                            <button
                                @click="openEdit('{{ $nilai->id }}', '{{ $nilai->proposal->mahasiswa->name }}', '{{ $nilai->grade }}', '{{ addslashes($nilai->keterangan ?? '') }}', '{{ addslashes($nilai->proposal->judul) }}')"
                                class="w-8 h-8 flex items-center justify-center bg-blue-50 text-blue-600 rounded-full">
                                <i class="fas fa-edit text-[10px]"></i>
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <template x-teleport="body">
            <div x-show="open" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                class="fixed inset-0 z-[100] flex items-end md:items-center justify-center bg-gray-900/60 backdrop-blur-sm p-0 md:p-4"
                x-cloak>

                <div @click.away="open = false"
                    class="bg-white w-full max-w-lg rounded-t-3xl md:rounded-2xl shadow-2xl overflow-hidden animate-slide-up md:animate-none">

                    <form :action="actionUrl" method="POST">
                        @csrf
                        <template x-if="editMode">
                            <input type="hidden" name="_method" value="PUT">
                        </template>
                        <input type="hidden" name="proposal_id" :value="proposalId">

                        <div class="px-6 py-4 border-b flex justify-between items-center bg-gray-50/50">
                            <h3 class="font-bold text-gray-800"
                                x-text="editMode ? 'Edit Nilai Proposal' : 'Input Nilai Proposal'"></h3>
                            <button type="button" @click="open = false"
                                class="text-gray-400 hover:text-gray-600 font-bold text-2xl">&times;</button>
                        </div>

                        <div class="p-6 space-y-5">
                            <div class="bg-green-50 p-4 rounded-2xl border border-green-100 relative overflow-hidden">
                                <div class="relative z-10 flex justify-between items-start">
                                    <div class="min-w-0">
                                        <p class="text-[9px] font-bold text-green-500 uppercase tracking-widest mb-1">
                                            Mahasiswa</p>
                                        <p class="font-bold text-gray-800 text-sm truncate" x-text="studentName"></p>
                                    </div>
                                    <div class="h-8 w-8 bg-white rounded-lg flex items-center justify-center shadow-sm">
                                        <i class="fas fa-file-alt text-green-500 text-xs"></i>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <p
                                        class="text-[9px] font-bold text-green-500 uppercase tracking-widest mb-1 opacity-60">
                                        Judul Proposal</p>
                                    <p class="text-[11px] text-gray-600 italic leading-relaxed line-clamp-2"
                                        x-text="proposalTitle"></p>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-[10px] font-bold text-gray-400 uppercase mb-1.5 ml-1">Grade
                                        Nilai</label>
                                    <select name="grade" x-model="grade" required
                                        class="w-full border-gray-200 rounded-xl text-sm font-bold focus:ring-green-500 focus:border-green-500 transition">
                                        <option value="">-- Pilih --</option>
                                        @foreach (['A+', 'A', 'A-', 'B+', 'B', 'B-', 'C+', 'C', 'C-', 'D', 'E'] as $g)
                                            <option value="{{ $g }}">{{ $g }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="hidden md:flex flex-col justify-end pb-1">
                                    <p class="text-[10px] text-gray-400 leading-tight">Nilai ini akan menjadi bagian dari
                                        hasil akhir ujian proposal mahasiswa.</p>
                                </div>
                            </div>

                            <div>
                                <label class="block text-[10px] font-bold text-gray-400 uppercase mb-1.5 ml-1">Catatan
                                    Tambahan</label>
                                <textarea name="keterangan" x-model="keterangan" rows="3"
                                    class="w-full border-gray-200 rounded-xl text-sm focus:ring-green-500 focus:border-green-500 font-medium"
                                    placeholder="Tuliskan catatan atau masukan perbaikan..."></textarea>
                            </div>
                        </div>

                        <div class="p-4 bg-gray-50 flex flex-col md:flex-row gap-2">
                            <button type="submit"
                                class="w-full md:order-2 px-6 py-3 bg-green-600 text-white rounded-xl font-bold text-sm shadow-lg shadow-green-100 hover:bg-green-700 transition uppercase tracking-widest">Simpan
                                Nilai</button>
                            <button type="button" @click="open = false"
                                class="w-full md:order-1 px-6 py-3 bg-white text-gray-500 border border-gray-200 rounded-xl font-bold text-sm hover:bg-gray-100 transition uppercase tracking-widest">Batal</button>
                        </div>
                    </form>
                </div>
            </div>
        </template>
    </div>
@endsection
