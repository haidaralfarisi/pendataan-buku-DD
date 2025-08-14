<nav id="sidebarMenu" class="bg-light border-end d-flex flex-column position-sticky top-0" style="min-height: 100vh;">
    {{-- Header Sidebar --}}
    <div class="d-flex justify-content-between align-items-center px-3 pt-2 pb-2">
        <a href="{{ route('superadmin.dashboard') }}" class="d-flex align-items-center gap-2 text-decoration-none">
            <img src="{{ asset('assets/icons/ic-logo-dd.png') }}" alt="Logo" style="height: 60px;">
            <span class="fw-bold text-dark">Dian Didaktika</span>
        </a>
        <button id="sidebarClose" class="btn btn-outline-danger btn-sm d-lg-none">
            <i class="bi bi-x-lg"></i>
        </button>
    </div>

    {{-- Menu Scrollable --}}
    <div class="overflow-auto" style="max-height: calc(100vh - 160px);">
        <ul class="nav flex-column p-3">

            <li class="nav-small-cap">
                <i class="ti ti-dots nav-small-cap-icon fs-5"></i>
                <span class="hide-menu">Home</span>
            </li>

            <li class="nav-item mb-2">
                <a href="{{ route('superadmin.dashboard') }}"
                    class="nav-link d-flex align-items-center gap-2
                    {{ request()->routeIs('superadmin.dashboard') ? 'active' : 'text-dark' }}">
                    <img src="{{ asset('assets/icons/dashboard.png') }}" alt="Dashboard Icon" width="22"
                        height="22">
                    <span>Dashboard</span>
                </a>
            </li>

            <li class="nav-item mb-2">
                <a href="{{ route('superadmin.yearBooks.index') }}"
                    class="nav-link d-flex align-items-center gap-2
               {{ request()->routeIs('superadmin.yearBooks.index') ? 'active' : 'text-dark' }}">
                    <img src="{{ asset('assets/icons/calendar.png') }}" alt="Dashboard Icon" width="22"
                        height="22">
                    <span>Year Book</span>
                </a>
            </li>

            <li class="nav-item mb-2">
                <a href="{{ route('superadmin.classRooms.index') }}"
                    class="nav-link d-flex align-items-center gap-2
               {{ request()->routeIs('superadmin.classRooms.index') ? 'active' : 'text-dark' }}">
                    <img src="{{ asset('assets/icons/class.png') }}" alt="Dashboard Icon" width="22"
                        height="22">
                    <span>Class</span>
                </a>
            </li>

            <li class="nav-item mb-2">
                <a href="{{ route('superadmin.users.index') }}"
                    class="nav-link d-flex align-items-center gap-2
               {{ request()->routeIs('superadmin.users.index') ? 'active' : 'text-dark' }}">
                    <img src="{{ asset('assets/icons/user.png') }}" alt="Dashboard Icon" width="22" height="22">
                    <span>Management User</span>
                </a>
            </li>

            <li class="nav-item mb-2">
                <a href="{{ route('superadmin.books.index') }}"
                    class="nav-link d-flex align-items-center gap-2
               {{ request()->routeIs('superadmin.books.index') ? 'active' : 'text-dark' }}">
                    <img src="{{ asset('assets/icons/book.png') }}" alt="Dashboard Icon" width="22" height="22">
                    <span>Books</span>
                </a>
            </li>

            {{-- <li class="nav-item mb-2">
                <a href="#" class="nav-link text-dark d-flex align-items-center gap-3">
                    <i class="bi bi-gear fs-4"></i> Pengaturan
                </a>
            </li> --}}
        </ul>
    </div>

    {{-- Logout (tidak nempel bawah) --}}
    <div class="p-3 border-top">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button class="btn btn-outline-danger w-100">
                <i class="bi bi-box-arrow-right"></i> Logout
            </button>
        </form>
    </div>
</nav>
