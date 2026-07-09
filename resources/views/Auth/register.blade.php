<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Sport Booking</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px 0;
        }

        .card {
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            overflow: hidden;
        }

        .card-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 30px;
            text-align: center;
            border: none;
        }

        .card-header h3 {
            color: white;
            font-weight: bold;
            margin: 0;
        }

        .card-header p {
            color: rgba(255, 255, 255, 0.8);
            margin: 0;
        }

        .card-body {
            padding: 40px;
            background: white;
        }

        .form-control {
            border-radius: 10px;
            padding: 12px 15px;
            border: 2px solid #e1e5eb;
        }

        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 10px;
            padding: 12px;
            font-weight: bold;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, .3);
        }

        .login-link {
            color: #667eea;
            text-decoration: none;
            font-weight: bold;
        }

        .login-link:hover {
            color: #764ba2;
            text-decoration: underline;
        }

        .form-icon {
            position: relative;
        }

        .form-icon i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #adb5bd;
        }

        .form-icon .form-control {
            padding-left: 45px;
        }

        input {
            font-size: 16px;
        }

        /* =======================
   RESPONSIVE
======================= */

        .card {
            width: 100%;
        }

        @media (max-width:992px) {

            .card-body {
                padding: 30px;
            }

            .card-header {
                padding: 25px;
            }

        }

        @media (max-width:768px) {

            body {
                padding: 15px;
                align-items: flex-start;
            }

            .container {
                padding: 0;
            }

            .card {
                border-radius: 15px;
            }

            .card-header {
                padding: 20px;
            }

            .card-header h3 {
                font-size: 1.5rem;
            }

            .card-header p {
                font-size: .9rem;
            }

            .card-body {
                padding: 25px 20px;
            }

            .form-control {
                font-size: 15px;
                padding: 12px 15px 12px 45px;
            }

            .btn-primary {
                font-size: 16px;
            }

        }

        @media (max-width:576px) {

            .card-body {
                padding: 20px 15px;
            }

            .card-header h3 {
                font-size: 1.25rem;
            }

            .card-header p {
                font-size: .85rem;
            }

            .form-control {
                font-size: 14px;
            }

            .btn-primary {
                font-size: 15px;
            }

            .alert {
                font-size: 14px;
            }

        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-5">
                <div class="card">
                    <div class="card-header">
                        <h3><i class="fas fa-futbol me-2"></i>Sport Booking</h3>
                        <p>Daftar akun baru</p>
                    </div>
                    <div class="card-body">
                        @if($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="fas fa-exclamation-circle me-2"></i>
                                @foreach($errors->all() as $error)
                                    <p class="mb-0">{{ $error }}</p>
                                @endforeach
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <form action="{{ route('register') }}" method="POST">
                            @csrf
                            <div class="mb-3 form-icon">
                                <i class="fas fa-user"></i>
                                <input type="text" class="form-control" id="name" name="nama_lengkap" placeholder="Nama Lengkap"
                                    value="{{ old('nama_lengkap') }}" required>
                            </div>
                            <div class="mb-3 form-icon">
                                <i class="fas fa-envelope"></i>
                                <input type="email" class="form-control" id="email" name="email"
                                    placeholder="Email Address" value="{{ old('email') }}" required>
                            </div>
                            <div class="mb-3 form-icon">
                                <i class="fas fa-phone"></i>
                                <input type="text" class="form-control" id="no_telepon" name="no_telepon"
                                    placeholder="No. Telepon (opsional)" value="{{ old('no_telepon') }}">
                            </div>
                            <div class="mb-3 form-icon">
                                <i class="fas fa-map-marker-alt"></i>
                                <input type="text" class="form-control" id="alamat" name="alamat"
                                    placeholder="Alamat (opsional)" value="{{ old('alamat') }}">
                            </div>
                            <div class="mb-3 form-icon">
                                <i class="fas fa-lock"></i>
                                <input type="password" class="form-control" id="password" name="password"
                                    placeholder="Password (minimal 8 karakter)" required>
                            </div>
                            <div class="mb-3 form-icon">
                                <i class="fas fa-check-circle"></i>
                                <input type="password" class="form-control" id="password_confirmation"
                                    name="password_confirmation" placeholder="Konfirmasi Password" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100 py-3">
                                <i class="fas fa-user-plus me-2"></i>Daftar
                            </button>
                        </form>
                        <div class="mt-4 text-center">
                            <p class="mb-0">Sudah punya akun? <a href="{{ route('login') }}" class="login-link">Login
                                    Sekarang</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>