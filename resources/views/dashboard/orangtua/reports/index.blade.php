@extends('dashboard.orangtua.layout.app')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Report Daily</h1>

    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <i class="fas fa-table me-1"></i>
                Daftar Report Daily
            </div>
            <div>
                <a href="{{ route('dashboard.orangtua.reports.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> Tambah Report
                </a>
            </div>
        </div>
        <!-- body table -->
        <div class="card-body">
            <!-- Filter Tanggal -->
            <div class="row mb-3">
                <div class="col-md-12">
                    <form action="{{ route('dashboard.orangtua.reports.index') }}" method="GET" class="d-flex flex-wrap">
                        <div class="input-group me-2 mb-2">
                            <span class="input-group-text">Dari</span>
                            <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
                            <span class="input-group-text">Sampai</span>
                            <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
                        </div>
                        
                        <div class="input-group me-2 mb-2">
                            <span class="input-group-text">Anak</span>
                            <select name="child_id" class="form-select">
                                <option value="">Semua Anak</option>
                                @foreach($children ?? [] as $child)
                                    <option value="{{ $child->id }}" {{ request('child_id') == $child->id ? 'selected' : '' }}>
                                        {{ $child->nama_anak ?? $child->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="mb-2">
                            <button type="submit" class="btn btn-primary">Filter</button>
                            <a href="{{ route('dashboard.orangtua.reports.index') }}" class="btn btn-secondary">Reset</a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Tabel Report -->
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="reportTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Judul</th>
                            <!-- <th>Nama Anak</th> -->
                            <th>Keterangan</th>
                            <th>Gambar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($reports))
                            @forelse($reports as $index => $report)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ \Carbon\Carbon::parse($report->tanggal)->format('d-m-Y') }}</td>
                                    <td>{{ $report->judul_report }}</td>
                                    <!-- <td>{{ $report->child->nama_anak ?? 'Tidak ada data' }}</td> -->
                                    <td>{{ $report->isi_report ?? 'Tidak ada data' }}</td>
                                    <td>
                                        @if($report->image)
                                            <img src="{{ asset('storage/' . $report->image) }}" alt="Report Image" style="height: 50px;">
                                        @else
                                            <span class="badge bg-secondary">Tidak ada gambar</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <!-- <a href="{{ route('dashboard.orangtua.reports.show', $report->id) }}" class="btn btn-info btn-sm">
                                                <i class="fas fa-eye"></i>
                                            </a> -->
                                            <a href="{{ route('dashboard.orangtua.reports.edit', $report->id) }}" class="btn btn-warning btn-sm">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <!-- <form action="{{ route('dashboard.orangtua.reports.destroy', $report->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus report ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form> -->
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">Tidak ada data report</td>
                                </tr>
                            @endforelse
                        @else
                            <tr>
                                <td colspan="6" class="text-center">Data tidak tersedia</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#reportTable').DataTable({
            responsive: true,
            order: [[1, 'desc']]
        });
    });
</script>
@endsection