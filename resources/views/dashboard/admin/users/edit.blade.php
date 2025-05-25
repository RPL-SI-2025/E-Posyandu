@extends('dashboard.admin.layout.app')
@include('dashboard.admin.layout.sidebar')

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
                        
                        {{-- Include form fields --}}
                        @include('dashboard.admin.users.form', ['user' => $user])

                        {{-- Status Verifikasi Field --}}
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="status_akun" class="form-label">Status Verifikasi <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-check-circle"></i></span>
                                        <select name="verifikasi" id="status_akun" dusk="status-akun" 
                                                class="form-select @error('status_akun') is-invalid @enderror" required>
                                            <option value="">Pilih Status</option>
                                            <option value="waiting" {{ old('status_akun', $user->verifikasi) == 'waiting' ? 'selected' : '' }}>
                                                Menunggu
                                            </option>
                                            <option value="approved" {{ old('status_akun', $user->verifikasi) == 'approved' ? 'selected' : '' }}>
                                                Disetujui
                                            </option>
                                            <option value="rejected" {{ old('status_akun', $user->verifikasi) == 'rejected' ? 'selected' : '' }}>
                                                Ditolak
                                            </option>
                                        </select>
                                        @error('status_akun')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-text">
                                        <small class="text-muted">Status verifikasi saat ini: 
                                            <span class="badge bg-{{ $user->verifikasi === 'approved' ? 'success' : ($user->verifikasi === 'rejected' ? 'danger' : 'secondary') }}">
                                                {{ $user->verifikasi === 'approved' ? 'Disetujui' : ($user->verifikasi === 'rejected' ? 'Ditolak' : 'Menunggu') }}
                                            </span>
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="text-end mt-4">
                            <a href="{{ route('user.index') }}" class="btn btn-secondary">
                                <i class="bi bi-x-circle"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-primary">
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