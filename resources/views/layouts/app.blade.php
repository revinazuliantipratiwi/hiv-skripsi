<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aplikasi Pemetaan HIV</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="{{ secure_asset('build/assets/app-DZUsWXEA.css') }}">
    <script type="module" src="{{ secure_asset('build/assets/app-pd4cR8cG.js') }}"></script>
    <!-- Tambahan CSS dari child view -->
    @stack('styles')

    <style>
        :root {
            --primary-color-start: #d32f2f; /* merah tua */
            --primary-color-end: #b71c1c;   /* merah gelap */
            --background-color-light: #fff5f5; /* putih kemerahan */
        }

        body {
            background: linear-gradient(to bottom right, var(--background-color-light), #ffffff);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .navbar-custom {
            background: linear-gradient(90deg, var(--primary-color-start), var(--primary-color-end));
        }

        .navbar-custom .nav-link,
        .navbar-custom .navbar-brand {
            color: #fff;
        }

        .navbar-custom .nav-link:hover {
            color: #ffeaea;
        }

        footer {
            background: linear-gradient(90deg, var(--primary-color-start), var(--primary-color-end));
            color: #fff;
        }

        /* Tambahan style untuk tampilan lebih lembut */
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
    </style>
</head>
<body class="d-flex flex-column min-vh-100">

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-custom shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('index') }}">Pemetaan HIV</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link" href="{{ route('index') }}">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('peta') }}">Peta </a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('informasi') }}">Informasi HIV</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('panduan') }}">Panduan</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('faqs') }}">FAQs</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('kontak') }}">Kontak Layanan</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
                </ul>
                
            </div>
        </div>
    </nav>

    <!-- Main -->
    <main class="flex-fill container py-5">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="text-center py-3 mt-auto">
        &copy; {{ date('Y') }} Aplikasi Pemetaan HIV - Semua Hak Dilindungi
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Tambahan JS dari child view -->
    @stack('scripts')
</body>
</html>
