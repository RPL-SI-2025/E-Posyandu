@extends('dashboard.orangtua.layout.app')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Edit Data Anak</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('dashboard.orangtua.index') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('dashboard.orangtua.profiles.index') }}">Profil Anak</a></li>
        <li class="breadcrumb-item active">Edit Anak</li>
    </ol>
    
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-baby me-1"></i>
            Form Edit Anak
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            <form action="{{ route('dashboard.orangtua.profiles.update', $child->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-3">
                    <label for="nama_anak" class="form-label">Nama Anak</label>
                    <input type="text" class="form-control @error('nama_anak') is-invalid @enderror" 
                           id="nama_anak" name="nama_anak" value="{{ old('nama_anak', $child->nama_anak) }}" required>
                    @error('nama_anak')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                    <input type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror" 
                           id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir', $child->tanggal_lahir) }}" required>
                    @error('tanggal_lahir')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                    <select class="form-select @error('jenis_kelamin') is-invalid @enderror" 
                            id="jenis_kelamin" name="jenis_kelamin" required>
                        <option value="">Pilih Jenis Kelamin</option>
                        <option value="laki-laki" {{ (old('jenis_kelamin', $child->jenis_kelamin) == 'laki-laki') ? 'selected' : '' }}>Laki-laki</option>
                        <option value="perempuan" {{ (old('jenis_kelamin', $child->jenis_kelamin) == 'perempuan') ? 'selected' : '' }}>Perempuan</option>
                    </select>
                    @error('jenis_kelamin')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label for="nik" class="form-label">NIK (Opsional)</label>
                    <input type="text" class="form-control @error('nik') is-invalid @enderror" 
                           id="nik" name="nik" value="{{ old('nik', $child->nik) }}">
                    <div class="form-text">Nomor Induk Kependudukan anak (jika ada)</div>
                    @error('nik')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="d-flex justify-content-end">
                    <a href="{{ route('dashboard.orangtua.profiles.index') }}" class="btn btn-secondary me-2">Batal</a>
                    <button dusk='button-simpan' type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection