@extends('layouts.app')

@section('title', 'Template Skripsi')

@section('content')
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">@yield('title')</h1>
            <p class="text-gray-500 text-sm mt-1">Unduh dokumen panduan dan template penulisan skripsi standar UICI.</p>
        </div>
        <nav class="text-sm font-medium text-gray-500 bg-gray-100 px-4 py-2 rounded-lg">
            <ol class="list-reset flex items-center gap-2">
                <li><a href="{{ route('mahasiswa.dashboard') }}" class="hover:text-green-600">Home</a></li>
                <li><span class="mx-2 text-gray-300">/</span></li>
                <li class="text-green-600">Template</li>
            </ol>
        </nav>
    </div>

    <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-8 rounded-r-xl shadow-sm flex items-start gap-3">
        <i class="fas fa-info-circle text-blue-500 mt-1"></i>
        <div>
            <h3 class="font-bold text-blue-800 text-sm uppercase tracking-wider">Penting</h3>
            <p class="text-sm text-blue-700 mt-1 leading-relaxed">
                Pastikan Anda mengunduh template yang sesuai dengan Program Studi Anda. Bacalah kolom <strong>Aturan
                    Format</strong> sebelum mulai menulis.
            </p>
        </div>
    </div>

    <div class="hidden md:block bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-5 border-b border-gray-100 bg-gray-50/50 flex justify-between items-center">
            <h2 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                <i class="fas fa-folder-open text-green-600"></i> Daftar Dokumen
            </h2>
            <span
                class="text-[10px] font-bold px-2.5 py-1 rounded-full bg-gray-200 text-gray-700 uppercase tracking-widest">
                {{ $templates->total() }} File Tersedia
            </span>
        </div>

        <table class="w-full text-sm text-left">
            <thead class="text-xs text-gray-400 uppercase tracking-wider bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="px-6 py-4 font-bold text-gray-700">Nama Dokumen</th>
                    <th class="px-6 py-4 font-bold text-gray-700">Program Studi</th>
                    <th class="px-6 py-4 font-bold text-gray-700">Aturan Format</th>
                    <th class="px-6 py-4 font-bold text-center text-gray-700">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($templates as $template)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-5">
                            <div class="flex items-center gap-4">
                                @php
                                    $fileColor = match (strtolower($template->tipe_file)) {
                                        'pdf' => 'bg-red-50 text-red-500',
                                        'doc', 'docx' => 'bg-blue-50 text-blue-500',
                                        default => 'bg-gray-50 text-gray-500',
                                    };
                                    $fileIcon = match (strtolower($template->tipe_file)) {
                                        'pdf' => 'fa-file-pdf',
                                        'doc', 'docx' => 'fa-file-word',
                                        default => 'fa-file-alt',
                                    };
                                @endphp
                                <div
                                    class="w-10 h-10 rounded-xl {{ $fileColor }} flex items-center justify-center text-xl shadow-sm">
                                    <i class="fas {{ $fileIcon }}"></i>
                                </div>
                                <div>
                                    <p class="font-bold text-gray-800 text-base leading-tight">
                                        {{ $template->nama_template }}</p>
                                    <p class="text-[10px] text-gray-400 uppercase font-bold tracking-widest mt-1">Format:
                                        {{ $template->tipe_file }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-5">
                            @if ($template->prodi)
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-lg text-[10px] font-bold uppercase tracking-wider bg-indigo-50 text-indigo-700 border border-indigo-100">
                                    {{ $template->prodi }}
                                </span>
                            @else
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-lg text-[10px] font-bold uppercase tracking-wider bg-gray-100 text-gray-500 border border-gray-200">
                                    Semua Prodi
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-5">
                            <p class="text-gray-500 italic text-xs line-clamp-2 max-w-xs">
                                {{ $template->aturan_format ?? 'Gunakan format standar penulisan.' }}</p>
                        </td>
                        <td class="px-6 py-5 text-center">
                            <a href="{{ asset('storage/' . $template->file_path) }}" target="_blank"
                                class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-xl text-xs font-bold uppercase tracking-widest hover:bg-green-700 transition-all shadow-lg shadow-green-100 group">
                                <i class="fas fa-download mr-2 group-hover:animate-bounce"></i> Unduh
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-10 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                    </path>
                                </svg>
                                <p class="text-gray-500 text-sm">Belum ada data yang ditemukan.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="grid grid-cols-1 gap-4 md:hidden">
        @forelse ($templates as $template)
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 flex flex-col h-full group overflow-hidden">
                <div class="p-6 flex-1">
                    <div class="flex justify-between items-start mb-4">
                        <span
                            class="px-2 py-1 text-[10px] font-bold text-indigo-600 bg-indigo-50 rounded border border-indigo-100 uppercase tracking-widest">
                            {{ $template->prodi ?? 'Umum' }}
                        </span>
                        <span class="text-[10px] font-bold text-gray-400 flex items-center uppercase tracking-widest">
                            <i class="fas fa-clock mr-1"></i> {{ $template->updated_at->format('d M Y') }}
                        </span>
                    </div>

                    <div class="flex items-center gap-3 mb-4">
                        <div
                            class="w-10 h-10 rounded-lg bg-gray-50 flex items-center justify-center text-gray-400 group-hover:bg-green-50 group-hover:text-green-600 transition-colors">
                            <i class="fas fa-file-alt text-lg"></i>
                        </div>
                        <h3
                            class="text-lg font-bold text-gray-800 leading-tight group-hover:text-green-600 transition-colors">
                            {{ $template->nama_template }}
                        </h3>
                    </div>

                    <div class="bg-gray-50 rounded-xl p-3 border border-gray-100">
                        <p class="text-xs text-gray-500 italic leading-relaxed">
                            <span class="font-bold text-gray-700 not-italic">Aturan:</span>
                            {{ Str::limit($template->aturan_format ?? 'Gunakan format standar penulisan.', 80) }}
                        </p>
                    </div>
                </div>

                <div class="bg-gray-50 px-6 py-4 border-t border-gray-100 flex justify-between items-center">
                    <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">
                        Format: <span class="text-gray-700">{{ $template->tipe_file }}</span>
                    </span>

                    <a href="{{ asset('storage/' . $template->file_path) }}" target="_blank"
                        class="text-sm font-bold text-green-600 hover:text-green-700 flex items-center transition-colors">
                        Unduh File
                        <i class="fas fa-arrow-down ml-2 animate-bounce"></i>
                    </a>
                </div>
            </div>
        @empty
            <div class="p-8 text-center bg-white rounded-2xl border border-dashed border-gray-200">
                <p class="text-gray-400 text-sm">Belum ada template.</p>
            </div>
        @endforelse
    </div>

    @if ($templates->hasPages())
        <div class="mt-8">
            {{ $templates->links() }}
        </div>
    @endif
@endsection
