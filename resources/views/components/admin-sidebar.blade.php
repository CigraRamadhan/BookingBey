<aside class="sidebar d-flex flex-column">

    {{-- Logo --}}
    <div class="sidebar-header text-center">

        <div class="logo-icon mb-2">
            <i class="bi bi-calendar-check"></i>
        </div>

        <h4 class="logo-title">
            Booking Lapangan
        </h4>

        <small class="text-secondary">
            Admin Panel
        </small>

    </div>

    <hr class="sidebar-divider">

    {{-- Menu --}}
    <ul class="nav flex-column sidebar-menu">

        <li class="nav-item">
            <a href="{{ route('admin.dashboard') }}"
                class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="bi bi-grid"></i>
                Dashboard
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('admin.lapangan.index') }}"
                class="nav-link {{ request()->routeIs('admin.lapangan.*') ? 'active' : '' }}">
                <i class="bi bi-dribbble"></i>
                Lapangan
            </a>
        </li>

        <li class="nav-item">
            <a href="#"
                class="nav-link {{ request()->routeIs('admin.booking.*') ? 'active' : '' }}">
                <i class="bi bi-calendar2-week"></i>
                Booking
            </a>
        </li>

        <li class="nav-item">
            <a href="#"
                class="nav-link {{ request()->routeIs('admin.payments.*') ? 'active' : '' }}">
                <i class="bi bi-credit-card"></i>
                Payments
            </a>
        </li>

        <li class="nav-item">
            <a href="#"
                class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                <i class="bi bi-people"></i>
                Users
            </a>
        </li>

    </ul>

</aside>