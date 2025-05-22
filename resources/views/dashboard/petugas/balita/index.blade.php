@extends('dashboard.petugas.layout.app')

@section('content')
<div class="container-fluid px-4">
    <div class="row mt-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="card-title mb-0 text-dark">
                            <i class="fas fa-child me-2"></i>Data Balita
                        </h5>
                        <a href="{{ route('dashboard.petugas.balita.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>Tambah Data Balita
                        </a>
                    </div>

                    @if (session()->has('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th class="text-center" style="width: 50px;">No</th>
                                    <th>ID User</th>
                                    <th>Nama Anak</th>
                                    <th>NIK</th>
                                    <th>Tanggal Lahir</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Tgl Dibuat</th>
                                    <th>Terakhir Update</th>
                                    <th class="text-center" style="width: 150px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($balitas as $balita)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td>{{ $balita->user_id }}</td>
                                        <td>{{ $balita->nama_anak }}</td>
                                        <td>{{ $balita->nik }}</td>
                                        <td>{{ \Carbon\Carbon::parse($balita->tanggal_lahir)->format('d/m/Y') }}</td>
                                        <td>
                                            @if($balita->jenis_kelamin == 'perempuan')
                                                <span class="badge bg-info">Perempuan</span>
                                            @else
                                                <span class="badge bg-primary">Laki-laki</span>
                                            @endif
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($balita->created_at)->format('d/m/Y H:i') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($balita->updated_at)->format('d/m/Y H:i') }}</td>
                                        <td class="text-center">
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('dashboard.petugas.balita.show', $balita->id) }}" 
                                                   class="btn btn-sm btn-info" 
                                                   data-bs-toggle="tooltip" 
                                                   title="Detail">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('dashboard.petugas.balita.edit', $balita->id) }}" 
                                                   class="btn btn-sm btn-warning" 
                                                   data-bs-toggle="tooltip" 
                                                   title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('dashboard.petugas.balita.destroy', $balita->id) }}" 
                                                      method="post" 
                                                      class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="btn btn-sm btn-danger" 
                                                            onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')"
                                                            data-bs-toggle="tooltip" 
                                                            title="Hapus">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center py-4 text-muted">
                                            <i class="fas fa-inbox fa-3x mb-3 d-block"></i>
                                            Belum ada data balita
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Enable tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })

    // Auto close alerts
    window.setTimeout(function() {
        $(".alert").fadeTo(500, 0).slideUp(500, function(){
            $(this).remove(); 
        });
    }, 3000);
</script>
@endpush
@endsection
