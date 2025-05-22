@extends('dashboard.petugas.layout.app')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Detail Jadwal Kegiatan</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('dashboard.petugas.index') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('dashboard.petugas.event.index') }}">Jadwal Kegiatan</a></li>
        <li class="breadcrumb-item active">Detail</li>
    </ol>

    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title">Detail Waktu Kegiatan</h5>
                </div>
                <div class="card-body">
                    <!-- Tanggal -->
                    <div class="mb-3">
                        <label class="form-label">Tanggal</label>
                        <p class="form-control-plaintext">{{ \Carbon\Carbon::parse($event->tanggal)->format('d M Y') }}</p>
                    </div>

                    <!-- Jam Mulai -->
                    <div class="mb-3">
                        <label class="form-label">Jam Mulai</label>
                        <p class="form-control-plaintext">{{ $event->jam_mulai }}</p>
                    </div>

                    <!-- Jam Selesai -->
                    <div class="mb-3">
                        <label class="form-label">Jam Selesai</label>
                        <p class="form-control-plaintext">{{ $event->jam_selesai }}</p>
                    </div>

                    <!-- Lokasi -->
                    <div class="mb-3">
                        <label class="form-label">Lokasi</label>
                        <p class="form-control-plaintext">{{ $event->lokasi }}</p>
                    </div>

                    <!-- Keterangan -->
                    <div class="mb-3">
                        <label class="form-label">Keterangan</label>
                        <p class="form-control-plaintext">{{ $event->keterangan }}</p>
                    </div>

                    <!-- Tombol Kembali -->
                    <a href="{{ route('dashboard.petugas.event.index') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </div>
        </div>

        <!-- Kalender -->
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-body">
                    <div id="calendar"></div>
                    <p class="mt-3 text-muted">Acara: {{ $event->keterangan }}</p>
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
                    title: '{{ $event->keterangan }}',
                    start: '{{ $event->tanggal }}',
                    allDay: true
                }
            ]
        });
        calendar.render();
    });
</script>
@endsection
