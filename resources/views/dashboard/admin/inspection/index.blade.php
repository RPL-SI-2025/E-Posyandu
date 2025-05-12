@extends('dashboard.admin.layout.app')

@section('title', 'Data Pemeriksaan')

@section('content')
<main>
    <div class="container-fluid px-4 mt-4">
        <h3 class="mb-4">Data Pemeriksaan Anak</h3>

        {{-- Tombol Tambah Data --}}
        <div class="mb-3 text-end">
            <a href="{{ route('dashboard.admin.inspection.create') }}" class="btn btn-success">+ Tambah Pemeriksaan</a>
        </div>

        {{-- Flash message --}}
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        {{-- Tabel Data Pemeriksaan --}}
        <div class="card">
            <div class="card-body">
                <table class="table table-bordered table-striped mb-0">
                    <thead class="table-light text-center">
                        <tr>
                            <th>No</th>
                            <th>Nama Anak</th>
                            <th>Nama Orangtua</th>
                            <th>Tanggal Pemeriksaan</th>
                            <th>Berat Badan (kg)</th>
                            <th>Tinggi Badan (cm)</th>
                            <th>Lingkar Kepala (cm)</th>
                            <th>Catatan</th>
                            <th>Lokasi Penimbangan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($inspections as $index => $inspection)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $inspection->child->nama_anak ?? '-' }}</td>
                                <td>{{ $inspection->user->name ?? '-' }}</td>
                                <td>{{ \Carbon\Carbon::parse($inspection->tanggal_pemeriksaan)->format('d-m-Y') }}</td>
                                <td>{{ $inspection->berat_badan }}</td>
                                <td>{{ $inspection->tinggi_badan }}</td>
                                <td>{{ $inspection->lingkar_kepala ?? '-' }}</td>
                                <td>{{ $inspection->catatan ?? '-'}}</td>
                                <td>{{ $inspection->eventtime->lokasi ?? '-' }}</td>
                                
                                <td>
                                    <a href="{{ route('dashboard.admin.inspection.edit', $inspection->id) }}" class="btn btn-sm btn-warning">Edit</a>

                                    <form action="{{ route('dashboard.admin.inspection.destroy', $inspection->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center">Belum ada data pemeriksaan</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>
@endsection
