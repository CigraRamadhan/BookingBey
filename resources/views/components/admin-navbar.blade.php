<nav class="navbar navbar-expand-lg admin-navbar">

    <div class="container-fluid">

        {{-- Left --}}
        <div class="d-flex align-items-center">

            {{-- Toggle Sidebar --}}
            <button class="btn btn-light border me-3" id="sidebarToggle">
                <i class="bi bi-list fs-5"></i>
            </button>

            {{-- Search --}}
            <form method="GET" action="{{ url()->current() }}" class="d-none d-md-flex">

                <div class="input-group">

                    <span class="input-group-text bg-white border-end-0">
                        <i class="bi bi-search"></i>
                    </span>

                    <input type="text" name="search" class="form-control border-start-0" placeholder="Cari data..."
                        value="{{ request('search') }}">

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
            <div class="admin-notif-wrapper">

                <button class="btn btn-light border rounded-circle" type="button" id="adminNotifBell">
                    <i class="bi bi-bell"></i>
                    <span id="adminNotifBadge" class="admin-notif-badge d-none">0</span>
                </button>

                <div class="admin-notif-panel" id="adminNotifPanel">

                    <div class="admin-notif-header">
                        <span>Notifikasi</span>
                        <button type="button" id="adminNotifReadAll">Tandai semua dibaca</button>
                    </div>

                    <div class="admin-notif-body" id="adminNotifList">
                        <div class="admin-notif-empty">Memuat...</div>
                    </div>

                </div>

            </div>

            {{-- Profile --}}
            <div class="dropdown">

                <button class="btn d-flex align-items-center border rounded-pill px-2" data-bs-toggle="dropdown">

                    @if(Auth::user()->avatar)
                        <img src="{{ asset('storage/' . Auth::user()->avatar) }}"
                            class="rounded-circle me-2" width="40" height="40" style="object-fit:cover;">
                    @else
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->nama_lengkap) }}&background=2563EB&color=fff"
                            class="rounded-circle me-2" width="40" height="40">
                    @endif

                    <div class="text-start d-none d-md-block">

                        <strong>
                            {{ Auth::user()->nama_lengkap }}
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

                        <a class="dropdown-item" href="{{ route('admin.profile') }}">

                            <i class="bi bi-person me-2"></i>

                            Profile

                        </a>

                    </li>

                    <li>

                        <a class="dropdown-item" href="{{ route('admin.profile') }}#security">

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



<script>
document.addEventListener('DOMContentLoaded', function () {
    const bell = document.getElementById('adminNotifBell');
    const badge = document.getElementById('adminNotifBadge');
    const panel = document.getElementById('adminNotifPanel');
    const list = document.getElementById('adminNotifList');
    const readAllBtn = document.getElementById('adminNotifReadAll');

    function timeAgo(dateStr) {
        const diff = Math.floor((Date.now() - new Date(dateStr)) / 1000);
        if (diff < 60) return 'Baru saja';
        if (diff < 3600) return Math.floor(diff / 60) + ' menit lalu';
        if (diff < 86400) return Math.floor(diff / 3600) + ' jam lalu';
        return Math.floor(diff / 86400) + ' hari lalu';
    }

    function iconFor(judul) {
        if (judul.toLowerCase().includes('batal')) return 'bi-x-circle';
        if (judul.toLowerCase().includes('pembayaran')) return 'bi-cash-coin';
        return 'bi-calendar-check';
    }

    function loadNotifications() {
        fetch("{{ route('admin.notifications.index') }}", {
            headers: { 'Accept': 'application/json' }
        })
        .then(res => res.json())
        .then(data => {
            if (data.unread_count > 0) {
                badge.textContent = data.unread_count > 9 ? '9+' : data.unread_count;
                badge.classList.remove('d-none');
            } else {
                badge.classList.add('d-none');
            }

            if (!data.notifications.length) {
                list.innerHTML = '<div class="admin-notif-empty">Belum ada notifikasi</div>';
                return;
            }

            list.innerHTML = data.notifications.map(n => `
                <a href="/admin/notifications/${n.id}/read" class="admin-notif-item ${n.read_at ? '' : 'unread'}">
                    <div class="admin-notif-icon"><i class="bi ${iconFor(n.judul)}"></i></div>
                    <div class="admin-notif-content">
                        <div class="admin-notif-title">
                            ${!n.read_at ? '<span class="admin-notif-dot"></span>' : ''}
                            ${n.judul}
                        </div>
                        <div class="admin-notif-message">${n.pesan}</div>
                        <div class="admin-notif-time">${timeAgo(n.created_at)}</div>
                    </div>
                </a>
            `).join('');
        })
        .catch(() => {
            list.innerHTML = '<div class="admin-notif-empty">Gagal memuat notifikasi</div>';
        });
    }

    bell.addEventListener('click', function (e) {
        e.stopPropagation();
        const isOpen = panel.classList.toggle('show');
        if (isOpen) loadNotifications();
    });

    document.addEventListener('click', function (e) {
        if (!panel.contains(e.target) && !bell.contains(e.target)) {
            panel.classList.remove('show');
        }
    });

    loadNotifications();
    setInterval(loadNotifications, 30000);

    readAllBtn.addEventListener('click', function (e) {
        e.preventDefault();
        e.stopPropagation();
        fetch("{{ route('admin.notifications.readAll') }}", {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            }
        }).then(() => loadNotifications());
    });
});
</script>