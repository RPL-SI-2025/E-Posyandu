@extends('dashboard.orangtua.layout.app')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Profil Anak</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('dashboard.orangtua.index') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Profil Anak</li>
    </ol>
    
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-child me-1"></i>
            Daftar Anak
        </div>
        <div class="card-body">
            <div class="mb-3">
                <a href="{{ route('dashboard.orangtua.profiles.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Tambah Anak
                </a>
            </div>
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            
            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            
            @if($children->isEmpty())
                <div class="alert alert-info">
                    Anda belum memiliki data anak. Silahkan hubungi petugas posyandu untuk menambahkan data anak Anda.
                </div>
            @else
                <div class="row">
                    @foreach($children as $child)
                        <div class="col-md-4 mb-4">
                            <div class="card h-100">
                                <div class="card-header bg-primary text-white">
                                    {{ $child->nama_anak ?? $child->nama }}
                                </div>
                                <div class="card-body">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item">
                                            <strong>Tanggal Lahir:</strong> {{ \Carbon\Carbon::parse($child->tanggal_lahir)->format('d-m-Y') }}
                                        </li>
                                        <li class="list-group-item">
                                            <strong>Jenis Kelamin:</strong> {{ $child->jenis_kelamin == 'laki-laki' ? 'Laki-laki' : 'Perempuan' }}
                                        </li>
                                        <li class="list-group-item">
                                            <strong>Usia:</strong> 
                                            @php
                                                $birthDate = \Carbon\Carbon::parse($child->tanggal_lahir);
                                                $now = now();
                                                $diff = $birthDate->diff($now); // Mendapatkan selisih dalam tahun, bulan, dan hari
                                                $months = ($diff->y * 12) + $diff->m; // Total bulan (tahun dikonversi ke bulan + bulan)
                                                $days = $diff->d; // Sisa hari
                                            @endphp
                                            @if ($months > 0)
                                                {{ $months }} bulan {{ $days > 0 ? 'lebih ' . $days . ' hari' : '' }}
                                            @else
                                                {{ $days }} hari
                                            @endif
                                        </li>
                                    </ul>
                                </div>
                                <div class="card-footer d-flex justify-content-between">
                                    <a href="{{ route('dashboard.orangtua.profiles.show', $child->id) }}" class="btn btn-primary" dusk="button-view">
                                        <i class="fas fa-chart-line me-1"></i> Lihat Perkembangan
                                    </a>
                                    <div>
                                        <a href="{{ route('dashboard.orangtua.profiles.edit', $child->id) }}" class="btn btn-warning" dusk="button-edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('dashboard.orangtua.profiles.destroy', $child->id) }}" method="POST" class="d-inline" dusk="button-delete">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data anak ini?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
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