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
                            <strong>Usia:</strong>
                            @php
                                $birthDate = \Carbon\Carbon::parse($child->tanggal_lahir);
                                $now = now();
                                $diff = $birthDate->diff($now);
                                $months = ($diff->y * 12) + $diff->m;
                                $days = $diff->d;
                            @endphp
                            @if ($months > 0)
                                {{ $months }} bulan {{ $days > 0 ? 'lebih ' . $days . ' hari' : '' }}
                            @else
                                {{ $days }} hari
                            @endif
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
                            <div class="col-12 mb-4">
                                <div class="card">
                                    <div class="card-header">
                                        Grafik Berat Badan
                                    </div>
                                    <div class="card-body" style="height: 400px;">
                                        <canvas id="beratChart"></canvas>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mb-4">
                                <div class="card">
                                    <div class="card-header">
                                        Grafik Tinggi Badan
                                    </div>
                                    <div class="card-body" style="height: 400px;">
                                        <canvas id="tinggiChart"></canvas>
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
        <!-- Script Chart.js -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            // Menggunakan $inspections untuk mengambil tanggal pemeriksaan
            const labels = @json($inspections->pluck('tanggal_pemeriksaan')->map(function ($date) {
                return \Carbon\Carbon::parse($date)->format('d-m-Y');
            })->all());
            const dataBerat = @json($inspections->pluck('berat_badan')->map(function ($value) {
                return $value ? floatval($value) : null;
            })->all());
            const dataTinggi = @json($inspections->pluck('tinggi_badan')->map(function ($value) {
                return $value ? floatval($value) : null;
            })->all());

            // Debugging untuk memastikan data tersedia
            console.log('Labels:', labels);
            console.log('Data Berat:', dataBerat);
            console.log('Data Tinggi:', dataTinggi);

            // Grafik Berat Badan
            const ctxBerat = document.getElementById('beratChart').getContext('2d');
            new Chart(ctxBerat, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Berat Badan (kg)',
                        data: dataBerat,
                        fill: false,
                        borderColor: 'rgba(75, 192, 192, 1)',
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        tension: 0.3
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        title: {
                            display: true,
                            text: 'Grafik Pertumbuhan Berat Badan'
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Kg'
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Tanggal Pemeriksaan'
                            }
                        }
                    }
                }
            });

            // Grafik Tinggi Badan
            const ctxTinggi = document.getElementById('tinggiChart').getContext('2d');
            new Chart(ctxTinggi, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Tinggi Badan (cm)',
                        data: dataTinggi,
                        fill: false,
                        borderColor: 'rgba(255, 99, 132, 1)',
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        tension: 0.3
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        title: {
                            display: true,
                            text: 'Grafik Pertumbuhan Tinggi Badan'
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Cm'
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Tanggal Pemeriksaan'
                            }
                        }
                    }
                }
            });
        </script>
    @endif
@endsection