@extends('dashboard.admin.layout.app')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Artikel</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item">
            <a href="{{ route('dashboard.admin.index') }}">Dashboard</a>
        </li>
        <li class="breadcrumb-item active">Artikel</li>
    </ol>

    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <i class="fas fa-table me-1"></i>
                Daftar Artikel
            </div>
            <a href="{{ route('dashboard.admin.artikel.create') }}" class="btn btn-primary" dusk="create-article">
                <i class="fas fa-plus"></i> Tambah Artikel
            </a>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Judul</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($artikels as $index => $artikel)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $artikel->judul }}</td>
                            <td>{{ $artikel->created_at->format('d-m-Y') }}</td>
                            <td>
                                @if($artikel->is_show)
                                    <span class="badge bg-success">Tampil</span>
                                @else
                                    <span class="badge bg-secondary">Tidak Tampil</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('dashboard.admin.artikel.show', $artikel->id_artikel) }}" class="btn btn-info btn-sm" dusk="view-article-{{ $artikel->id_artikel }}">Lihat</a>
                                <a href="{{ route('dashboard.admin.artikel.edit', $artikel->id_artikel) }}" class="btn btn-warning btn-sm" dusk="edit-article-{{ $artikel->id_artikel }}">Edit</a>
                                <form action="{{ route('dashboard.admin.artikel.destroy', $artikel->id_artikel) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Yakin ingin menghapus artikel ini?')" dusk="delete-article-{{ $artikel->id_artikel }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">Belum ada artikel</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
