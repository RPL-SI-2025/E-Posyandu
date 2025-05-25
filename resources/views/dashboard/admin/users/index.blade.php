@extends('dashboard.admin.layout.app')

@section('content')
<div class="container">
    <div class="mb-4">
            <h1>Daftar Pengguna</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard.admin.index') }}">Dashboard</a>
                </li>
                <li class="breadcrumb-item active">Pengguna</li>
            </ol>
        </div>

        <div class="mb-4">
            <a href="{{ route('dashboard.admin.user.create') }}" class="btn btn-primary">Tambah Akun</a>

        </div>

    <!-- Filter dan Pencarian -->
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('dashboard.admin.user.index') }}" method="GET" class="d-flex gap-3">
                <div class="d-flex gap-2">
                    <div class="col-md-4">
                        <label for="role" class="form-label">Role:</label>
                        <select name="role" id="role" class="form-select" onchange="this.form.submit()">
                            <option value="">Semua Role</option>
                            @foreach(['admin', 'petugas', 'orangtua'] as $role)
                                <option value="{{ $role }}" {{ isset($selectedRole) && $selectedRole == $role ? 'selected' : '' }}>
                                    {{ ucfirst($role) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="verifikasi" class="form-label">Verifikasi:</label>
                        <select name="verifikasi" id="verifikasi" class="form-select" onchange="this.form.submit()">
                            <option value="">Semua Status</option>
                            <option value="waiting" {{ isset($selectedVerifikasi) && $selectedVerifikasi == 'waiting' ? 'selected' : '' }}>Menunggu</option>
                            <option value="approved" {{ isset($selectedVerifikasi) && $selectedVerifikasi == 'approved' ? 'selected' : '' }}>Disetujui</option>
                            <option value="rejected" {{ isset($selectedVerifikasi) && $selectedVerifikasi == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                        </select>
                    </div>
            <form action="{{ route('user.index') }}" method="GET" class="row g-3">
                <div class="col-md-3">
                    <label for="role" class="form-label">Role:</label>
                    <select name="role" id="role" class="form-select" onchange="this.form.submit()">
                        <option value="">Semua Role</option>
                        @foreach(['admin', 'petugas', 'orangtua'] as $role)
                            <option value="{{ $role }}" {{ request('role') === $role ? 'selected' : '' }}>
                                {{ ucfirst($role) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <label for="verifikasi" class="form-label">Verifikasi:</label>
                    <select name="verifikasi" id="verifikasi" class="form-select" onchange="this.form.submit()">
                        <option value="">Semua Status</option>
                        <option value="waiting" {{ request('verifikasi') === 'waiting' ? 'selected' : '' }}>Menunggu</option>
                        <option value="approved" {{ request('verifikasi') === 'approved' ? 'selected' : '' }}>Disetujui</option>
                        <option value="rejected" {{ request('verifikasi') === 'rejected' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                </div>

                <div class="col-md-4">
                    <label for="search" class="form-label">Cari:</label>
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Cari..." value="{{ $searchTerm ?? '' }}">
                        <button class="btn btn-outline-secondary" type="submit">
                            <i class="bi bi-search"></i> Cari
                        </button>
                        @if(request()->has('search') || request()->has('role') || request()->has('verifikasi'))
                            <a href="{{ route('dashboard.admin.user.index') }}" class="btn btn-outline-danger">
                                <i class="bi bi-x-circle"></i> Reset
                            </a>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Daftar Pengguna -->
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
                                    @if($user->verifikasi == 'approved')
                                        <span class="badge bg-success">Disetujui</span>
                                    @elseif($user->verifikasi == 'rejected')
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
                                                <a href="{{ route('dashboard.admin.user.edit', $user->id) }}" class="dropdown-item">
                                                    <i class="bi bi-pencil-square me-2"></i>Edit
                                                </a>
                                            </li>

                                            <!-- Verifikasi -->
                                            @if(auth()->user()->role === 'admin')
                                                @if($user->verifikasi !== 'approved')
                                                    <li>
                                                        <form action="{{ route('user.updateStatus', $user->id) }}" method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <input type="hidden" name="status_akun" value="approved">
                                                            <button class="dropdown-item" type="submit">
                                                                <i class="bi bi-check-circle me-2"></i>Setujui
                                                            </button>
                                                        </form>
                                                    </li>
                                                @endif

                                                @if($user->verifikasi !== 'rejected')
                                                    <li>
                                                        <form action="{{ route('user.updateStatus', $user->id) }}" method="POST">
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
                                                <form action="{{ route('dashboard.admin.user.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus pengguna ini?')">
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
                                        @if(request()->has('search') || request()->has('role') || request()->has('verifikasi'))
                                            dengan filter yang dipilih.
                                            <a href="{{ route('dashboard.admin.user.index') }}" class="alert-link">Reset filter</a>
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
</div>
@endsection
