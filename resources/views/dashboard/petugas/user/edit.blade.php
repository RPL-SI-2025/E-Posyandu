@extends('dashboard.petugas.layout.app')


@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Edit Pengguna: {{ $user->name }}</h5>
                    <a href="{{ route('user.index') }}" class="btn btn-sm btn-secondary">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                </div>
                <div class="card-body">
                    <form action="{{ route('user.update', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        @include('dashboard.petugas.user.form', ['user' => $user])

                        <!-- Status Verifikasi -->
                        <div class="mb-3">
                            <label for="status_akun" class="form-label">Status Verifikasi</label>
                            <select name="status_akun" id="status_akun" class="form-select">
                                <option value="waiting" {{ old('status_akun', $user->verifikasi) == 'waiting' ? 'selected' : '' }}>Waiting</option>
                                <option value="approved" {{ old('status_akun', $user->verifikasi) == 'approved' ? 'selected' : '' }}>Approved</option>
                                <option value="rejected" {{ old('status_akun', $user->verifikasi) == 'rejected' ? 'selected' : '' }}>Rejected</option>
                            </select>
                        </div>

                        <div class="text-end mt-4">
                            <a href="{{ route('user.index') }}" class="btn btn-secondary">
                                <i class="bi bi-x-circle"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-check-circle"></i> Update
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
