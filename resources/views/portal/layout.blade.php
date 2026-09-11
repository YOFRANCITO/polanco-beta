<!DOCTYPE html>
<html lang="es" class="light-style layout-menu-fixed">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>@yield('title', 'Portal de Socios - Club Polanco')</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
    <!-- Core & Vendor CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@2.1.4/css/boxicons.min.css">
    @vite([
        'resources/assets/vendor/scss/core.scss',
        'resources/assets/css/demo.css'
    ])
    <style>
        :root {
            --bs-primary: #1a7a3c;
            --bs-primary-rgb: 26, 122, 60;
        }
        .bg-polanco-header {
            background: linear-gradient(135deg, #1a7a3c 0%, #0d4a23 100%);
            color: #ffffff;
        }
        .nav-portal .nav-link {
            color: rgba(255, 255, 255, 0.85);
            font-weight: 500;
            padding: 0.5rem 1rem;
            border-radius: 6px;
            transition: all 0.2s ease;
        }
        .nav-portal .nav-link:hover, .nav-portal .nav-link.active {
            color: #ffffff;
            background-color: rgba(255, 255, 255, 0.18);
        }
        .portal-card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.05);
        }
    </style>
</head>
<body class="bg-light d-flex flex-column min-vh-100">

    <!-- Top Navbar -->
    <header class="bg-polanco-header py-2 shadow-sm">
        <div class="container-xl d-flex flex-wrap align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-3">
                <a href="{{ route('portal.inicio') }}" class="d-flex align-items-center gap-2 text-decoration-none text-white">
                    <span style="display:inline-block; width:44px; height:44px;">
                        @include('_partials.macros', ['width' => 44])
                    </span>
                    <span class="badge bg-white text-dark fw-semibold text-uppercase px-2 py-1" style="letter-spacing: 0.5px; font-size: 0.72rem;">Portal de Socios</span>
                </a>
            </div>

            @if(session()->has('socio_id'))
            <nav class="nav nav-portal my-2 my-md-0 gap-1">
                <a class="nav-link {{ request()->routeIs('portal.inicio') ? 'active' : '' }}" href="{{ route('portal.inicio') }}">
                    <i class="bx bx-user me-1"></i> Mi Perfil
                </a>
                <a class="nav-link {{ request()->routeIs('portal.historial') ? 'active' : '' }}" href="{{ route('portal.historial') }}">
                    <i class="bx bx-history me-1"></i> Historial de Pagos
                </a>
                <a class="nav-link {{ request()->routeIs('portal.pagar') ? 'active' : '' }}" href="{{ route('portal.pagar') }}">
                    <i class="bx bx-credit-card me-1"></i> Pagar Membresía
                </a>
            </nav>

            <div class="d-flex align-items-center gap-2">
                <a href="{{ route('portal.logout') }}" class="btn btn-sm btn-outline-light">
                    <i class="bx bx-log-out me-1"></i> Salir
                </a>
            </div>
            @else
            <a href="{{ route('login') }}" class="btn btn-sm btn-outline-light">
                <i class="bx bx-lock-alt me-1"></i> Panel Administrativo
            </a>
            @endif
        </div>
    </header>

    <!-- Main Container -->
    <main class="container-xl py-4 flex-grow-1">
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <i class="bx bx-check-circle me-1"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
            <i class="bx bx-error-circle me-1"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="py-4 text-center text-muted small border-top bg-white mt-auto">
        <div class="container">
            <p class="mb-0">© {{ date('Y') }} <strong>Club Polanco</strong> — Todos los derechos reservados. Instalaciones y Deporte de Primer Nivel.</p>
            <p class="mb-0 text-muted" style="font-size: 0.75rem;">Para asistencia con su cuenta, contacte a <a href="mailto:recepcion@clubpolanco.com" class="text-muted">recepcion@clubpolanco.com</a> o al (55) 1234-5678</p>
        </div>
    </footer>

    <!-- Bootstrap & Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>
