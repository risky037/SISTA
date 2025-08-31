@extends('layouts.app')

@section('title', 'Daftar Bimbingan Mahasiswa')

@section('content')
    <div class="flex justify-between items-center mb-4">
        <div>
            <h1 class="text-gray-800 text-xl font-semibold">@yield('title')</h1>
            <p class="text-gray-500 text-sm">Halaman untuk melihat daftar bimbingan mahasiswa yang terdaftar pada Anda.</p>
        </div>
        <nav class="text-sm text-gray-500">
            <ol class="list-reset flex">
                <li><a href="{{ route('dosen.dashboard') }}" class="hover:text-green-600">Home</a></li>
                <li><span class="mx-2">/</span></li>
                <li class="text-gray-700">Daftar Bimbingan</li>
            </ol>
        </nav>
    </div>

    <div class="p-6 bg-white rounded-lg shadow-md">
        @if (session('success'))
            <div class="bg-green-100 text-green-800 p-3 rounded-md border border-green-400 mb-4">
                {{ session('success') }}
            </div>
        @endif

        <table class="table-auto w-full mt-4 border border-gray-200 rounded-lg min-w-[600px]">
            <thead class="bg-green-100 text-gray-700">
                <tr>
                    <th scope="col" class="px-2 md:px-4 py-2 border text-left">Hari, Tanggal</th>
                    <th scope="col" class="px-2 md:px-4 py-2 border text-left">Jam</th>
                    <th scope="col" class="px-2 md:px-4 py-2 border text-left">Mahasiswa</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($bimbingans as $bimbingan)
                    <tr>
                        <td class="px-6 py-4">
                            {{ \Carbon\Carbon::parse($bimbingan->tanggal_bimbingan)->translatedFormat('l, d F Y') }}
                        </td>
                        <td class="px-6 py-4">
                            {{ \Carbon\Carbon::parse($bimbingan->waktu_mulai)->format('H:i') }} -
                            {{ \Carbon\Carbon::parse($bimbingan->waktu_selesai)->format('H:i') }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $bimbingan->mahasiswa->name }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center p-4 text-gray-500">Belum ada Jadwal Bimbingan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
