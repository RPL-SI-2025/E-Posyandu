@extends('dashboard.admin.layout.app')

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
                        <div class="d-flex align-items-center gap-3">
                            {{-- Search bar --}}
                            <form method="GET" action="{{ route('dashboard.admin.balita.index') }}" class="d-flex align-items-center" style="border: 1px solid #ccc; border-radius: 6px; overflow: hidden;">
                                <div class="d-flex align-items-center">
                                    <input 
                                        type="text" 
                                        name="search" 
                                        value="{{ request('search') }}" 
                                        class="form-control border-0" 
                                        placeholder="Search with name" 
                                        style="width: 180px;"
                                    >
                                    <button type="submit" class="btn btn-primary px-3">Search</button>
                                </div>
                            </form>
                            
                            <a href="{{ route('dashboard.admin.balita.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i>Tambah Data Balita
                            </a>
                        </div>
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
                                    <th class="text-center">No</th>
                                    <th>Nama Anak</th>
                                    <th>Nama Orangtua</th>
                                    <th>NIK</th>
                                    <th>Tanggal Lahir</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Berat Terakhir (kg)</th>
                                    <th>Tinggi Terakhir (cm)</th>
                                    <th>Lingkar Kepala (cm)</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($balitas as $balita)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td>{{ $balita->nama_anak }}</td>
                                        <td>{{ $balita->user->name ?? '-' }}</td>
                                        <td>{{ $balita->nik }}</td>
                                        <td>{{ \Carbon\Carbon::parse($balita->tanggal_lahir)->format('d/m/Y') }}</td>
                                        <td>
                                            @if($balita->jenis_kelamin == 'perempuan')
                                                <span class="badge bg-info">Perempuan</span>
                                            @else
                                                <span class="badge bg-primary">Laki-laki</span>
                                            @endif
                                        </td>
                                        <td>{{ $balita->latestInspection->berat_badan ?? '-' }}</td>
                                        <td>{{ $balita->latestInspection->tinggi_badan ?? '-' }}</td>
                                        <td>{{ $balita->latestInspection->lingkar_kepala ?? '-' }}</td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center align-items-center gap-2">
                                                <a href="{{ route('dashboard.admin.balita.show', $balita->id) }}" 
                                                   class="btn btn-sm btn-info" 
                                                   data-bs-toggle="tooltip" 
                                                   title="Detail">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('dashboard.admin.balita.edit', $balita->id) }}" 
                                                   class="btn btn-sm btn-warning" 
                                                   data-bs-toggle="tooltip" 
                                                   title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('dashboard.admin.balita.destroy', $balita->id) }}" 
                                                      method="post" 
                                                      class="d-inline">
                                                    @method('delete')
                                                    @csrf
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
                                        <td colspan="10" class="text-center py-4 text-muted">
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
