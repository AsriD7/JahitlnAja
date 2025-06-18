<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - @yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        body {
            display: flex;
            min-height: 100vh;
            margin: 0;
            background-color: #f8f9fa;
        }
        .sidebar {
            width: 250px;
            background: linear-gradient(135deg, #8c0d4f, #700a3f);
            min-height: 100vh;
            color: #fff;
            transition: all 0.3s ease;
            position: fixed;
        }
        .sidebar.collapsed {
            width: 70px;
        }
        .sidebar .nav-item {
            padding: 15px;
            transition: all 0.3s ease;
        }
        .sidebar .nav-item:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }
        .sidebar .nav-link {
            color: #fff;
            text-decoration: none;
            display: flex;
            align-items: center;
        }
        .sidebar .nav-link i {
            margin-right: 10px;
        }
        .sidebar .nav-link span {
            transition: opacity 0.3s ease;
        }
        .sidebar.collapsed .nav-link span {
            opacity: 0;
            width: 0;
        }
        .content {
            margin-left: 250px;
            padding: 30px;
            flex-grow: 1;
            transition: margin-left 0.3s ease;
        }
        .content.collapsed {
            margin-left: 70px;
        }
        .brand {
            font-size: 1.5rem;
            font-weight: bold;
            padding: 20px 15px;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        .fade-in {
            animation: fadeIn 0.5s ease-in;
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-250px);
            }
            .sidebar.active {
                transform: translateX(0);
            }
            .content {
                margin-left: 0;
            }
            .hamburger {
                display: block;
                font-size: 1.5rem;
                background: none;
                border: none;
                color: #8c0d4f;
                cursor: pointer;
            }
        }
    </style>
</head>
<body>
    <div class="sidebar" id="sidebar">
        <div class="brand">Admin Panel</div>
        <div class="nav flex-column">
            <a href="{{ route('admin.dashboard') }}" class="nav-link nav-item">
                <i class="bi bi-speedometer2"></i><span>Dashboard</span>
            </a>
            <a href="{{ route('admin.users') }}" class="nav-link nav-item">
                <i class="bi bi-people"></i><span>Manajemen Akun</span>
            </a>
            <a href="{{ route('admin.services') }}" class="nav-link nav-item">
                <i class="bi bi-tools"></i><span>Manajemen Layanan</span>
            </a>
            <a href="{{ route('admin.orders') }}" class="nav-link nav-item">
                <i class="bi bi-cash"></i><span>Verifikasi Pembayaran</span>
            </a>
            <a href="{{ route('logout') }}" class="nav-link nav-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="bi bi-box-arrow-right"></i><span>Logout</span>
            </a>
        </div>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
    </div>

    <div class="content" id="content">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @yield('content')
    </div>

    <!-- Tombol Hamburger untuk Mobile -->
    <button class="hamburger d-md-none position-fixed top-0 start-0 m-3" id="hamburgerBtn">
        <i class="bi bi-list"></i>
    </button>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const sidebar = document.getElementById('sidebar');
            const content = document.getElementById('content');
            const hamburgerBtn = document.getElementById('hamburgerBtn');

            // Toggle sidebar pada layar kecil
            hamburgerBtn.addEventListener('click', function () {
                sidebar.classList.toggle('active');
            });

            // Toggle sidebar collapse pada layar besar
            sidebar.addEventListener('click', function (e) {
                if (window.innerWidth > 768 && e.target.tagName === 'A') {
                    sidebar.classList.toggle('collapsed');
                    content.classList.toggle('collapsed');
                }
            });
        });
    </script>
</body>
</html>
