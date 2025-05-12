@extends('dashboard.admin.users.app')
@include('dashboard.admin.layout.sidebar')
@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Daftar Pengguna</h1>
        <a href="{{ route('user.create') }}" class="btn btn-primary">Tambah Akun</a>
    </div>

    <!-- Filter and Search Section -->
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('user.index') }}" method="GET" class="row g-3">
                <div class="col-md-4">
                    <label for="role" class="form-label">Filter berdasarkan Role:</label>
                    <select name="role" id="role" class="form-select" onchange="this.form.submit()">
                        <option value="">Semua Role</option>
                        @foreach(['admin', 'petugas', 'orangtua'] as $role)
                            <option value="{{ $role }}" {{ isset($selectedRole) && $selectedRole == $role ? 'selected' : '' }}>
                                {{ ucfirst($role) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-8">
                    <label for="search" class="form-label">Cari berdasarkan Nama, Email, atau Telepon:</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="search" name="search" 
                               placeholder="Cari..." value="{{ $searchTerm ?? '' }}">
                        <button class="btn btn-outline-secondary" type="submit">
                            <i class="bi bi-search"></i> Cari
                        </button>
                        @if(request()->has('search') || request()->has('role'))
                            <a href="{{ route('user.index') }}" class="btn btn-outline-danger">
                                <i class="bi bi-x-circle"></i> Reset
                            </a>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Results Count -->
    <div class="mb-3">
        <p>Menampilkan {{ $users->count() }} pengguna</p>
    </div>

    <!-- Users Table -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Telepon</th>
                            <th>Alamat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($users->count() > 0)
                            @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    <span class="badge bg-{{ $user->role == 'admin' ? 'danger' : ($user->role == 'petugas' ? 'primary' : 'success') }}">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </td>
                                <td>{{ $user->phone }}</td>
                                <td>{{ Str::limit($user->address, 30) }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('user.edit', $user->id) }}" class="btn btn-sm btn-warning">
                                            <i class="bi bi-pencil"></i> Edit
                                        </a>
                                        <form action="{{ route('user.destroy', $user->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus pengguna {{ $user->name }}?')">
                                                <i class="bi bi-trash"></i> Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    <div class="alert alert-info mb-0">
                                        Tidak ada data pengguna yang ditemukan
                                        @if(request()->has('search') || request()->has('role'))
                                            dengan filter yang dipilih.
                                            <a href="{{ route('user.index') }}" class="alert-link">Reset filter</a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection