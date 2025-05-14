@extends('dashboard.admin.layout.app')


@section('content')
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
                    <p class="form-control-plaintext">{{ \Carbon\Carbon::parse($eventtime->tanggal)->format('d M Y') }}</p>
                </div>

                <!-- Jam Mulai -->
                <div class="mb-3">
                    <label class="form-label">Jam Mulai</label>
                    <p class="form-control-plaintext">{{ $eventtime->jam_mulai }}</p>
                </div>

                <!-- Jam Selesai -->
                <div class="mb-3">
                    <label class="form-label">Jam Selesai</label>
                    <p class="form-control-plaintext">{{ $eventtime->jam_selesai }}</p>
                </div>

                <!-- Lokasi -->
                <div class="mb-3">
                    <label class="form-label">Lokasi</label>
                    <p class="form-control-plaintext">{{ $eventtime->lokasi }}</p>
                </div>

                <!-- Keterangan -->
                <div class="mb-3">
                    <label class="form-label">Keterangan</label>
                    <p class="form-control-plaintext">{{ $eventtime->keterangan }}</p>
                </div>

                <!-- Tombol Kembali -->
                <a href="{{ route('dashboard.admin.event.index') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </div>
    </div>

    <!-- Kalender -->
    <div class="col-md-4">
        <div class="card mb-4">
            <div class="card-body">
                <div id="calendar"></div>
                <p class="mt-3 text-muted">Acara: {{ $eventtime->keterangan }}</p>
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
                    title: '{{ $eventtime->keterangan }}',
                    start: '{{ $eventtime->tanggal }}',
                    allDay: true
                }
            ]
        });
        calendar.render();
    });
</script>
@endsection
