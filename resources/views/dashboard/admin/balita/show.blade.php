@extends('dashboard.admin.layout.app')

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
                            <a href="{{ route('dashboard.admin.balita.edit', $balita->id) }}" class="btn btn-warning me-2">
                                <i class="fas fa-edit me-2"></i>Edit
                            </a>
                            <a href="{{ route('dashboard.admin.balita.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Kembali
                            </a>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <table class="table">
                                <tr>
                                    <th style="width: 200px">Nama Anak</th>
                                    <td>: {{ $balita->nama_anak }}</td>
                                </tr>
                                <tr>
                                    <th>Nama Orang Tua</th>
                                    <td>: {{ $balita->user->name ?? 'N/A' }}</td>
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
                                    <th>Berat Badan Terakhir</th>
                                    <td>: {{ $balita->latestInspection->berat_badan ?? 'Belum ada data' }} kg</td>
                                </tr>
                                <tr>
                                    <th>Tinggi Badan Terakhir</th>
                                    <td>: {{ $balita->latestInspection->tinggi_badan ?? 'Belum ada data' }} cm</td>
                                </tr>
                                <tr>
                                    <th>Lingkar Kepala Terakhir</th>
                                    <td>: {{ $balita->latestInspection->lingkar_kepala ?? 'Belum ada data' }} cm</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    {{-- Growth Charts --}}
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <h5 class="mb-3">Grafik Pertumbuhan</h5>
                            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#weight-chart" type="button">Berat Badan</button>
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#height-chart" type="button">Tinggi Badan</button>
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#head-chart" type="button">Lingkar Kepala</button>
                            </div>
                            <div class="tab-content mt-3" id="nav-tabContent">
                                <div class="tab-pane fade show active" id="weight-chart">
                                    <canvas id="weightChart"></canvas>
                                </div>
                                <div class="tab-pane fade" id="height-chart">
                                    <canvas id="heightChart"></canvas>
                                </div>
                                <div class="tab-pane fade" id="head-chart">
                                    <canvas id="headChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <form action="{{ route('dashboard.admin.balita.destroy', $balita->id) }}" method="POST" class="d-inline">
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
    // Prepare the data
    const inspections = @json($balita->inspections);
    const dates = inspections.map(i => i.tanggal_pemeriksaan);
    const weights = inspections.map(i => i.berat_badan);
    const heights = inspections.map(i => i.tinggi_badan);
    const headCircs = inspections.map(i => i.lingkar_kepala);

    // Weight Chart
    new Chart(document.getElementById('weightChart'), {
        type: 'line',
        data: {
            labels: dates,
            datasets: [{
                label: 'Berat Badan (kg)',
                data: weights,
                borderColor: 'rgb(75, 192, 192)',
                tension: 0.1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: false
                }
            }
        }
    });

    // Height Chart
    new Chart(document.getElementById('heightChart'), {
        type: 'line',
        data: {
            labels: dates,
            datasets: [{
                label: 'Tinggi Badan (cm)',
                data: heights,
                borderColor: 'rgb(255, 99, 132)',
                tension: 0.1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: false
                }
            }
        }
    });

    // Head Circumference Chart
    new Chart(document.getElementById('headChart'), {
        type: 'line',
        data: {
            labels: dates,
            datasets: [{
                label: 'Lingkar Kepala (cm)',
                data: headCircs,
                borderColor: 'rgb(153, 102, 255)',
                tension: 0.1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: false
                }
            }
        }
    });
</script>
@endpush
@endsection 