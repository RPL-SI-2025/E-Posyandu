@extends('dashboard.petugas.layout.app')


@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Edit Pengguna: {{ $user->name }}</h5>
                    <a href="{{ route('dashboard.petugas.user.index') }}" class="btn btn-sm btn-secondary">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                </div>
                <div class="card-body">
                    <form action="{{ route('dashboard.petugas.user.update', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        @include('dashboard.petugas.user.form', ['user' => $user])

                        <div class="text-end mt-4">
                            <a href="{{ route('dashboard.petugas.user.index') }}" class="btn btn-secondary">
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
