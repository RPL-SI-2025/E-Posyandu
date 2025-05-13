<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <nav class="sb-sidenav accordion sb-sidenav-light bg-white" id="sidenavAccordion">
            <div class="sb-sidenav-menu">
                <div class="nav">
                    <div class="sb-sidenav-menu-heading"></div>

                    <a class="nav-link {{ request()->routeIs('dashboard.admin.index') ? 'active' : '' }}" href="{{ route('dashboard.admin.index') }}">
                        <img src="{{ asset('assets/home.png') }}" alt="Logo" style="height: 25px; margin-right: 8px;">
                        Dashboard
                    </a>

                    <a class="nav-link" href="{{ route('user.index') }}">
                        <img src="{{ asset('assets/user.png') }}" alt="Logo" style="height: 25px; margin-right: 8px;">
                        User
                    </a>

                    <a class="nav-link {{ request()->routeIs('dashboard.admin.balita.*') ? 'active' : '' }}" 
                       href="{{ route('dashboard.admin.balita.index') }}">
                        <img src="{{ asset('assets/Baby Feet.png') }}" alt="Logo" style="height: 25px; margin-right: 8px;">
                        Balita
                    </a>

                    <a class="nav-link {{ request()->routeIs('dashboard.admin.artikel.*') ? 'active' : '' }}" href="{{ route('dashboard.admin.artikel.index') }}">
                        <img src="{{ asset('assets/News.png') }}" alt="Logo" style="height: 25px; margin-right: 8px;">
                        Artikel
                    </a>


                    <a class="nav-link {{ request()->routeIs('dashboard.admin.event.*') ? 'active' : '' }}" href="{{ route('dashboard.admin.event.index') }}">
                        <img src="{{ asset('assets/Schedule.png') }}" alt="Logo" style="height: 25px; margin-right: 8px;">
                        Jadwal Kegiatan
                    </a>
                    <a class="nav-link {{ request()->routeIs('dashboard.admin.inspection.index') ? 'active' : '' }}" href="{{ route('dashboard.admin.inspection.index') }}">
                        <img src="{{ asset('assets/hospital.png') }}" alt="Logo" style="height: 25px; margin-right: 8px;">
                        Kunjungan 
                    </a>
                </div>
            </div>
        </nav>
    </div>
</div>
