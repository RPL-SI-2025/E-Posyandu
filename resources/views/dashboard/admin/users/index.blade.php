@extends('dashboard.admin.layout.app')

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
                        <input type="text" name="search" id="search" class="form-control" placeholder="Cari..." value="{{ $searchTerm ?? '' }}">
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
                            <th>Verifikasi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $user)
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
                                    @if($user->status_akun == 'approved')
                                        <span class="badge bg-success">Terverifikasi</span>
                                    @elseif($user->status_akun == 'rejected')
                                        <span class="badge bg-danger">Ditolak</span>
                                    @else
                                        <span class="badge bg-secondary">Menunggu</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="bi bi-three-dots-vertical"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <!-- Edit -->
                                            <li>
                                                <a href="{{ route('user.edit', $user->id) }}" class="dropdown-item">
                                                    <i class="bi bi-pencil-square me-2"></i>Edit
                                                </a>
                                            </li>

                                            @if(auth()->user()->role === 'admin')
                                                @if($user->status_akun !== 'approved')
                                                    <li>
                                                        <form action="{{ route('user.updateStatus', $user->id) }}" method="POST" onsubmit="return confirm('Setujui pengguna ini?')">
                                                            @csrf
                                                            @method('PUT')
                                                            <input type="hidden" name="status_akun" value="approved">
                                                            <button class="dropdown-item" type="submit">
                                                                <i class="bi bi-check-circle me-2"></i>Setujui
                                                            </button>
                                                        </form>
                                                    </li>
                                                @endif

                                                @if($user->status_akun !== 'rejected')
                                                    <li>
                                                        <form action="{{ route('user.updateStatus', $user->id) }}" method="POST" onsubmit="return confirm('Tolak pengguna ini?')">
                                                            @csrf
                                                            @method('PUT')
                                                            <input type="hidden" name="status_akun" value="rejected">
                                                            <button class="dropdown-item" type="submit">
                                                                <i class="bi bi-x-circle me-2"></i>Tolak
                                                            </button>
                                                        </form>
                                                    </li>
                                                @endif
                                            @endif

                                            <!-- Delete -->
                                            <li>
                                                <form action="{{ route('user.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus pengguna ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="dropdown-item text-danger">
                                                        <i class="bi bi-trash me-2"></i>Hapus
                                                    </button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    <div class="alert alert-info mb-0">
                                        Tidak ada data pengguna yang ditemukan
                                        @if(request()->has('search') || request()->has('role'))
                                            dengan filter yang dipilih.
                                            <a href="{{ route('user.index') }}" class="alert-link">Reset filter</a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Status Filter Section -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('user.index') }}" class="d-flex flex-wrap gap-2">
                <input type="text" name="search" value="{{ request()->search }}" class="form-control" placeholder="Search...">
                <select name="status_akun" class="form-select">
                    <option value="">Semua Status</option>
                    <option value="waiting" {{ request()->status_akun == 'waiting' ? 'selected' : '' }}>Waiting</option>
                    <option value="approved" {{ request()->status_akun == 'approved' ? 'selected' : '' }}>Approved</option>
                    <option value="rejected" {{ request()->status_akun == 'rejected' ? 'selected' : '' }}>Rejected</option>
                </select>
                <button type="submit" class="btn btn-primary">Filter</button>
            </form>
        </div>
    </div>
</div>
@endsection

