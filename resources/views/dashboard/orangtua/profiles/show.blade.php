@extends('dashboard.orangtua.layout.app')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Perkembangan Anak</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('dashboard.orangtua.index') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('dashboard.orangtua.profiles.index') }}">Profil Anak</a></li>
        <li class="breadcrumb-item active">{{ $child->nama_anak ?? $child->nama }}</li>
    </ol>
    
    <div class="row">
        <div class="col-xl-4">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-user me-1"></i>
                    Informasi Anak
                </div>
                <div class="card-body">
                    <div class="mb-3 text-center">
                        <i class="fas fa-child fa-5x text-primary mb-3"></i>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <strong>Nama:</strong> {{ $child->nama_anak ?? $child->nama }}
                        </li>
                        <li class="list-group-item">
                            <strong>Tanggal Lahir:</strong> {{ \Carbon\Carbon::parse($child->tanggal_lahir)->format('d-m-Y') }}
                        </li>
                        <li class="list-group-item">
                            <strong>Jenis Kelamin:</strong> {{ $child->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
                        </li>
                        <li class="list-group-item">
                            <strong>Usia:</strong> {{ \Carbon\Carbon::parse($child->tanggal_lahir)->diffInMonths(now()) }} bulan
                        </li>
                        @if(isset($child->berat_lahir))
                        <li class="list-group-item">
                            <strong>Berat Lahir:</strong> {{ $child->berat_lahir }} kg
                        </li>
                        @endif
                        @if(isset($child->tinggi_lahir))
                        <li class="list-group-item">
                            <strong>Tinggi Lahir:</strong> {{ $child->tinggi_lahir }} cm
                        </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
        
        <div class="col-xl-8">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-chart-line me-1"></i>
                    Riwayat Pemeriksaan
                </div>
                <div class="card-body">
                    @if($inspections->isEmpty())
                        <div class="alert alert-info">
                            Belum ada data pemeriksaan untuk anak ini.
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped" id="inspectionTable">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Berat (kg)</th>
                                        <th>Tinggi (cm)</th>
                                        <th>Lingkar Kepala (cm)</th>
                                        <th>Status Gizi</th>
                                        <th>Catatan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($inspections as $inspection)
                                        <tr>
                                            <td>{{ \Carbon\Carbon::parse($inspection->tanggal_pemeriksaan)->format('d-m-Y') }}</td>
                                            <td>{{ $inspection->berat_badan }}</td>
                                            <td>{{ $inspection->tinggi_badan }}</td>
                                            <td>{{ $inspection->lingkar_kepala ?? '-' }}</td>
                                            <td>
                                                @if(isset($inspection->status_gizi))
                                                    @if($inspection->status_gizi == 'Baik')
                                                        <span class="badge bg-success">{{ $inspection->status_gizi }}</span>
                                                    @elseif($inspection->status_gizi == 'Kurang')
                                                        <span class="badge bg-warning">{{ $inspection->status_gizi }}</span>
                                                    @elseif($inspection->status_gizi == 'Buruk')
                                                        <span class="badge bg-danger">{{ $inspection->status_gizi }}</span>
                                                    @else
                                                        <span class="badge bg-secondary">{{ $inspection->status_gizi }}</span>
                                                    @endif
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>{{ $inspection->catatan ?? '-' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Growth Charts -->
                        <div class="row mt-4">
                            <div class="col-md-6 mb-4">
                                <div class="card">
                                    <div class="card-header">
                                        Grafik Berat Badan
                                    </div>
                                    <div class="card-body">
                                        <canvas id="weightChart"></canvas>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <div class="card">
                                    <div class="card-header">
                                        Grafik Tinggi Badan
                                    </div>
                                    <div class="card-body">
                                        <canvas id="heightChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
@if(!$inspections->isEmpty())
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    $(document).ready(function() {
        $('#inspectionTable').DataTable({
            responsive: true,
            order: [[0, 'desc']]
        });
        
        // Prepare data for charts
        const dates = {!! json_encode($inspections->pluck('tanggal_pemeriksaan')->map(function($date) {
            return \Carbon\Carbon::parse($date)->format('d-m-Y');
        })->reverse()->values()) !!};
        
        const weights = {!! json_encode($inspections->pluck('berat_badan')->reverse()->values()) !!};
        const heights = {!! json_encode($inspections->pluck('tinggi_badan')->reverse()->values()) !!};
        
        // Weight Chart
        const weightCtx = document.getElementById('weightChart').getContext('2d');
        const weightChart = new Chart(weightCtx, {
            type: 'line',
            data: {
                labels: dates,
                datasets: [{
                    label: 'Berat Badan (kg)',
                    data: weights,
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 2,
                    tension: 0.1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: false
                    }
                }
            }
        });
        
        // Height Chart
        const heightCtx = document.getElementById('heightChart').getContext('2d');
        const heightChart = new Chart(heightCtx, {
            type: 'line',
            data: {
                labels: dates,
                datasets: [{
                    label: 'Tinggi Badan (cm)',
                    data: heights,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 2,
                    tension: 0.1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: false
                    }
                }
            }
        });
    });
</script>
@endif
@endsection