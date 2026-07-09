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
            <a href="{{ route('admin.booking.index') }}"
                class="nav-link {{ request()->routeIs('admin.booking.*') ? 'active' : '' }}">
                <i class="bi bi-calendar2-week"></i>
                Booking
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('admin.payments.index') }}"
                class="nav-link {{ request()->routeIs('admin.payment.*') ? 'active' : '' }}">
                <i class="bi bi-credit-card"></i>
                Payments
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('admin.users.index') }}"
                class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                <i class="bi bi-people"></i>
                Users
            </a>
        </li>

        <form action="{{ route('logout') }}" method="POST" onsubmit="return confirm('Yakin ingin logout?')">
            @csrf
            <button type="submit" class="nav-link border-0 bg-transparent w-100 text-start text-danger">
                <i class="fas fa-sign-out-alt me-2"></i>
                Logout
            </button>
        </form>

    </ul>

</aside>