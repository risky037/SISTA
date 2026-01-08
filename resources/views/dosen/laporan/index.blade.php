@extends('layouts.app')

@section('title', 'Laporan Progress Mahasiswa')

@section('content')
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">@yield('title')</h1>
            <p class="text-gray-500 text-sm mt-1">Visualisasi performa bimbingan dan status kelulusan dokumen
            </p>
        </div>
        <nav class="text-sm font-medium text-gray-500 bg-gray-100 px-4 py-2 rounded-lg">
            <ol class="list-reset flex items-center gap-2">
                <li><a href="{{ route('dosen.dashboard') }}" class="hover:text-green-600">Home</a></li>
                <li><span class="mx-2">/</span></li>
                <li class="text-green-600">@yield('title')</li>
            </ol>
        </nav>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div
            class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-5 group hover:border-green-500 transition-colors duration-300">
            <div
                class="h-14 w-14 bg-green-50 text-green-600 rounded-2xl flex items-center justify-center text-2xl transition-transform group-hover:scale-110">
                <i class="fas fa-users"></i>
            </div>
            <div>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Total Bimbingan</p>
                <h3 class="text-2xl font-black text-gray-800">{{ $totalBimbingan }} <span
                        class="text-sm font-medium text-gray-400">Orang</span></h3>
            </div>
        </div>

        <div
            class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-5 group hover:border-blue-500 transition-colors duration-300">
            <div
                class="h-14 w-14 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center text-2xl transition-transform group-hover:scale-110">
                <i class="fas fa-file-signature"></i>
            </div>
            <div>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Proposal Dinilai</p>
                <h3 class="text-2xl font-black text-gray-800">{{ $totalNilaiProposal }} <span
                        class="text-sm font-medium text-gray-400">File</span></h3>
            </div>
        </div>

        <div
            class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-5 group hover:border-amber-500 transition-colors duration-300">
            <div
                class="h-14 w-14 bg-amber-50 text-amber-600 rounded-2xl flex items-center justify-center text-2xl transition-transform group-hover:scale-110">
                <i class="fas fa-graduation-cap"></i>
            </div>
            <div>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Dokumen Dinilai</p>
                <h3 class="text-2xl font-black text-gray-800">{{ $totalNilaiDokumen }} <span
                        class="text-sm font-medium text-gray-400">File</span></h3>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

        <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
            <div class="flex items-center justify-between mb-8">
                <h3 class="font-bold text-gray-800 flex items-center gap-2">
                    <span class="w-1.5 h-5 bg-green-500 rounded-full"></span>
                    Status Proposal
                </h3>
            </div>

            <div class="relative min-h-[300px] flex items-center justify-center">
                @if (
                    ($proposalStatus['pending'] ?? 0) == 0 &&
                        ($proposalStatus['diterima'] ?? 0) == 0 &&
                        ($proposalStatus['ditolak'] ?? 0) == 0)
                    <div class="text-center">
                        <img src="https://illustrations.popsy.co/gray/no-messages.svg" class="h-40 mx-auto mb-4"
                            alt="No data">
                        <p class="text-sm text-gray-400 italic">Belum ada data proposal yang diajukan.</p>
                    </div>
                @else
                    <canvas id="proposalChart"></canvas>
                @endif
            </div>
        </div>

        <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
            <div class="flex items-center justify-between mb-8">
                <h3 class="font-bold text-gray-800 flex items-center gap-2">
                    <span class="w-1.5 h-5 bg-blue-500 rounded-full"></span>
                    Status Dokumen Akhir
                </h3>
            </div>

            <div class="relative min-h-[300px] flex items-center justify-center">
                @if (
                    ($dokumenStatus['pending'] ?? 0) == 0 &&
                        ($dokumenStatus['approved'] ?? 0) == 0 &&
                        ($dokumenStatus['rejected'] ?? 0) == 0)
                    <div class="text-center">
                        <img src="https://illustrations.popsy.co/gray/analysis.svg" class="h-40 mx-auto mb-4"
                            alt="No data">
                        <p class="text-sm text-gray-400 italic">Belum ada data dokumen akhir.</p>
                    </div>
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
        Chart.defaults.font.family = "'Plus Jakarta Sans', sans-serif";
        Chart.defaults.color = '#94a3b8';

        if (document.getElementById('proposalChart')) {
            new Chart(document.getElementById('proposalChart'), {
                type: 'doughnut',
                data: {
                    labels: ['Menunggu', 'Diterima', 'Ditolak'],
                    datasets: [{
                        data: [
                            {{ $proposalStatus['pending'] ?? 0 }},
                            {{ $proposalStatus['diterima'] ?? 0 }},
                            {{ $proposalStatus['ditolak'] ?? 0 }}
                        ],
                        backgroundColor: ['#f59e0b', '#10b981', '#ef4444'],
                        borderWidth: 0,
                        hoverOffset: 20
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '75%',
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                usePointStyle: true,
                                padding: 25,
                                font: {
                                    size: 11,
                                    weight: '600'
                                }
                            }
                        }
                    }
                }
            });
        }

        if (document.getElementById('dokumenChart')) {
            new Chart(document.getElementById('dokumenChart'), {
                type: 'bar',
                data: {
                    labels: ['Pending', 'Approved', 'Rejected'],
                    datasets: [{
                        label: 'Jumlah Dokumen',
                        data: [
                            {{ $dokumenStatus['pending'] ?? 0 }},
                            {{ $dokumenStatus['approved'] ?? 0 }},
                            {{ $dokumenStatus['rejected'] ?? 0 }}
                        ],
                        backgroundColor: [
                            'rgba(245, 158, 11, 0.1)',
                            'rgba(16, 185, 129, 0.1)',
                            'rgba(239, 68, 68, 0.1)'
                        ],
                        borderColor: ['#f59e0b', '#10b981', '#ef4444'],
                        borderWidth: 2,
                        borderRadius: 12,
                        borderSkipped: false,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                display: false
                            },
                            ticks: {
                                stepSize: 1
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                font: {
                                    weight: '600'
                                }
                            }
                        }
                    }
                }
            });
        }
    </script>
@endpush
