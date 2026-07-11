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

        <div class="notification">

            <i class="far fa-bell"></i>

        </div>

        <div class="profile">

            <div class="avatar">

                {{ strtoupper(substr(Auth::user()->nama_lengkap,0,1)) }}

            </div>

            <div>

                <b>{{ Auth::user()->nama_lengkap }}</b>

                <br>

                <small>User</small>

            </div>

        </div>

    </div>

</div>