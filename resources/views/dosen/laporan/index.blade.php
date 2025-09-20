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
        @if (session('success'))
            <div class="bg-green-100 text-green-800 p-3 rounded-md border border-green-400 mb-4">
                {{ session('success') }}
            </div>
        @endif

        {{-- Grafik Ringkasan --}}
        <div class="w-full mb-8">
            <canvas id="progressChart"></canvas>
        </div>

        {{-- Tabel Detail --}}
        <div class="overflow-x-auto">
            <table class="table-auto w-full mt-4 border border-gray-200 rounded-lg min-w-[600px]">
                <thead class="bg-green-100 text-gray-700">
                    <tr>
                        <th class="px-4 py-2 border text-left">Mahasiswa</th>
                        <th class="px-4 py-2 border text-left">Judul Laporan</th>
                        <th class="px-4 py-2 border text-center">Status</th>
                        <th class="px-4 py-2 border text-center">Diterima?</th>
                        <th class="px-4 py-2 border text-left">Catatan Dosen</th>
                        <th class="px-4 py-2 border text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($laporan as $row)
                        @php
                            $statusClass = match ($row->status) {
                                'submitted' => 'bg-yellow-100 text-yellow-800',
                                'approved' => 'bg-green-100 text-green-800',
                                default => 'bg-gray-100 text-gray-800',
                            };
                        @endphp
                        <tr>
                            <td class="px-4 py-2 text-sm text-gray-900">{{ $row->mahasiswa->name }}</td>
                            <td class="px-4 py-2 text-sm text-gray-900">{{ $row->judul_laporan }}</td>
                            <td class="px-4 py-2 text-center text-sm">
                                <span class="px-2 inline-flex text-xs font-semibold rounded-full {{ $statusClass }}">
                                    {{ ucfirst($row->status) }}
                                </span>
                            </td>
                            <td class="px-4 py-2 text-center text-sm font-semibold">
                                @if ($row->status === 'approved')
                                    <span class="text-green-600">✔ Diterima</span>
                                @else
                                    <span class="text-red-600">✘ Belum</span>
                                @endif
                            </td>
                            <td class="px-4 py-2 text-sm text-gray-500">{{ $row->catatan_dosen ?? '-' }}</td>
                            <td class="px-4 py-2 text-center text-sm font-medium">
                                <a href="{{ route('dosen.laporan-progress.show', $row->id) }}"
                                   class="text-blue-600 hover:text-blue-900 underline">
                                    Lihat Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center p-4 text-gray-500">Belum ada laporan progress.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('progressChart').getContext('2d');

    // Hitung jumlah per status
    const submitted = {{ $laporan->where('status', 'submitted')->count() }};
    const approved  = {{ $laporan->where('status', 'approved')->count() }};
    const pending   = {{ $laporan->whereNotIn('status', ['submitted','approved'])->count() }};

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Submitted', 'Approved', 'Pending'],
            datasets: [{
                label: 'Jumlah Laporan',
                data: [submitted, approved, pending],
                backgroundColor: [
                    'rgba(255, 206, 86, 0.6)',  // kuning
                    'rgba(75, 192, 192, 0.6)',  // hijau
                    'rgba(201, 203, 207, 0.6)'  // abu
                ],
                borderColor: [
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(201, 203, 207, 1)'
                ],
                borderWidth: 1,
                borderRadius: 6
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                title: {
                    display: true,
                    text: 'Distribusi Status Laporan Mahasiswa'
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1 }
                }
            }
        }
    });
</script>
@endpush
