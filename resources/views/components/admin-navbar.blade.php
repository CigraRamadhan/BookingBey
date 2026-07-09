<nav class="navbar navbar-expand-lg admin-navbar">

    <div class="container-fluid">

        {{-- Left --}}
        <div class="d-flex align-items-center">

            {{-- Toggle Sidebar --}}
            <button class="btn btn-light border me-3" id="sidebarToggle">
                <i class="bi bi-list fs-5"></i>
            </button>

            {{-- Search --}}
            <form class="d-none d-md-flex">

                <div class="input-group">

                    <span class="input-group-text bg-white border-end-0">
                        <i class="bi bi-search"></i>
                    </span>

                    <input type="text" class="form-control border-start-0" placeholder="Cari data...">

                </div>

            </form>

        </div>

        {{-- Right --}}
        <div class="d-flex align-items-center gap-3">

            {{-- Date --}}
            <div class="text-end d-none d-lg-block">

                <small class="text-muted">
                    {{ now()->format('l, d F Y') }}
                </small>

            </div>

            {{-- Notification --}}
            <div class="position-relative">

                <button class="btn btn-light border rounded-circle">

                    <i class="bi bi-bell"></i>

                </button>

                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">

                    3

                </span>

            </div>

            {{-- Profile --}}
            <div class="dropdown">

                <button class="btn d-flex align-items-center border rounded-pill px-2" data-bs-toggle="dropdown">

                    <img src="https://ui-avatars.com/api/?name=Admin&background=2563EB&color=fff"
                        class="rounded-circle me-2" width="40" height="40">

                    <div class="text-start d-none d-md-block">

                        <strong>
                            Admin
                        </strong>

                        <br>

                        <small class="text-muted">
                            Administrator
                        </small>

                    </div>

                    <i class="bi bi-chevron-down ms-3"></i>

                </button>

                <ul class="dropdown-menu dropdown-menu-end shadow">

                    <li>

                        <a class="dropdown-item" href="#">

                            <i class="bi bi-person me-2"></i>

                            Profile

                        </a>

                    </li>

                    <li>

                        <a class="dropdown-item" href="#">

                            <i class="bi bi-gear me-2"></i>

                            Settings

                        </a>

                    </li>

                    <li>

                        <hr class="dropdown-divider">

                    </li>


                </ul>

            </div>

        </div>

    </div>

</nav>