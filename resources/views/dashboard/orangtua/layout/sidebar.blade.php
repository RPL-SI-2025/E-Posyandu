<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <nav class="sb-sidenav accordion sb-sidenav-light bg-white" id="sidenavAccordion">
            <div class="sb-sidenav-menu">
                <div class="nav">
                    <div class="sb-sidenav-menu-heading"></div>
                    <a class="nav-link {{ request()->routeIs('dashboard.orangtua.index') ? 'active' : '' }}" href="{{ route('dashboard.orangtua.index') }}">
                        <img src="{{ asset('assets/home.png') }}" alt="Logo" style="height: 25px; margin-right: 8px;">
                        Dashboard
                    </a>
                    <a class="nav-link {{ request()->routeIs('dashboard.orangtua.profiles.*') ? 'active' : '' }}" href="{{ route('dashboard.orangtua.profiles.index') }}">
                        <img src="{{ asset('assets/home.png') }}" alt="Logo" style="height: 25px; margin-right: 8px;">
                        Profil Balita
                    </a>
                    <a class="nav-link {{ request()->routeIs('dashboard.orangtua.reports.*') ? 'active' : '' }}" href="{{ route('dashboard.orangtua.reports.index') }}">
                        <img src="{{ asset('assets/home.png') }}" alt="Logo" style="height: 25px; margin-right: 8px;">
                        Report Daily
                    </a>
                    <a class="nav-link {{ request()->routeIs('dashboard.orangtua.berita.index') ? 'active' : '' }}" href="{{ route('dashboard.orangtua.berita.index') }}">
                        <img src="{{ asset('assets/home.png') }}" alt="Logo" style="height: 25px; margin-right: 8px;">
                        Artikel
                    </a>
                </div>
            </div>
        </nav>
    </div>
</div>
