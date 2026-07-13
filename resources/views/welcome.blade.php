<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Booking Lapang - Sistem Booking Lapangan Olahraga</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* ===== RESET & BASE ===== */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        html {
            scroll-behavior: smooth;
            -webkit-tap-highlight-color: transparent;
        }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            min-height: 100dvh; /* Dynamic viewport height untuk mobile */
            overflow-y: auto;
            padding: 0;
            margin: 0;
        }
        
        /* ===== BACKGROUND ANIMATION ===== */
        .bg-animation {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
            overflow: hidden;
            pointer-events: none;
        }
        
        .bg-animation .circle {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.04);
            animation: float 20s infinite ease-in-out;
        }
        
        .bg-animation .circle:nth-child(1) {
            width: min(400px, 50vw);
            height: min(400px, 50vw);
            top: -10%;
            right: -10%;
            animation-delay: 0s;
        }
        
        .bg-animation .circle:nth-child(2) {
            width: min(300px, 40vw);
            height: min(300px, 40vw);
            bottom: -10%;
            left: -10%;
            animation-delay: -5s;
        }
        
        .bg-animation .circle:nth-child(3) {
            width: min(200px, 30vw);
            height: min(200px, 30vw);
            top: 40%;
            left: 50%;
            transform: translate(-50%, -50%);
            animation-delay: -10s;
        }
        
        @keyframes float {
            0%, 100% { transform: translate(0, 0) scale(1); }
            25% { transform: translate(30px, -30px) scale(1.1); }
            50% { transform: translate(-20px, 20px) scale(0.9); }
            75% { transform: translate(15px, -15px) scale(1.05); }
        }
        
        /* ===== HERO SECTION ===== */
        .hero-section {
            position: relative;
            z-index: 1;
            width: 100%;
            min-height: 100vh;
            min-height: 100dvh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        /* ===== MAIN CARD ===== */
        .main-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-radius: 28px;
            padding: clamp(30px, 5vw, 55px);
            max-width: 950px;
            width: 100%;
            box-shadow: 0 30px 80px rgba(0, 0, 0, 0.25);
            animation: fadeInUp 0.8s ease;
            position: relative;
            margin: 20px auto;
        }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px) scale(0.96);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }
        
        /* ===== BADGE TOP ===== */
        .badge-top {
            position: absolute;
            top: clamp(-12px, -1.5vw, -8px);
            right: clamp(15px, 3vw, 30px);
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: white;
            padding: clamp(6px, 0.8vw, 10px) clamp(14px, 2vw, 22px);
            border-radius: 50px;
            font-size: clamp(10px, 1vw, 13px);
            font-weight: 700;
            box-shadow: 0 5px 20px rgba(245, 87, 108, 0.35);
            white-space: nowrap;
            letter-spacing: 0.3px;
        }
        
        .badge-top i {
            margin-right: 5px;
        }
        
        /* ===== SPORT ICON ===== */
        .sport-icon-wrapper {
            text-align: center;
        }
        
        .sport-icon {
            font-size: clamp(50px, 10vw, 85px);
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            display: inline-block;
            animation: bounce 2.5s infinite ease-in-out;
        }
        
        @keyframes bounce {
            0%, 100% { transform: translateY(0) scale(1); }
            50% { transform: translateY(-12px) scale(1.05); }
        }
        
        /* ===== TITLE ===== */
        .main-title {
            font-size: clamp(28px, 6vw, 52px);
            font-weight: 800;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin: clamp(12px, 2vw, 22px) 0 clamp(6px, 1vw, 12px);
            letter-spacing: -0.5px;
            line-height: 1.15;
        }
        
        .sub-title {
            color: #6c757d;
            font-size: clamp(15px, 2.2vw, 22px);
            margin-bottom: clamp(20px, 3vw, 35px);
            font-weight: 300;
            line-height: 1.5;
        }
        
        /* ===== FEATURES GRID ===== */
        .features {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(min(100%, 180px), 1fr));
            gap: clamp(12px, 1.5vw, 22px);
            margin: clamp(25px, 4vw, 45px) 0;
        }
        
        .feature-item {
            padding: clamp(16px, 2vw, 24px) clamp(12px, 1.5vw, 18px);
            background: #f8f9fa;
            border-radius: 16px;
            text-align: center;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: default;
            border: 1px solid rgba(0, 0, 0, 0.04);
        }
        
        .feature-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 35px rgba(0, 0, 0, 0.08);
            background: white;
        }
        
        .feature-item i {
            font-size: clamp(28px, 4vw, 40px);
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: clamp(6px, 1vw, 12px);
            display: block;
        }
        
        .feature-item h6 {
            font-weight: 700;
            color: #2d3748;
            margin-bottom: 4px;
            font-size: clamp(13px, 1.2vw, 17px);
        }
        
        .feature-item p {
            font-size: clamp(11px, 1vw, 14px);
            color: #718096;
            margin: 0;
            line-height: 1.4;
        }
        
        /* ===== BUTTONS ===== */
        .btn-group-custom {
            display: flex;
            gap: clamp(10px, 1.5vw, 18px);
            justify-content: center;
            flex-wrap: wrap;
            margin: clamp(15px, 2vw, 25px) 0;
        }
        
        .btn-custom {
            padding: clamp(13px, 1.5vw, 17px) clamp(28px, 4vw, 48px);
            border-radius: 50px;
            font-weight: 700;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: clamp(14px, 1.2vw, 17px);
            min-width: clamp(140px, 20vw, 200px);
            gap: 8px;
            border: none;
            cursor: pointer;
        }
        
        .btn-custom i {
            font-size: clamp(14px, 1.2vw, 18px);
        }
        
        .btn-primary-custom {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        }
        
        .btn-primary-custom:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
            color: white;
        }
        
        .btn-primary-custom:active {
            transform: translateY(-1px);
        }
        
        .btn-outline-custom {
            background: transparent;
            color: #667eea;
            border: 2px solid #667eea;
        }
        
        .btn-outline-custom:hover {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
        }
        
        .btn-outline-custom:active {
            transform: translateY(-1px);
        }
        
        /* ===== STATS ===== */
        .stats {
            display: flex;
            justify-content: center;
            gap: clamp(20px, 5vw, 55px);
            margin-top: clamp(20px, 3vw, 38px);
            padding-top: clamp(20px, 3vw, 38px);
            border-top: 2px solid #e9ecef;
            flex-wrap: wrap;
        }
        
        .stat-item {
            text-align: center;
            flex: 0 1 auto;
            min-width: 80px;
        }
        
        .stat-item .number {
            font-size: clamp(22px, 3.5vw, 32px);
            font-weight: 800;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            display: block;
            line-height: 1.2;
        }
        
        .stat-item .label {
            font-size: clamp(12px, 1vw, 15px);
            color: #718096;
            display: block;
            margin-top: 2px;
            font-weight: 500;
        }
        
        /* ===== SCROLL INDICATOR ===== */
        .scroll-indicator {
            text-align: center;
            margin-top: clamp(20px, 3vw, 35px);
            padding-top: clamp(15px, 2vw, 25px);
            border-top: 1px solid rgba(0, 0, 0, 0.06);
        }
        
        .scroll-indicator span {
            color: #adb5bd;
            font-size: clamp(11px, 0.9vw, 14px);
            display: block;
            font-weight: 500;
            letter-spacing: 0.5px;
        }
        
        .scroll-indicator i {
            color: #adb5bd;
            font-size: clamp(18px, 2vw, 26px);
            animation: bounceArrow 2s infinite ease-in-out;
            display: block;
            margin-top: 4px;
        }
        
        @keyframes bounceArrow {
            0%, 100% { transform: translateY(0); opacity: 0.6; }
            50% { transform: translateY(8px); opacity: 1; }
        }
        
        /* ======================================== */
        /* ===== RESPONSIVE BREAKPOINTS ===== */
        /* ======================================== */
        
        /* Tablet & Small Desktop (max-width: 992px) */
        @media (max-width: 992px) {
            .main-card {
                border-radius: 24px;
                padding: clamp(25px, 4vw, 40px);
            }
            
            .features {
                grid-template-columns: repeat(2, 1fr);
                gap: 14px;
            }
            
            .badge-top {
                right: 20px;
                font-size: 11px;
                padding: 6px 16px;
            }
        }
        
        /* Mobile Landscape (max-width: 768px) */
        @media (max-width: 768px) {
            .hero-section {
                padding: 15px;
                min-height: 100dvh;
            }
            
            .main-card {
                border-radius: 20px;
                padding: 25px 18px 30px;
                margin: 10px 0;
            }
            
            .badge-top {
                position: relative;
                top: auto;
                right: auto;
                display: inline-block;
                margin-bottom: 15px;
                font-size: 10px;
                padding: 5px 14px;
                box-shadow: 0 3px 12px rgba(245, 87, 108, 0.3);
            }
            
            .features {
                grid-template-columns: repeat(2, 1fr);
                gap: 10px;
                margin: 20px 0;
            }
            
            .feature-item {
                padding: 14px 10px;
                border-radius: 12px;
            }
            
            .feature-item i {
                font-size: 26px;
            }
            
            .feature-item h6 {
                font-size: 13px;
            }
            
            .feature-item p {
                font-size: 11px;
            }
            
            .btn-group-custom {
                flex-direction: column;
                align-items: stretch;
                gap: 12px;
            }
            
            .btn-custom {
                width: 100%;
                padding: 14px 20px;
                font-size: 15px;
                min-width: unset;
            }
            
            .stats {
                gap: 15px;
                padding-top: 20px;
                margin-top: 20px;
            }
            
            .stat-item .number {
                font-size: 22px;
            }
            
            .stat-item .label {
                font-size: 12px;
            }
            
            .scroll-indicator span {
                font-size: 11px;
            }
        }
        
        /* Mobile Portrait (max-width: 480px) */
        @media (max-width: 480px) {
            .hero-section {
                padding: 10px;
            }
            
            .main-card {
                border-radius: 16px;
                padding: 20px 14px 24px;
                margin: 5px 0;
            }
            
            .sport-icon {
                font-size: 42px;
            }
            
            .main-title {
                font-size: 26px;
                margin: 10px 0 6px;
            }
            
            .sub-title {
                font-size: 14px;
                margin-bottom: 18px;
            }
            
            .features {
                grid-template-columns: 1fr 1fr;
                gap: 8px;
                margin: 16px 0;
            }
            
            .feature-item {
                padding: 12px 8px;
                border-radius: 10px;
            }
            
            .feature-item i {
                font-size: 22px;
                margin-bottom: 4px;
            }
            
            .feature-item h6 {
                font-size: 11px;
            }
            
            .feature-item p {
                font-size: 10px;
            }
            
            .btn-custom {
                padding: 12px 16px;
                font-size: 13px;
                border-radius: 12px;
            }
            
            .btn-custom i {
                font-size: 13px;
            }
            
            .stats {
                gap: 10px;
                padding-top: 16px;
                margin-top: 16px;
            }
            
            .stat-item {
                min-width: 60px;
            }
            
            .stat-item .number {
                font-size: 18px;
            }
            
            .stat-item .label {
                font-size: 10px;
            }
            
            .badge-top {
                font-size: 9px;
                padding: 4px 12px;
                margin-bottom: 10px;
            }
            
            .scroll-indicator {
                margin-top: 16px;
                padding-top: 14px;
            }
            
            .scroll-indicator span {
                font-size: 10px;
            }
            
            .scroll-indicator i {
                font-size: 16px;
            }
            
            .bg-animation .circle:nth-child(1) {
                width: 200px;
                height: 200px;
            }
            
            .bg-animation .circle:nth-child(2) {
                width: 150px;
                height: 150px;
            }
            
            .bg-animation .circle:nth-child(3) {
                width: 100px;
                height: 100px;
            }
        }
        
        /* Very Small Phones (max-width: 360px) */
        @media (max-width: 360px) {
            .main-card {
                padding: 16px 10px 20px;
            }
            
            .features {
                grid-template-columns: 1fr 1fr;
                gap: 6px;
            }
            
            .feature-item {
                padding: 10px 6px;
            }
            
            .feature-item i {
                font-size: 18px;
            }
            
            .feature-item h6 {
                font-size: 10px;
            }
            
            .feature-item p {
                font-size: 9px;
            }
            
            .main-title {
                font-size: 22px;
            }
            
            .sub-title {
                font-size: 12px;
            }
            
            .btn-custom {
                font-size: 12px;
                padding: 10px 14px;
            }
            
            .stat-item .number {
                font-size: 16px;
            }
        }
        
        /* Tablet Landscape (768px - 1024px) */
        @media (min-width: 768px) and (max-width: 1024px) and (orientation: landscape) {
            .hero-section {
                padding: 30px 20px;
                min-height: 100vh;
            }
            
            .main-card {
                padding: 35px 40px;
                max-width: 85%;
            }
            
            .features {
                grid-template-columns: repeat(4, 1fr);
            }
        }
        
        /* Desktop Large (min-width: 1400px) */
        @media (min-width: 1400px) {
            .main-card {
                max-width: 1050px;
                padding: 60px 70px;
            }
            
            .features {
                gap: 28px;
            }
        }
        
        /* ===== TOUCH DEVICE OPTIMIZATION ===== */
        @media (hover: none) {
            .feature-item:hover {
                transform: none;
                box-shadow: none;
                background: #f8f9fa;
            }
            
            .btn-custom:hover {
                transform: none;
            }
            
            .btn-primary-custom:hover {
                box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
            }
            
            .btn-outline-custom:hover {
                background: transparent;
                color: #667eea;
            }
        }
        
        /* ===== REDUCED MOTION ===== */
        @media (prefers-reduced-motion: reduce) {
            *,
            *::before,
            *::after {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
            }
            
            .sport-icon {
                animation: none;
            }
            
            .scroll-indicator i {
                animation: none;
            }
            
            .bg-animation .circle {
                animation: none;
            }
            
            .main-card {
                animation: none;
            }
        }
    </style>
