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
            <a href="{{ route('dashboard.admin.artikel.create') }}" class="btn btn-primary">
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
                                <a href="{{ route('dashboard.admin.artikel.show', $artikel->id_artikel) }}" class="btn btn-info btn-sm">Lihat</a>
                                <a href="{{ route('dashboard.admin.artikel.edit', $artikel->id_artikel) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('dashboard.admin.artikel.destroy', $artikel->id_artikel) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Yakin ingin menghapus artikel ini?')">
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

<!-- Modal Tambah Artikel -->
<div class="modal fade" id="addArticleModal" tabindex="-1" aria-labelledby="addArticleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addArticleModalLabel">Tambah Artikel Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label for="title" class="form-label">Judul Artikel</label>
                        <input type="text" class="form-control" id="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="content" class="form-label">Konten</label>
                        <textarea class="form-control" id="content" rows="5" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="image" class="form-label">Gambar</label>
                        <input type="file" class="form-control" id="image" accept="image/*">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</div>
@endsection
