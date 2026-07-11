<div class="sidebar">

    <div class="logo">

        <div class="logo-icon">

            <i class="fas fa-futbol"></i>

        </div>

        <h3>Sport Booking</h3>

        <small>User Panel</small>

    </div>

    <ul>

        <li>

            <a href="{{ route('user.dashboard') }}"
            class="{{ request()->routeIs('user.dashboard') ? 'active' : '' }}">

                <i class="fas fa-house"></i>

                Dashboard

            </a>

        </li>

        <li>

            <a href="{{ route('user.lapangan.index') }}">

                <i class="fas fa-table-tennis"></i>

                Lapangan

            </a>

        </li>

        <li>

            <a href="{{ route('user.booking.index') }}">

                <i class="fas fa-calendar-check"></i>

                Booking

            </a>

        </li>

        <li>

            <a href="{{ route('user.payment.index') }}">

                <i class="fas fa-credit-card"></i>

                Payment

            </a>

        </li>

        <li>

            <a href="{{ route('user.profile') }}">

                <i class="fas fa-user"></i>

                Profile

            </a>

        </li>

        <li>

            <form action="{{ route('logout') }}"
                method="POST">

                @csrf

                <button class="logout">

                    <i class="fas fa-right-from-bracket"></i>

                    Logout

                </button>

            </form>

        </li>

    </ul>

</div>