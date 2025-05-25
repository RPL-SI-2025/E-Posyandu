@extends('dashboard.admin.layout.app')

@section('content')
<div class="container">
        <div class="mb-4">
            <h1>Tambah Pengguna</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard.admin.index') }}">Dashboard</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard.admin.user.index') }}">Daftar Pengguna</a>
                </li>
                <li class="breadcrumb-item active">Pengguna</li>
            </ol>
        </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Tambah Pengguna Baru</h5>
                    <a href="{{ route('dashboard.admin.user.index') }}" class="btn btn-sm btn-secondary">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                </div>
                <div class="card-body">
                    <form action="{{ route('dashboard.admin.user.store') }}" method="POST">
                        @csrf

                        {{-- Tambahkan status_akun default hidden jika create --}}
                        @if(!isset($user))
                            <input type="hidden" name="status_akun" value="waiting">
                        @endif

                        @include('dashboard.admin.users.form')

                        <div class="text-end mt-4">
                            <button type="reset" class="btn btn-secondary">
                                <i class="bi bi-x-circle"></i> Reset
                            </button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
