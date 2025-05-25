@extends('dashboard.petugas.layout.app')

@section('content')
<div class="container-fluid px-4">
    <div class="row mt-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="card-title mb-0 text-dark">
                            <i class="fas fa-child me-2"></i>Detail Data Balita
                        </h5>
                        <div>
                            <a href="{{ route('dashboard.petugas.balita.edit', $balita->id) }}" class="btn btn-warning me-2">
                                <i class="fas fa-edit me-2"></i>Edit
                            </a>
                            <a href="{{ route('dashboard.petugas.balita.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Kembali
                            </a>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <table class="table">
                                <tr>
                                    <th style="width: 200px">ID User (Orang Tua)</th>
                                    <td>: {{ $balita->user_id }}</td>
                                </tr>
                                <tr>
                                    <th>Nama Orang Tua</th>
                                    <td>: {{ $balita->user->name ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Nama Anak</th>
                                    <td>: {{ $balita->nama_anak }}</td>
                                </tr>
                                <tr>
                                    <th>NIK</th>
                                    <td>: {{ $balita->nik }}</td>
                                </tr>
                                <tr>
                                    <th>Tanggal Lahir</th>
                                    <td>: {{ \Carbon\Carbon::parse($balita->tanggal_lahir)->format('d/m/Y') }}</td>
                                </tr>
                                <tr>
                                    <th>Jenis Kelamin</th>
                                    <td>: 
                                        @if($balita->jenis_kelamin == 'perempuan')
                                            <span class="badge bg-info">Perempuan</span>
                                        @else
                                            <span class="badge bg-primary">Laki-laki</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Tanggal Dibuat</th>
                                    <td>: {{ \Carbon\Carbon::parse($balita->created_at)->format('d/m/Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <th>Terakhir Diupdate</th>
                                    <td>: {{ \Carbon\Carbon::parse($balita->updated_at)->format('d/m/Y H:i') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <!-- Growth Chart Section -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card border-0 shadow-sm">
                                <div class="card-body">
                                    <h5 class="card-title mb-4">
                                        <i class="fas fa-chart-line me-2"></i>Grafik Pertumbuhan
                                    </h5>
                                    <canvas id="growthChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <form action="{{ route('dashboard.petugas.balita.destroy', $balita->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                <i class="fas fa-trash me-2"></i>Hapus Data
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const growthData = {
        labels: {!! json_encode($growthData->pluck('date')) !!},
        datasets: [
            {
                label: 'Berat (kg)',
                data: {!! json_encode($growthData->pluck('berat')) !!},
                borderColor: 'rgb(75, 192, 192)',
                tension: 0.1
            },
            {
                label: 'Tinggi (cm)',
                data: {!! json_encode($growthData->pluck('tinggi')) !!},
                borderColor: 'rgb(255, 99, 132)',
                tension: 0.1
            }
        ]
    };

    const ctx = document.getElementById('growthChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: growthData,
        options: {
            responsive: true,
            plugins: {
                title: {
                    display: true,
                    text: 'Grafik Pertumbuhan Balita'
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let label = context.dataset.label || '';
                            if (label) {
                                label += ': ';
                            }
                            if (context.parsed.y !== null) {
                                label += context.parsed.y.toFixed(1);
                            }
                            return label;
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
@endpush
@endsection 