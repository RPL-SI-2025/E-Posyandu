@extends('dashboard.admin.layout.app')

@section('title', 'Dashboard Admin')

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
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Anda memiliki 10 akun yang harus diverifikasi, cek kelola datamu!</div>
                            <a href="#" class="btn btn-primary btn-sm mt-2">Cek Data</a> {{-- Placeholder link --}}
                        </div>
                        <div class="col-auto">
                            {{-- Placeholder for image --}}
                            <img src="{{ asset('assets/illustration.png') }}" alt="Illustration" style="height: 100px;">
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
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Disetujui</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">20.456</div> {{-- Placeholder count --}}
                            <div class="text-muted small">+10</div> {{-- Placeholder change --}}
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check fa-2x text-gray-300"></i>
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
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Ditolak</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">0</div> {{-- Placeholder count --}}
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-times fa-2x text-gray-300"></i>
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
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Menunggu</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">10</div> {{-- Placeholder count --}}
                            <div class="text-muted small">+10</div> {{-- Placeholder change --}}
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clock fa-2x text-gray-300"></i>
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
                                <th>Tinggi/Berat</th>
                                <th>Lingkar Kepala/Lengan</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- Placeholder rows --}}
                            <tr>
                                <td>Aziza Alina</td>
                                <td>23/02/2025</td>
                                <td>46cm/3kg</td>
                                <td>35cm/12cm</td>
                            </tr>
                            <tr>
                                <td>Jasmin Laila</td>
                                <td>15/02/2025</td>
                                <td>53cm/4kg</td>
                                <td>34cm/13cm</td>
                            </tr>
                             <tr>
                                <td>Aziza Alina</td>
                                <td>23/02/2025</td>
                                <td>46cm/3kg</td>
                                <td>35cm/12cm</td>
                            </tr>
                            <tr>
                                <td>Jasmin Laila</td>
                                <td>15/02/2025</td>
                                <td>53cm/4kg</td>
                                <td>34cm/13cm</td>
                            </tr>
                             <tr>
                                <td>Aziza Alina</td>
                                <td>23/02/2025</td>
                                <td>46cm/3kg</td>
                                <td>35cm/12cm</td>
                            </tr>
                            <tr>
                                <td>Jasmin Laila</td>
                                <td>15/02/2025</td>
                                <td>53cm/4kg</td>
                                <td>34cm/13cm</td>
                            </tr>
                             <tr>
                                <td>Aziza Alina</td>
                                <td>23/02/2025</td>
                                <td>46cm/3kg</td>
                                <td>35cm/12cm</td>
                            </tr>
                            <tr>
                                <td>Jasmin Laila</td>
                                <td>15/02/2025</td>
                                <td>53cm/4kg</td>
                                <td>34cm/13cm</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Calendar and Upcoming Events --}}
        <div class="col-xl-4">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-calendar-alt me-1"></i>
                    January
                </div>
                <div class="card-body">
                    <div id="calendar"></div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-list me-1"></i>
                    Acara Mendatang
                </div>
                <div class="card-body">
                    <p class="text-center text-muted">Tidak ada acara mendatang</p> {{-- Placeholder --}}
                    <div class="text-center">
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
