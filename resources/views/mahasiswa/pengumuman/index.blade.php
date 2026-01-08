@extends('layouts.app')

@section('title', 'Daftar Pengumuman')

@section('content')
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">@yield('title')</h1>
            <p class="text-gray-500 text-sm mt-1">Informasi dan berita terbaru terkait akademik.</p>
        </div>
        <nav class="text-sm font-medium text-gray-500 bg-gray-100 px-4 py-2 rounded-lg">
            <ol class="list-reset flex items-center gap-2">
                <li><a href="{{ route('mahasiswa.dashboard') }}" class="hover:text-green-600">Home</a></li>
                <li><span class="mx-2">/</span></li>
                <li class="text-green-600">Pengumuman</li>
            </ol>
        </nav>
    </div>

    @if ($pengumumans->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($pengumumans as $p)
                <div
                    class="bg-white rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow duration-300 flex flex-col h-full group">
                    <div class="p-6 flex-1">
                        <div class="flex justify-between items-start mb-4">
                            <span
                                class="px-3 py-1 text-xs font-semibold text-blue-600 bg-blue-50 rounded-full border border-blue-100">
                                {{ $p->nomor_surat }}
                            </span>
                            <span class="text-xs text-gray-400 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                {{ \Carbon\Carbon::parse($p->tanggal)->translatedFormat('d M Y') }}
                            </span>
                        </div>

                        <h3 class="text-lg font-bold text-gray-800 mb-2 group-hover:text-green-600 transition-colors">
                            <a href="{{ route('pengumuman.show', $p->id) }}">
                                {{ Str::limit($p->informasi, 50) }}
                            </a>
                        </h3>
                        <p class="text-gray-500 text-sm leading-relaxed">
                            {{ Str::limit($p->informasi, 100) }}
                        </p>
                    </div>

                    <div
                        class="bg-gray-50 px-6 py-4 border-t border-gray-100 flex justify-between items-center rounded-b-xl">
                        @if ($p->file_path)
                            <span class="flex items-center text-xs text-gray-500" title="Ada Lampiran">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-red-400" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                                </svg>
                                Lampiran
                            </span>
                        @else
                            <span></span>
                        @endif

                        <a href="{{ route('pengumuman.show', $p->id) }}"
                            class="text-sm font-semibold text-green-600 hover:text-green-700 flex items-center transition-colors">
                            Baca Selengkapnya
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 8l4 4m0 0l-4 4m4-4H3" />
                            </svg>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-8">
            {{ $pengumumans->links() }}
        </div>
    @else
        <div class="bg-white rounded-xl shadow-sm p-12 text-center border border-gray-100">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-300 mb-4" fill="none"
                viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
            </svg>
            <h3 class="text-lg font-medium text-gray-900">Belum ada pengumuman</h3>
            <p class="text-gray-500 mt-1">Informasi terbaru akan muncul di halaman ini.</p>
        </div>
    @endif
@endsection
