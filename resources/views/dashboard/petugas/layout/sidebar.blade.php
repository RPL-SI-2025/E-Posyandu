<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <nav class="sb-sidenav accordion sb-sidenav-light bg-white" id="sidenavAccordion">
            <div class="sb-sidenav-menu">
                <div class="nav">
                    <div class="sb-sidenav-menu-heading"></div>
                    <a class="nav-link {{ request()->routeIs('dashboard.petugas.index') ? 'active' : '' }}" href="{{ route('dashboard.petugas.index') }}">
                        <img src="{{ asset('assets/home.png') }}" alt="Logo" style="height: 25px; margin-right: 8px;">
                        Dashboard
                    </a>
                    <a class="nav-link {{ request()->routeIs('dashboard.petugas.balita.index') ? 'active' : '' }}" href="{{ route('dashboard.petugas.balita.index') }}">
                        <img src="{{ asset('assets/Baby Feet.png') }}" alt="Logo" style="height: 25px; margin-right: 8px;">
                        Balita
                    </a>
                    <a class="nav-link {{ request()->routeIs('dashboard.petugas.user.index') ? 'active' : '' }}" href="{{ route('dashboard.petugas.user.index') }}">
                        <img src="{{ asset('assets/user.png') }}" alt="Logo" style="height: 25px; margin-right: 8px;">
                        Users
                    </a>
                    <a class="nav-link {{ request()->routeIs('dashboard.petugas.event.*') ? 'active' : '' }}" href="{{ route('dashboard.petugas.event.index') }}">
                        <img src="{{ asset('assets/Schedule.png') }}" alt="Logo" style="height: 25px; margin-right: 8px;">
                        Jadwal Kegiatan
                    </a>
                    <a class="nav-link {{ request()->routeIs('dashboard.petugas.inspection.index') ? 'active' : '' }}" href="{{ route('dashboard.petugas.inspection.index') }}">
                        <img src="{{ asset('assets/hospital.png') }}" alt="Logo" style="height: 25px; margin-right: 8px;">
                        Kunjungan
                    </a>
                </div>
            </div>
        </nav>
    </div>
</div>