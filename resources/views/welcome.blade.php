<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Lapangan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        .hero {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            min-height: 80vh;
            display: flex;
            align-items: center;
        }
        .hero h1 { font-size: 4rem; font-weight: 700; }
        .hero .btn { padding: 15px 40px; border-radius: 50px; font-weight: 600; }
        .feature-card {
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            transition: transform 0.3s;
            background: white;
        }
        .feature-card:hover { transform: translateY(-10px); }
        .feature-icon { font-size: 3rem; margin-bottom: 15px; }
        .stats-section { background: #f8f9fa; }
        .stat-number { font-size: 2.5rem; font-weight: 700; color: #667eea; }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <i class="fas fa-futbol"></i> Booking Lapangan
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    @guest
                        <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Register</a></li>
                    @else
                        <li class="nav-item"><a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('lapangan.index') }}">Lapangan</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('booking.index') }}">Riwayat</a></li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero -->
    <section class="hero">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1>Sewa Lapangan <br><span style="color: #ffd700;">Mudah & Cepat</span></h1>
                    <p class="lead mb-4">Temukan dan booking lapangan futsal, badminton, basket, dan olahraga lainnya</p>
                    @auth
                        <a href="{{ route('lapangan.index') }}" class="btn btn-light">
                            <i class="fas fa-search"></i> Cari Lapangan
                        </a>
                    @else
                        <a href="{{ route('register') }}" class="btn btn-light">
                            <i class="fas fa-user-plus"></i> Daftar Sekarang
                        </a>
                        <a href="{{ route('login') }}" class="btn btn-outline-light ms-2">
                            <i class="fas fa-sign-in-alt"></i> Login
                        </a>
                    @endauth
                </div>
                <div class="col-lg-6 text-center">
                    <img src="{{ asset('images/hero-illustration.svg') }}" alt="Hero" class="img-fluid" style="max-height: 350px;">
                </div>
            </div>
        </div>
    </section>

    <!-- Features -->
    <section class="py-5">
        <div class="container">
            <h2 class="text-center mb-5">Kenapa Memilih Kami?</h2>
            <div class="row g-4">
                <div class="col-md-3">
                    <div class="feature-card text-center">
                        <div class="feature-icon">🏸</div>
                        <h5>Beragam Lapangan</h5>
                        <p class="text-muted">Futsal, Badminton, Basket, Tennis, Voli</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="feature-card text-center">
                        <div class="feature-icon">⏰</div>
                        <h5>Booking 24/7</h5>
                        <p class="text-muted">Booking kapan saja, di mana saja</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="feature-card text-center">
                        <div class="feature-icon">💳</div>
                        <h5>Pembayaran Mudah</h5>
                        <p class="text-muted">Bayar di tempat, transfer, atau QRIS</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="feature-card text-center">
                        <div class="feature-icon">⭐</div>
                        <h5>Rating & Review</h5>
                        <p class="text-muted">Lihat review dari pengguna lain</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats -->
    <section class="stats-section py-5">
        <div class="container">
            <div class="row text-center">
                <div class="col-md-3">
                    <div class="stat-number">50+</div>
                    <p class="text-muted">Lapangan Tersedia</p>
                </div>
                <div class="col-md-3">
                    <div class="stat-number">1000+</div>
                    <p class="text-muted">Booking Selesai</p>
                </div>
                <div class="col-md-3">
                    <div class="stat-number">500+</div>
                    <p class="text-muted">User Aktif</p>
                </div>
                <div class="col-md-3">
                    <div class="stat-number">4.8</div>
                    <p class="text-muted">Rating User</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-white text-center py-4">
        <div class="container">
            <p class="mb-0">&copy; {{ date('Y') }} Booking Lapangan. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>