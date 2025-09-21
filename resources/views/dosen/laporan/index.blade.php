@extends('layouts.app')

@section('title', 'Laporan Progress Mahasiswa')

@section('content')
    <div class="flex justify-between items-center mb-4">
        <div>
            <h1 class="text-gray-800 text-xl font-semibold">@yield('title')</h1>
            <p class="text-gray-500 text-sm">Visualisasi progres laporan mahasiswa dalam bentuk grafik dan tabel detail.</p>
        </div>
        <nav class="text-sm text-gray-500">
            <ol class="list-reset flex">
                <li><a href="{{ route('dosen.dashboard') }}" class="hover:text-green-600">Home</a></li>
                <li><span class="mx-2">/</span></li>
                <li class="text-gray-700">Laporan Progress</li>
            </ol>
        </nav>
    </div>

    <div class="p-6 bg-white rounded-lg shadow-md">
        <h2 class="text-lg font-semibold mb-4">Statistik Progress Mahasiswa</h2>
        <div class="my-6 grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="p-4 bg-green-100 rounded">
                <div class="text-sm text-gray-600">Total Bimbingan</div>
                <div class="text-2xl font-bold">{{ $totalBimbingan }}</div>
            </div>
            <div class="p-4 bg-blue-100 rounded">
                <div class="text-sm text-gray-600">Proposal Dinilai</div>
                <div class="text-2xl font-bold">{{ $totalNilaiProposal }}</div>
            </div>
            <div class="p-4 bg-yellow-100 rounded">
                <div class="text-sm text-gray-600">Dokumen Akhir Dinilai</div>
                <div class="text-2xl font-bold">{{ $totalNilaiDokumen }}</div>
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- Grafik Proposal --}}
            <div class="bg-gray-100 p-4 rounded">
                <h3 class="font-semibold mb-2">Status Proposal</h3>
                @if (
                    ($proposalStatus['pending'] ?? 0) == 0 &&
                        ($proposalStatus['diterima'] ?? 0) == 0 &&
                        ($proposalStatus['ditolak'] ?? 0) == 0)
                    <p class="text-center text-gray-500 py-10">Belum ada proposal yang diajukan.</p>
                @else
                    <canvas id="proposalChart"></canvas>
                @endif
            </div>

            {{-- Grafik Dokumen Akhir --}}
            <div class="bg-gray-100 p-4 rounded">
                <h3 class="font-semibold mb-2">Status Dokumen Akhir</h3>
                @if (
                    ($dokumenStatus['pending'] ?? 0) == 0 &&
                        ($dokumenStatus['approved'] ?? 0) == 0 &&
                        ($dokumenStatus['rejected'] ?? 0) == 0)
                    <p class="text-center text-gray-500 py-10">Belum ada dokumen akhir yang diajukan.</p>
                @else
                    <canvas id="dokumenChart"></canvas>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        if (document.getElementById('proposalChart')) {
            const proposalChart = new Chart(document.getElementById('proposalChart'), {
                type: 'doughnut',
                data: {
                    labels: ['Pending', 'Diterima', 'Ditolak'],
                    datasets: [{
                        label: 'Proposal',
                        data: [
                            {{ $proposalStatus['pending'] ?? 0 }},
                            {{ $proposalStatus['diterima'] ?? 0 }},
                            {{ $proposalStatus['ditolak'] ?? 0 }}
                        ],
                        backgroundColor: ['#fbbf24', '#10b981', '#ef4444']
                    }]
                }
            });
        }

        if (document.getElementById('dokumenChart')) {
            const dokumenChart = new Chart(document.getElementById('dokumenChart'), {
                type: 'bar',
                data: {
                    labels: ['Pending', 'Approved', 'Rejected'],
                    datasets: [{
                        label: 'Dokumen Akhir',
                        data: [
                            {{ $dokumenStatus['pending'] ?? 0 }},
                            {{ $dokumenStatus['approved'] ?? 0 }},
                            {{ $dokumenStatus['rejected'] ?? 0 }}
                        ],
                        backgroundColor: ['#fbbf24', '#10b981', '#ef4444']
                    }]
                }
            });
        }
    </script>
@endpush

