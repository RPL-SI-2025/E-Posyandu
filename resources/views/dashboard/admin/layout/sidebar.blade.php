<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <nav class="sb-sidenav accordion sb-sidenav-light bg-white" id="sidenavAccordion">
            <div class="sb-sidenav-menu">
                <div class="nav">
                    <div class="sb-sidenav-menu-heading"></div>
                    <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                        <img src="{{ asset('assets/home.png') }}" alt="Logo" style="height: 25px; margin-right: 8px;">
                        Dashboard
                    </a>
                    <a class="nav-link {{ request()->routeIs('admin.users.index') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">
                        <img src="{{ asset('assets/home.png') }}" alt="Logo" style="height: 25px; margin-right: 8px;">
                        Users
                    </a>
                    <a class="nav-link {{ request()->routeIs('admin.balita.index') ? 'active' : '' }}" href="{{ route('admin.balita.index') }}">
                        <img src="{{ asset('assets/home.png') }}" alt="Logo" style="height: 25px; margin-right: 8px;">
                        Balitsa
                    </a>
                    <a class="nav-link {{ request()->routeIs('admin.artikel.index') ? 'active' : '' }}" href="{{ route('admin.artikel.index') }}">
                        <img src="{{ asset('assets/home.png') }}" alt="Logo" style="height: 25px; margin-right: 8px;">
                        Artikel
                    </a>
                    <a class="nav-link {{ request()->routeIs('admin.event.index') ? 'active' : '' }}" href="{{ route('admin.event.index') }}">
                        <img src="{{ asset('assets/home.png') }}" alt="Logo" style="height: 25px; margin-right: 8px;">
                        Jadwal Kegiatan
                    </a>
                    <a class="nav-link {{ request()->routeIs('admin.inspection.index') ? 'active' : '' }}" href="{{ route('admin.inspection.index') }}">
                        <img src="{{ asset('assets/home.png') }}" alt="Logo" style="height: 25px; margin-right: 8px;">
                        Kunjungan 
                    </a>
                </div>
            </div>
        </nav>
    </div>
</div>