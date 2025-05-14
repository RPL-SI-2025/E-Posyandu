@extends('dashboard.orangtua.layout.app')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Edit Report Daily</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('dashboard.orangtua.index') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('dashboard.orangtua.reports.index') }}">Report Daily</a></li>
        <li class="breadcrumb-item active">Edit Report</li>
    </ol>
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-edit me-1"></i>
            Form Edit Report
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

            <form action="{{ route('dashboard.orangtua.reports.update', $report->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="mb-3">
                    <label for="child_id" class="form-label">Anak</label>
                    <select class="form-select @error('child_id') is-invalid @enderror" id="child_id" name="child_id" required>
                        <option value="">Pilih Anak</option>
                        @forelse($children as $child)
                            <option value="{{ $child->id }}" {{ old('child_id', $report->child_id) == $child->id ? 'selected' : '' }}>
                                {{ $child->nama_anak }}
                            </option>
                        @empty
                            <option disabled>Tidak ada data anak terkait dengan akun ini</option>
                        @endforelse
                    </select>
                    @error('child_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="tanggal" class="form-label">Tanggal</label>
                    <input type="date" class="form-control @error('tanggal') is-invalid @enderror" id="tanggal" name="tanggal" value="{{ old('tanggal', $report->tanggal) }}" required>
                    @error('tanggal')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="judul_report" class="form-label">Judul Report</label>
                    <input type="text" class="form-control @error('judul_report') is-invalid @enderror" id="judul_report" name="judul_report" value="{{ old('judul_report', $report->judul_report) }}" required>
                    @error('judul_report')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="isi_report" class="form-label">Isi Report</label>
                    <textarea class="form-control @error('isi_report') is-invalid @enderror" id="isi_report" name="isi_report" rows="5" required>{{ old('isi_report', $report->isi_report) }}</textarea>
                    @error('isi_report')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="image" class="form-label">Gambar (Opsional)</label>
                    @if($report->image)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $report->image) }}" alt="Current Image" class="img-thumbnail" style="max-height: 200px">
                            <p class="text-muted">Current image</p>
                        </div>
                    @endif
                    <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image">
                    <small class="text-muted">Format: JPG, JPEG, PNG (Maks. 2MB). Biarkan kosong jika tidak ingin mengubah gambar.</small>
                    @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-end">
                    <a href="{{ route('dashboard.orangtua.reports.index') }}" class="btn btn-secondary me-2">Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection