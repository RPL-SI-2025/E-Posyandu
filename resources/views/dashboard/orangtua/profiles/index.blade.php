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
                                            <strong>Jenis Kelamin:</strong> {{ $child->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
                                        </li>
                                        <li class="list-group-item">
                                            <strong>Usia:</strong> {{ \Carbon\Carbon::parse($child->tanggal_lahir)->diffInMonths(now()) }} bulan
                                        </li>
                                    </ul>
                                </div>
                                <div class="card-footer">
                                    <a href="{{ route('dashboard.orangtua.profiles.show', $child->id) }}" class="btn btn-primary w-100">
                                        <i class="fas fa-chart-line me-1"></i> Lihat Perkembangan
                                    </a>
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