</head>
<body>
    <!-- Background Animation -->
    <div class="bg-animation">
        <div class="circle"></div>
        <div class="circle"></div>
        <div class="circle"></div>
    </div>
    
    <div class="hero-section">
        <div class="main-card">
            <!-- Badge -->
            <div class="badge-top">
                <i class="fas fa-star"></i> #1 Booking Platform
            </div>
            
            <div class="text-center">
                <!-- Icon -->
                <div class="sport-icon-wrapper">
                    <div class="sport-icon">
                        <i class="fas fa-futbol"></i>
                    </div>
                </div>
                
                <!-- Title -->
                <h1 class="main-title">Booking Lapang</h1>
                <p class="sub-title">Sistem Booking Lapangan Olahraga Modern &amp; Terpercaya</p>
                
                <!-- Features -->
                <div class="features">
                    <div class="feature-item">
                        <i class="fas fa-table-tennis"></i>
                        <h6>Berbagai Lapangan</h6>
                        <p>Futsal, Badminton, Basket &amp; lebih banyak</p>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-calendar-check"></i>
                        <h6>Booking Mudah</h6>
                        <p>Booking online cepat &amp; praktis</p>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-credit-card"></i>
                        <h6>Pembayaran Aman</h6>
                        <p>Berbagai metode pembayaran</p>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-clock"></i>
                        <h6>24/7 Akses</h6>
                        <p>Booking kapan saja &amp; di mana saja</p>
                    </div>
                </div>
                
                <!-- Buttons -->
                <div class="btn-group-custom">
                    <a href="{{ route('login') }}" class="btn-custom btn-primary-custom">
                        <i class="fas fa-sign-in-alt"></i> Login
                    </a>
                    <a href="{{ route('register') }}" class="btn-custom btn-outline-custom">
                        <i class="fas fa-user-plus"></i> Daftar Sekarang
                    </a>
                </div>
                
                <!-- Stats -->
                <div class="stats">
                    <div class="stat-item">
                        <span class="number">50+</span>
                        <span class="label">Lapangan Tersedia</span>
                    </div>
                    <div class="stat-item">
                        <span class="number">1000+</span>
                        <span class="label">User Aktif</span>
                    </div>
                    <div class="stat-item">
                        <span class="number">5000+</span>
                        <span class="label">Booking Selesai</span>
                    </div>
                </div>
                
                <!-- Scroll Indicator -->
                <div class="scroll-indicator">
                    <span>Scroll untuk menjelajahi</span>
                    <i class="fas fa-chevron-down"></i>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>