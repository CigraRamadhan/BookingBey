<div class="topbar">

    <div class="left">

        <button id="toggleSidebar" class="btn btn-light">
    <i class="fas fa-bars"></i>
</button>

        <div class="search-box">

            <i class="fas fa-search"></i>

            <input
                type="text"
                placeholder="Cari data...">

        </div>

    </div>

    <div class="right">

        <span>

            {{ now()->translatedFormat('l, d F Y') }}

        </span>

        <div class="notif-wrapper">

            <button class="notification" type="button" id="notifBell">
                <i class="far fa-bell"></i>
                <span id="notifBadge" class="notif-badge d-none">0</span>
            </button>

            <div class="notif-panel" id="notifPanel">

                <div class="notif-panel-header">
                    <span>Notifikasi</span>
                    <button type="button" id="notifReadAll">Tandai semua dibaca</button>
                </div>

                <div class="notif-panel-body" id="notifList">
                    <div class="notif-empty">Memuat...</div>
                </div>

            </div>

        </div>

        <div class="profile">

            <div class="avatar">

                @if(Auth::user()->avatar)
                    <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="Avatar" style="width:100%; height:100%; object-fit:cover; border-radius:50%;">
                @else
                    {{ strtoupper(substr(Auth::user()->nama_lengkap,0,1)) }}
                @endif

            </div>

            <div>

                <b>{{ Auth::user()->nama_lengkap }}</b>

                <br>

                <small>User</small>

            </div>

        </div>

    </div>

</div>

<style>
.notif-wrapper{
    position:relative;
}

.notif-badge{
    position:absolute;
    top:-4px;
    right:-4px;
    min-width:19px;
    height:19px;
    padding:0 5px;
    background:#ef4444;
    color:white;
    border-radius:999px;
    font-size:11px;
    font-weight:600;
    display:flex;
    align-items:center;
    justify-content:center;
    border:2px solid white;
}

.notif-panel{
    position:absolute;
    top:calc(100% + 14px);
    right:-10px;
    width:340px;
    max-width:88vw;
    background:white;
    border-radius:20px;
    box-shadow:0 15px 40px rgba(17,24,39,.14);
    opacity:0;
    visibility:hidden;
    transform:translateY(-8px);
    transition:.25s ease;
    z-index:1050;
    overflow:hidden;
}

.notif-panel.show{
    opacity:1;
    visibility:visible;
    transform:translateY(0);
}

.notif-panel-header{
    display:flex;
    align-items:center;
    justify-content:space-between;
    padding:16px 20px;
    border-bottom:1px solid #eef1f8;
}

.notif-panel-header span{
    font-weight:600;
    color:#111827;
    font-size:15px;
}

.notif-panel-header button{
    border:none;
    background:none;
    color:#2563eb;
    font-size:12.5px;
    font-weight:600;
    cursor:pointer;
    padding:0;
}

.notif-panel-header button:hover{
    text-decoration:underline;
}

.notif-panel-body{
    max-height:360px;
    overflow-y:auto;
    overflow-x:hidden;
}

.notif-panel-body::-webkit-scrollbar{
    width:6px;
}

.notif-panel-body::-webkit-scrollbar-thumb{
    background:#e5e9f4;
    border-radius:10px;
}

.notif-item{
    display:flex;
    gap:12px;
    padding:14px 20px;
    text-decoration:none;
    color:inherit;
    border-bottom:1px solid #f4f6fb;
    transition:.2s;
    white-space:normal;
    word-wrap:break-word;
}

.notif-item:last-child{
    border-bottom:none;
}

.notif-item:hover{
    background:#f4f6fb;
    color:inherit;
}

.notif-item.unread{
    background:#eef4ff;
}

.notif-item.unread:hover{
    background:#e3ecff;
}

.notif-icon{
    flex:0 0 auto;
    width:38px;
    height:38px;
    border-radius:50%;
    display:flex;
    align-items:center;
    justify-content:center;
    background:#2563eb;
    color:white;
    font-size:14px;
}

.notif-item.unread .notif-icon{
    background:#2563eb;
}

.notif-item:not(.unread) .notif-icon{
    background:#9ca3af;
}

.notif-content{
    flex:1;
    min-width:0;
}

.notif-title{
    font-weight:600;
    font-size:13.5px;
    color:#111827;
    display:flex;
    align-items:center;
    gap:6px;
}

.notif-dot{
    width:7px;
    height:7px;
    border-radius:50%;
    background:#2563eb;
    flex:0 0 auto;
}

.notif-message{
    font-size:12.5px;
    color:#6b7280;
    margin-top:2px;
    line-height:1.4;
}

.notif-time{
    font-size:11px;
    color:#9ca3af;
    margin-top:6px;
}

.notif-empty{
    text-align:center;
    color:#9ca3af;
    font-size:13px;
    padding:30px 20px;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const notifBell = document.getElementById('notifBell');
    const notifBadge = document.getElementById('notifBadge');
    const notifPanel = document.getElementById('notifPanel');
    const notifList = document.getElementById('notifList');
    const notifReadAll = document.getElementById('notifReadAll');

    function timeAgo(dateStr) {
        const diff = Math.floor((Date.now() - new Date(dateStr)) / 1000);
        if (diff < 60) return 'Baru saja';
        if (diff < 3600) return Math.floor(diff / 60) + ' menit lalu';
        if (diff < 86400) return Math.floor(diff / 3600) + ' jam lalu';
        return Math.floor(diff / 86400) + ' hari lalu';
    }

    function loadNotifications() {
        fetch("{{ route('user.notifications.index') }}", {
            headers: { 'Accept': 'application/json' }
        })
        .then(res => res.json())
        .then(data => {
            if (data.unread_count > 0) {
                notifBadge.textContent = data.unread_count > 9 ? '9+' : data.unread_count;
                notifBadge.classList.remove('d-none');
            } else {
                notifBadge.classList.add('d-none');
            }

            if (!data.notifications.length) {
                notifList.innerHTML = '<div class="notif-empty">Belum ada notifikasi</div>';
                return;
            }

            notifList.innerHTML = data.notifications.map(n => `
                <a href="/user/notifications/${n.id}/read" class="notif-item ${n.read_at ? '' : 'unread'}">
                    <div class="notif-icon"><i class="fas fa-calendar-check"></i></div>
                    <div class="notif-content">
                        <div class="notif-title">
                            ${!n.read_at ? '<span class="notif-dot"></span>' : ''}
                            ${n.judul}
                        </div>
                        <div class="notif-message">${n.pesan}</div>
                        <div class="notif-time">${timeAgo(n.created_at)}</div>
                    </div>
                </a>
            `).join('');
        })
        .catch(() => {
            notifList.innerHTML = '<div class="notif-empty">Gagal memuat notifikasi</div>';
        });
    }

    notifBell.addEventListener('click', function (e) {
        e.stopPropagation();
        const isOpen = notifPanel.classList.toggle('show');
        if (isOpen) loadNotifications();
    });

    document.addEventListener('click', function (e) {
        if (!notifPanel.contains(e.target) && !notifBell.contains(e.target)) {
            notifPanel.classList.remove('show');
        }
    });

    // Muat sekali di awal untuk badge, lalu polling tiap 30 detik
    loadNotifications();
    setInterval(loadNotifications, 30000);

    notifReadAll.addEventListener('click', function (e) {
        e.preventDefault();
        e.stopPropagation();
        fetch("{{ route('user.notifications.readAll') }}", {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            }
        }).then(() => loadNotifications());
    });
});
</script>
