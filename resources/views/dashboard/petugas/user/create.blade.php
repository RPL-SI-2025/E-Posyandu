@extends('dashboard.petugas.layout.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Tambah Akun Orang Tua</h5>
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
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-person-plus-fill"></i> Buat Akun
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
