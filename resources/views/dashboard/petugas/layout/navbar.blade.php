<div id="layoutSidenav_nav">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-white">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3" href="#">
            <img src="{{ asset('assets/logo.png') }}" alt="Logo" style="height: 47px;">
        </a>


        <!-- Sidebar Toggle -->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-lg-0" id="sidebarToggle"><i class="fas fa-bars" style="color: #92949E; font-size: 1.3rem;"></i></button>


        <!-- Navbar-->
        <ul class="navbar-nav ms-auto me-3 me-lg-4">
        <li class="nav-item">
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-outline-danger" id="log0>
                    <i class="bi bi-box-arrow-right me-1"></i> Logout
                </button>
            </form>
        </li>

                </ul>
            </li>
        </ul>
    </nav>
</div>

<script>
    window.addEventListener('DOMContentLoaded', () => {
        const sidebarToggle = document.getElementById('sidebarToggle');
        if (sidebarToggle) {
            sidebarToggle.addEventListener('click', (event) => {
                event.preventDefault();
                document.body.classList.toggle('sb-sidenav-toggled');
            });
        }
    });
</script>