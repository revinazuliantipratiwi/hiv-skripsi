<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', 'Admin - Pemetaan HIV')</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" />

    <!-- Tambahan CSS dari child view -->
    @stack('styles')

    <style>
        :root {
            --primary-color-start: #d32f2f; /* merah tua */
            --primary-color-end: #b71c1c;   /* merah gelap */
            --background-color-light: #fff5f5; /* putih kemerahan */
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(to bottom right, var(--background-color-light), #ffffff);
            margin: 0;
        }

        .sidebar {
            background: linear-gradient(180deg, var(--primary-color-start), var(--primary-color-end));
            color: #fff;
            min-height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            width: 250px;
            z-index: 1030;
            overflow-y: auto;
        }

        .sidebar .nav-link {
            color: #fff;
            margin-bottom: 8px;
        }

        .sidebar .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 6px;
        }

        .navbar-custom {
            background: linear-gradient(90deg, var(--primary-color-start), var(--primary-color-end));
            position: fixed;
            top: 0;
            left: 250px; /* offset sidebar width */
            right: 0;
            z-index: 1040;
        }

        .navbar-custom .navbar-brand,
        .navbar-custom .nav-link {
            color: #fff;
        }

        .navbar-custom .nav-link:hover {
            color: #ffeaea;
        }

        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }

        .btn-primary {
            background-color: var(--primary-color-start);
            border-color: var(--primary-color-end);
        }

        .btn-primary:hover {
            background-color: var(--primary-color-end);
            border-color: var(--primary-color-start);
        }

        .content-area {
            padding: 100px 20px 20px 20px; /* top padding adjusted for fixed navbar */
            margin-left: 250px; /* offset sidebar */
        }

        footer {
            margin-left: 250px;
        }

        @media (max-width: 768px) {
            .sidebar {
                position: relative;
                width: 100%;
                min-height: auto;
            }

            .navbar-custom {
                left: 0;
            }

            .content-area {
                margin-left: 0;
                padding-top: 100px;
            }

            footer {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>

<div>
    <!-- Sidebar -->
    <nav class="sidebar p-3">
        <h3 class="text-center fw-bold mb-4">Admin Panel</h3>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.dashboard') }}">
                    <i class="bi bi-speedometer2 me-2"></i> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.hiv') }}">
                    <i class="bi bi-droplet-half me-2"></i> Data HIV
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.rumahsakit') }}">
                    <i class="bi bi-hospital me-2"></i> Puskesmas
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.rekapitulasi') }}">
                    <i class="bi bi-clipboard-data me-2"></i> Rekapitulasi
                </a>
            </li>
        </ul>
    </nav>

    <div class="flex-grow-1">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-custom">
            <div class="container-fluid">
                <a class="navbar-brand" href="{{ route('admin.dashboard') }}">Admin Pemetaan HIV</a>
                <div class="collapse navbar-collapse justify-content-end">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-outline-light">Logout</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="content-area">
            @yield('content')
        </main>
    </div>
</div>

<footer class="text-center py-3 mt-auto bg-light">
    &copy; {{ date('Y') }} Aplikasi Pemetaan HIV - Admin Panel
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Tempatkan scripts dari child view -->
@stack('scripts')

</body>
</html>
