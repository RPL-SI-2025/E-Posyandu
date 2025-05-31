@extends('dashboard.petugas.layout.app')

@section('title', 'Dashboard Petugas')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Dashboard</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Dashboard</li>
    </ol>

    {{-- Welcome and Stats Cards --}}
    <div class="row">
        <div class="col-xl-6 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Welcome,</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Anda memiliki {{ $jumlahMenungguVerifikasi }} akun yang harus diverifikasi, cek kelola datamu!</div>
                            <a href="{{ route('dashboard.petugas.user.index') }}" class="btn btn-primary btn-sm mt-2">Cek Data</a> {{-- Placeholder link --}}
                        </div>
                        <div class="col-auto">
                            {{-- Placeholder for image --}}
                            <img src="{{ asset('assets/dashboard.png') }}" alt="Illustration" style="height: 100px;">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-2 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        {{-- Gambar kecil, rata kiri --}}
                        <img src="{{ asset('assets/setuju.png') }}" alt="Illustration" style="height: 45px;" class="mb-3">

                        {{-- Label Disetujui --}}
                        <div class="text-xs mb-2" style="font-weight: 400; color: #92949E;">Disetujui</div>

                        {{-- Jumlah --}}
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($jumlahDisetujui) }}</div>
                    </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-2 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            {{-- Gambar kecil, rata kiri --}}
                            <img src="{{ asset('assets/tolak.png') }}" alt="Illustration" style="height: 45px;" class="mb-3">

                            {{-- Label Disetujui --}}
                            <div class="text-xs mb-2" style="font-weight: 400; color: #92949E;">Ditolak</div>

                            {{-- Jumlah --}}
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($jumlahDitolak) }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-2 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                            {{-- Gambar kecil, rata kiri --}}
                            <img src="{{ asset('assets/menunggu.png') }}" alt="Illustration" style="height: 45px;" class="mb-3">

                            {{-- Label Disetujui --}}
                            <div class="text-xs mb-2" style="font-weight: 400; color: #92949E;">Menunggu</div>

                            {{-- Jumlah --}}
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($jumlahMenungguVerifikasi) }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        {{-- Perkembangan Bayi Table --}}
        <div class="col-xl-8">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    Perkembangan Bayi
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Nama Bayi</th>
                                <th>Tanggal Penimbangan</th>
                                <th>Tinggi Badan</th>
                                <th>Berat Badan</th>
                                <th>Lingkar Kepala</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- Placeholder rows --}}
                            <tr>
                            @foreach ($perkembanganBayi as $data)
                            <tr>
                                <td>{{ $data->child->nama_anak }}</td>
                                <td>{{ \Carbon\Carbon::parse($data->tanggal_penimbangan)->format('d-m-Y') }}</td>
                                <td>{{ $data->tinggi_badan }} cm</td>
                                <td> {{ $data->berat_badan }} kg</td>
                                <td>{{ $data->lingkar_kepala }} cm</td>
                            </tr>
                            @endforeach
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Calendar and Upcoming Events --}}
        <div class="col-xl-4">
    <div class="card mb-4">
        <div class="card-header bg-light fw-bold">
            <i class="fas fa-calendar-alt me-2"></i>
            Acara Mendatang
        </div>
        <div class="card-body">
        @if ($acaraMendatang->isEmpty())
            <p class="text-center text-muted">Tidak ada acara mendatang</p>
        @else
            @foreach ($acaraMendatang as $acara)
                <div class="border rounded p-3 mb-3 shadow-sm bg-white">
                    <div class="fw-semibold">{{ $acara->keterangan }}</div>
                    <div class="text-muted small mb-1">
                        {{ \Carbon\Carbon::parse($acara->tanggal)->translatedFormat('Y-m-d') }}
                        ({{ \Carbon\Carbon::parse($acara->jam_mulai)->format('H:i:s') }} - {{ \Carbon\Carbon::parse($acara->jam_selesai)->format('H:i:s') }})
                    </div>
                    @if ($acara->deskripsi)
                        <div class="fst-italic small text-secondary">{{ $acara->deskripsi }}</div>
                    @endif
                </div>
            @endforeach
        @endif
            <div class="text-center mt-3">
                <a href="{{ route('dashboard.petugas.event.create') }}" class="btn btn-primary">Tambah Jadwal</a>
            </div>
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
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: '' // Removed dayGridWeek, dayGridDay
            },
            // Add your events here
            events: [
                // { title: 'Event 1', date: '2025-01-10' },
                // { title: 'Event 2', date: '2025-01-15' }
            ]
        });
        calendar.render();
    });
</script>
@endsection
