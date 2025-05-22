@extends('dashboard.petugas.layout.app')

@section('title', 'Data Pemeriksaan')

@section('content')
<main>
    <div class="container-fluid px-4 mt-4">
        <h3 class="mb-4">Pemeriksaan Anak</h3>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard.petugas.index') }}">Dashboard</a>
            </li>
            <li class="breadcrumb-item active">Pemeriksaan</li>
        </ol>

        <div class="container-fluid px-4 mt-4">

        {{-- Card Daftar Pemeriksaan --}}
        <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
            <h7 class="mb-0"><i class="fas fa-table"></i> Daftar Pemeriksaan</h7>

            {{-- Filter, Search, Tambah --}}
            <div class="d-flex align-items-center gap-3 flex-wrap">
                
                {{-- Search bar --}}
                <form method="GET" action="{{ route('dashboard.petugas.inspection.index') }}" class="d-flex align-items-center" style="border: 1px solid #ccc; border-radius: 6px; overflow: hidden;">
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

                {{-- Tombol Filter --}}
                <div class="dropdown">
                    <button style="border: none; background: none; padding: 0;" type="button" id="filterDropdown" data-bs-toggle="dropdown" aria-expanded="false" Dusk="filter-inspection">
                        <img src="{{ asset('assets/filter.png') }}" alt="Filter" width="30">
                    </button>
                    <div class="dropdown-menu p-4" style="min-width: 300px;" aria-labelledby="filterDropdown">
                        <form method="GET" action="{{ route('dashboard.petugas.inspection.index') }}">
                            {{-- Tanggal Pemeriksaan --}}
                            <div class="mb-3">
                                <label for="tanggal_pemeriksaan" class="form-label">Tanggal Pemeriksaan</label>
                                <input type="date" name="tanggal_pemeriksaan" id="tanggal_pemeriksaan" class="form-control" value="{{ request('tanggal_pemeriksaan') }}">
                            </div>

                            {{-- Lokasi Penimbangan --}}
                            <div class="mb-3">
                                <label for="lokasi" class="form-label">Lokasi Penimbangan</label>
                                <select name="lokasi" id="lokasi" class="form-select">
                                    <option value="">-- Semua Lokasi --</option>
                                    @foreach ($eventtimes as $et)
                                        <option value="{{ $et->lokasi }}" {{ request('lokasi') == $et->lokasi ? 'selected' : '' }}>
                                            {{ $et->lokasi }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 mb-2">Terapkan Filter</button>
                            <a href="{{ route('dashboard.petugas.inspection.index') }}" class="btn btn-secondary w-100" Dusk='filter-delete'>Hapus Filter</a>
                        </form>
                    </div>
                </div>

                {{-- Tombol Tambah --}}
                <a href="{{ route('dashboard.petugas.inspection.create') }}" dusk="create-inspection">
                    <img src="{{ asset('assets/more.png') }}" alt="Tambah" width="30"> 
                </a>

            </div>
        </div>


            {{-- Error Validation --}}

            <div class="card-body">

                {{-- Flash message --}}
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                {{-- Tabel --}}
                <table class="table table-bordered mb-0">
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
                                
                                <td class="text-center">
                                    <div class="d-flex justify-content-center align-items-center gap-2">
                                        <a href="{{ route('dashboard.petugas.inspection.edit', $inspection->id) }}" dusk="edit-inspection">
                                            <img src="{{ asset('assets/edit.png') }}" alt="Edit" width="25">
                                        </a>

                                        <form action="{{ route('dashboard.petugas.inspection.destroy', $inspection->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?')" dusk="delete-inspection">
                                            {{-- CSRF Token --}}
                                            @csrf
                                            @method('DELETE')
                                            <button style="border: none; background: none; padding: 0;" type="submit">
                                                <img src="{{ asset('assets/bin.png') }}" alt="Hapus" width="25">
                                            </button>
                                        </form>
                                    </div>
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center">Belum ada data pemeriksaan</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

            </div>
        </div>

        </div>
</main>
@endsection
