<header class="navbar sticky-top p-3 border-bottom">
    <div class="container-fluid d-flex justify-content-between align-items-center">

        <!-- Tombol Sidebar untuk Mobile -->
        <div class="d-flex align-items-center">
            <button class="btn btn-outline-secondary d-lg-none me-2" id="sidebarToggle">
                <i class="bi bi-list"></i>
            </button>
        </div>

        <!-- User Dropdown di Kanan -->
        <div class="d-flex align-items-center">
            <div class="dropdown">
                <a class="nav-link nav-icon-hover d-flex align-items-center dropdown-toggle" href="#"
                        id="drop2" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="{{ asset('assets/icons/user-1.jpg') }}" alt="" width="35"
                            height="35" class="rounded-circle">
                        <span class="ms-2">Hi! {{ Auth::user()->name }}</span>
                    </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                    <li>
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="dropdown-item">
                                <i class="bi bi-box-arrow-right me-2"></i> Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>

    </div>
</header>
