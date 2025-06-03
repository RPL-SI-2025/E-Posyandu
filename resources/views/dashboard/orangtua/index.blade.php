@extends('dashboard.orangtua.layout.app')

@section('title', 'Data Bayi')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard Orang Tua</h1>
    </div>

    <!-- Content Row -->
    <div class="row">
        <!-- Total Bayi Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Bayi</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $childrenCount }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-baby fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Jadwal Posyandu Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Jadwal Posyandu Berikutnya</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                @if($latestEvent)
                                    {{ \Carbon\Carbon::parse($latestEvent->tanggal)->format('d M Y') }}
                                    <div class="text-xs font-weight-bold text-gray-600">
                                        Pukul: {{ \Carbon\Carbon::parse($latestEvent->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($latestEvent->jam_selesai)->format('H:i') }}
                                        <br>Lokasi: {{ $latestEvent->lokasi }}
                                    </div>
                                @else
                                    Belum ada jadwal
                                @endif
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Bayi Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Data Bayi Anda</h6>
            <a href="{{ route('dashboard.orangtua.profiles.index') }}" class="btn btn-sm btn-primary shadow-sm">
                <i class="fas fa-child fa-sm text-white-50"></i> Kelola Profil Anak
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Nama Bayi</th>
                            <th>Tanggal Lahir</th>
                            <th>Jenis Kelamin</th>
                            <th>Berat Badan (Terakhir)</th>
                            <th>Tinggi Badan (Terakhir)</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($childrenData as $child)
                        <tr>
                            <td>{{ $child->nama_anak }}</td>
                            <td>{{ \Carbon\Carbon::parse($child->tanggal_lahir)->format('d-m-Y') }}</td>
                            <td>{{ $child->jenis_kelamin == 'laki-laki' ? 'Laki-laki' : 'Perempuan' }}</td>
                            <td>{{ $child->latest_berat_badan ? $child->latest_berat_badan . ' kg' : 'N/A' }}</td>
                            <td>{{ $child->latest_tinggi_badan ? $child->latest_tinggi_badan . ' cm' : 'N/A' }}</td>
                            <td>
                                <a href="{{ route('dashboard.orangtua.profiles.show', $child->id) }}" class="btn btn-info btn-sm">
                                    <i class="fas fa-eye"></i> Detail
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">Anda belum memiliki data anak. <a href="{{ route('dashboard.orangtua.profiles.create') }}">Tambah data anak sekarang</a>.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Berita/Artikel Section -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Berita Terbaru</h6>
        </div>
        <div class="card-body">
            @if($articles->isEmpty())
                <div class="alert alert-info">
                    Belum ada berita terbaru.
                </div>
            @else
                <div class="row">
                    @foreach($articles as $article)
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            <!-- Debugging Path Gambar -->
                            <!-- <p class="small text-muted">Path: {{ $article->gambar }}</p> -->
                            <!-- Tampilkan Gambar dengan Fallback -->
                            <img src="{{ $article->gambar ? asset('storage/' . $article->gambar) : asset('images/default.jpg') }}"
                                class="card-img-top"
                                alt="{{ $article->judul }}"
                                style="height: 200px; object-fit: cover;"
                                onerror="this.onerror=null; this.src='{{ asset('images/default.jpg') }}';">
                            <div class="card-body">
                                <h5 class="card-title">{{ $article->judul }}</h5>
                                <p class="card-text">{{ Str::limit(strip_tags($article->isi), 100) }}</p>
                                <p class="text-muted small">Oleh: {{ $article->author }} | {{ \Carbon\Carbon::parse($article->created_at)->format('d M Y') }}</p>
                                @if(isset($article->id_artikel) && $article->id_artikel > 0)
                                    <a href="{{ route('dashboard.orangtua.berita.show', $article->id_artikel) }}" class="btn btn-primary btn-sm">Baca Selengkapnya</a>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
