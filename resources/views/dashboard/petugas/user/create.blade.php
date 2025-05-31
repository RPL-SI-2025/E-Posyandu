@extends('dashboard.petugas.layout.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Tambah Pengguna Baru</h5>
                    <a href="{{ route('dashboard.petugas.user.index') }}" class="btn btn-sm btn-secondary">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                </div>
                <div class="card-body">
                    <form action="{{ route('dashboard.petugas.user.store') }}" method="POST">
                        @csrf
                        @include('dashboard.petugas.user.form')
                        <div class="text-end mt-4">
                            <button type="reset" class="btn btn-secondary">
                                <i class="bi bi-x-circle"></i> Reset
                            </button>
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-check-circle"></i> Simpan
                            <!-- Create User Form -->
<div class="mb-3">
    <label for="status_akun" class="form-label">Status Verifikasi</label>
    <select name="status_akun" id="status_akun" class="form-select">
        <option value="waiting" {{ old('status_akun', 'waiting') == 'waiting' ? 'selected' : '' }}>Waiting</option>
        <option value="approved" {{ old('status_akun', 'waiting') == 'approved' ? 'selected' : '' }}>Approved</option>
        <option value="rejected" {{ old('status_akun', 'waiting') == 'rejected' ? 'selected' : '' }}>Rejected</option>
    </select>
</div>

</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
