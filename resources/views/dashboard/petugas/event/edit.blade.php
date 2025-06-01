@extends('dashboard.petugas.layout.app')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Edit Jadwal Kegiatan</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('dashboard.petugas.index') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('dashboard.petugas.event.index') }}">Jadwal Kegiatan</a></li>
        <li class="breadcrumb-item active">Edit</li>
    </ol>

    <div class="row">
        <!-- Form Update Eventtime -->
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title">Update Jadwal Waktu Kegiatan</h5>
                </div>
                <div class="card-body">

                    <form action="{{ route('dashboard.petugas.event.update', $event) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Tanggal -->
                        <div class="mb-3">
                            <label for="tanggal" class="form-label">Tanggal</label>
                            <input type="date" class="form-control" id="tanggal" name="tanggal" value="{{ old('tanggal', $event->tanggal) }}" required>
                            @error('tanggal')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Jam Mulai -->
                        <div class="mb-3">
                            <label for="jam_mulai" class="form-label">Jam Mulai</label>
                            <input type="time" class="form-control" id="jam_mulai" name="jam_mulai" value="{{ old('jam_mulai', $event->jam_mulai) }}" required>
                            @error('jam_mulai')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Jam Selesai -->
                        <div class="mb-3">
                            <label for="jam_selesai" class="form-label">Jam Selesai</label>
                            <input type="time" class="form-control" id="jam_selesai" name="jam_selesai" value="{{ old('jam_selesai', $event->jam_selesai) }}" required>
                            @error('jam_selesai')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Lokasi -->
                        <div class="mb-3">
                            <label for="lokasi" class="form-label">Lokasi</label>
                            <input type="text" class="form-control" id="lokasi" name="lokasi" value="{{ old('lokasi', $event->lokasi) }}" required>
                            @error('lokasi')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Keterangan -->
                        <div class="mb-3">
                            <label for="keterangan" class="form-label">Keterangan</label>
                            <textarea class="form-control" id="keterangan" name="keterangan" rows="3">{{ old('keterangan', $event->keterangan) }}</textarea>
                            @error('keterangan')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Tombol Simpan dan Hapus -->
                        <div class="d-flex justify-content-between">
                            <button dusk='@buttom_simpan'type="submit" class="btn btn-primary">Simpan</button>
                            <a href="#" onclick="event.preventDefault(); if(confirm('Apakah Anda yakin ingin menghapus data ini?')){ document.getElementById('form-delete').submit(); }" class="btn btn-danger">
                                Hapus
                            </a>
                        </div>
                    </form>

                    <!-- Form Hapus -->
                    <form button dusk='@buttom_delete'id="form-delete" action="{{ route('dashboard.petugas.event.destroy', $event) }}" method="POST" style="display: none;">
                        @csrf
                        @method('DELETE')
                    </form>

                </div>
            </div>
        </div>

        <!-- Kalender -->
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-body">
                    <div id="calendar"></div>
                    <p class="mt-3 text-muted">Kalender akan menampilkan jadwal jika sudah diintegrasikan.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            events: [
                {
                    title: '{{ $event->lokasi }}',
                    start: '{{ $event->tanggal }}T{{ $event->jam_mulai }}',
                    end: '{{ $event->tanggal }}T{{ $event->jam_selesai }}',
                    description: '{{ $event->keterangan ?? '' }}'
                }
            ]
        });
        calendar.render();
    });
</script>
@endsection
