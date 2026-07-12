<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') | Booking Lapangan Admin</title>

    {{-- Bootstrap CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    {{-- Google Font --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    {{-- Custom CSS --}}
    @vite(['resources/css/admin.css'])

</head>


<body>


    {{-- Sidebar --}}
    @include('components.admin-sidebar')

    {{-- Main Content --}}
    <div class="main-content expand">

        {{-- Navbar --}}
        @include('components.admin-navbar')

        {{-- Page Content --}}
        <div class="container-fluid py-4">

            @yield('content')

        </div>

    </div>



    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const sidebar = document.getElementById('sidebar');
            const main = document.querySelector('.main-content');
            const btn = document.getElementById('sidebarToggle');

            btn.addEventListener('click', function () {

                if (window.innerWidth <= 768) {
                    // Mobile
                    sidebar.classList.toggle('active');
                } else {
                    // Desktop
                    sidebar.classList.toggle('hide');
                    main.classList.toggle('expand');
                }

                

            });

        });
    </script>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

    @yield('scripts')
</body>

</html>