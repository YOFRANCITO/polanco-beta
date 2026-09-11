<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Club Social Petrolero Polanco — Instalaciones, Deporte y Recreación</title>
    <meta name="description" content="Bienvenido a Club Social Petrolero Polanco. Disfrute de canchas de tenis, pádel, piscinas, fútbol, gimnasio, restaurante y el mejor ambiente familiar y exclusivo." />
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&family=Public+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
    
    <!-- Bootstrap 5 & Boxicons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@2.1.4/css/boxicons.min.css" />

    <style>
        :root {
            --primary: #1a7a3c;
            --primary-dark: #0d4a23;
            --accent-gold: #c9a84c;
            --accent-gold-light: #f5eed8;
            --dark: #121c15;
        }

        body {
            font-family: 'Public Sans', sans-serif;
            color: #435249;
            background-color: #ffffff;
            overflow-x: hidden;
        }

        h1, h2, h3, h4, h5, h6, .brand-font {
            font-family: 'Outfit', sans-serif;
        }

        /* Navbar */
        .landing-nav {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(26, 122, 60, 0.1);
            transition: all 0.3s ease;
        }
        .nav-link {
            color: #2b3a30;
            font-weight: 500;
            padding: 0.5rem 1rem !important;
            transition: color 0.2s ease;
        }
        .nav-link:hover {
            color: var(--primary);
        }

        /* Hero */
        .hero-section {
            background: radial-gradient(circle at 85% 20%, rgba(201, 168, 76, 0.12), transparent 45%),
                        radial-gradient(circle at 10% 80%, rgba(26, 122, 60, 0.1), transparent 40%),
                        linear-gradient(180deg, #f7fbf8 0%, #ffffff 100%);
            padding: 130px 0 80px 0;
            position: relative;
        }
        .badge-hero {
            background: rgba(26, 122, 60, 0.08);
            color: var(--primary);
            border: 1px solid rgba(26, 122, 60, 0.25);
            font-size: 0.85rem;
            padding: 0.45rem 1rem;
            border-radius: 50px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        /* Stats Bar */
        .stats-bar {
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.06);
            border: 1px solid #eef3ef;
            margin-top: -45px;
            position: relative;
            z-index: 10;
        }

        /* Cards & Components */
        .facility-card {
            border: 1px solid #eaf0eb;
            border-radius: 16px;
            background: #ffffff;
            transition: all 0.3s ease;
            overflow: hidden;
            height: 100%;
        }
        .facility-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 16px 36px rgba(26, 122, 60, 0.1);
            border-color: rgba(26, 122, 60, 0.3);
        }
        .facility-icon-wrapper {
            width: 58px;
            height: 58px;
            border-radius: 14px;
            background: rgba(26, 122, 60, 0.08);
            color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.75rem;
            margin-bottom: 1.25rem;
            transition: all 0.3s ease;
        }
        .facility-card:hover .facility-icon-wrapper {
            background: var(--primary);
            color: #ffffff;
        }

        /* Pricing Card */
        .pricing-card {
            border: 1px solid #e5ebe6;
            border-radius: 20px;
            background: #ffffff;
            transition: all 0.3s ease;
            position: relative;
        }
        .pricing-card:hover {
            transform: scale(1.02);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
        }
        .pricing-card.featured {
            border: 2px solid var(--primary);
            box-shadow: 0 15px 35px rgba(26, 122, 60, 0.12);
        }
        .badge-popular {
            position: absolute;
            top: -14px;
            left: 50%;
            transform: translateX(-50%);
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: #ffffff;
            padding: 0.3rem 1.2rem;
            border-radius: 50px;
            font-size: 0.78rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Portal Callout Banner */
        .portal-banner {
            background: linear-gradient(135deg, #1a7a3c 0%, #0d4a23 100%);
            border-radius: 24px;
            color: #ffffff;
            padding: 50px 40px;
            position: relative;
            overflow: hidden;
        }

        .btn-polanco {
            background-color: var(--primary);
            border-color: var(--primary);
            color: #ffffff;
            font-weight: 600;
            border-radius: 10px;
            padding: 0.75rem 1.75rem;
            transition: all 0.2s ease;
        }
        .btn-polanco:hover {
            background-color: var(--primary-dark);
            border-color: var(--primary-dark);
            color: #ffffff;
            transform: translateY(-2px);
            box-shadow: 0 6px 18px rgba(26, 122, 60, 0.3);
        }

        .btn-gold {
            background: linear-gradient(135deg, #c9a84c 0%, #b89335 100%);
            border: none;
            color: #ffffff;
            font-weight: 600;
            border-radius: 10px;
            padding: 0.75rem 1.75rem;
            transition: all 0.2s ease;
        }
        .btn-gold:hover {
            background: linear-gradient(135deg, #b89335 0%, #9e7d28 100%);
            color: #ffffff;
            transform: translateY(-2px);
            box-shadow: 0 6px 18px rgba(201, 168, 76, 0.35);
        }

        /* Footer */
        .landing-footer {
            background: #0f1c14;
            color: #a4b3a8;
            padding: 70px 0 30px 0;
        }
        .footer-link {
            color: #8c9e91;
            text-decoration: none;
            transition: color 0.2s ease;
            display: block;
            margin-bottom: 0.6rem;
            font-size: 0.9rem;
        }
        .footer-link:hover {
            color: #ffffff;
            padding-left: 4px;
        }
    </style>
</head>
<body>

    <!-- Top Navigation -->
    <nav class="navbar navbar-expand-lg fixed-top landing-nav py-2">
        <div class="container">
            <!-- Brand Logo (Clean emblem without text as requested) -->
            <a class="navbar-brand d-flex align-items-center gap-2" href="{{ url('/') }}">
                <img src="{{ asset('assets/img/branding/logo.png') }}" alt="Club Social Petrolero Polanco" width="48" height="48" class="rounded-circle shadow-sm bg-white p-1" style="object-fit: contain;" />
            </a>

            <!-- Mobile toggler -->
            <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
                <i class="bx bx-menu fs-2 text-dark"></i>
            </button>

            <!-- Menu Links -->
            <div class="collapse navbar-collapse" id="navMenu">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link" href="#inicio">Inicio</a></li>
                    <li class="nav-item"><a class="nav-link" href="#instalaciones">Instalaciones</a></li>
                    <li class="nav-item"><a class="nav-link" href="#membresias">Membresías</a></li>
                    <li class="nav-item"><a class="nav-link" href="#beneficios">Beneficios</a></li>
                    <li class="nav-item"><a class="nav-link" href="#contacto">Contacto</a></li>
                </ul>

                <div class="d-flex align-items-center gap-2">
                    <a href="{{ route('portal.login') }}" class="btn btn-outline-success btn-sm px-3 rounded-pill fw-semibold">
                        <i class="bx bx-user me-1"></i> Portal Socios
                    </a>
                    <a href="{{ route('login') }}" class="btn btn-success btn-sm px-3 rounded-pill fw-semibold shadow-sm">
                        <i class="bx bx-lock-alt me-1"></i> Panel Admin
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section" id="inicio">
        <div class="container">
            <div class="row align-items-center g-5">
                <!-- Text Content -->
                <div class="col-lg-7">
                    <div class="d-inline-flex align-items-center gap-2 px-3 py-1 rounded-pill bg-success bg-opacity-10 text-success fw-bold small mb-3 border border-success border-opacity-25">
                        <i class="bx bxs-badge-check"></i>
                        <span>Club Social Petrolero Polanco • Desde 1968</span>
                    </div>
                    <h1 class="hero-title mb-3">
                        Tu espacio de deporte, familia y recreación en <span style="color: var(--primary);">Santa Cruz</span>
                    </h1>
                    <p class="hero-subtitle mb-4">
                        Disfruta de instalaciones deportivas de primer nivel: canchas de tenis y pádel de competencia, piscina semiolímpica, fútbol, racquet, eventos exclusivos y el mejor club social.
                    </p>
                    <div class="d-flex flex-wrap gap-3 mb-4">
                        <a href="{{ route('portal.login') }}" class="btn btn-success btn-lg px-4 py-3 rounded-pill fw-bold shadow-sm d-flex align-items-center gap-2">
                            <i class="bx bx-id-card fs-4"></i> Acceso Portal Socios
                        </a>
                        <a href="#membresias" class="btn btn-outline-secondary btn-lg px-4 py-3 rounded-pill fw-semibold">
                            Ver Membresías
                        </a>
                    </div>
                    <div class="d-flex align-items-center gap-4 text-muted small fw-medium">
                        <span><i class="bx bx-check-circle text-success fs-5 align-middle me-1"></i> Canchas Iluminadas</span>
                        <span><i class="bx bx-check-circle text-success fs-5 align-middle me-1"></i> Ambiente 100% Familiar</span>
                        <span><i class="bx bx-check-circle text-success fs-5 align-middle me-1"></i> Clases y Torneos</span>
                    </div>
                </div>

                <!-- Hero Image Emblem Showcase -->
                <div class="col-lg-5 text-center">
                    <div class="p-3 d-inline-flex align-items-center justify-content-center bg-white rounded-circle shadow-lg border" style="width: 320px; height: 320px; max-width: 88vw; max-height: 88vw;">
                        <img src="{{ asset('assets/img/branding/logo.png') }}" 
                             alt="Emblema Oficial Club Social Petrolero Polanco" 
                             class="img-fluid" 
                             style="width: 240px; height: 240px; object-fit: contain;" />
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Bar -->
    <div class="container">
        <div class="stats-bar p-4">
            <div class="row text-center g-4">
                <div class="col-6 col-md-3 border-end">
                    <h2 class="fw-bold text-dark mb-0 brand-font">+1,500</h2>
                    <span class="text-muted small">Socios y Familias Activas</span>
                </div>
                <div class="col-6 col-md-3 border-end">
                    <h2 class="fw-bold text-success mb-0 brand-font">8</h2>
                    <span class="text-muted small">Canchas de Tenis y Pádel</span>
                </div>
                <div class="col-6 col-md-3 border-end">
                    <h2 class="fw-bold text-dark mb-0 brand-font">2</h2>
                    <span class="text-muted small">Piscinas Semiolímpicas</span>
                </div>
                <div class="col-6 col-md-3">
                    <h2 class="fw-bold mb-0 brand-font" style="color: #c9a84c;">50+</h2>
                    <span class="text-muted small">Años de Historia y Tradición</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Instalaciones Section -->
    <section id="instalaciones" class="py-5 mt-5">
        <div class="container py-4">
            <div class="text-center mb-5">
                <span class="text-success fw-bold text-uppercase small tracking-wide">Nuestras Áreas</span>
                <h2 class="fw-bold text-dark display-6 mt-1">Instalaciones de Primer Nivel</h2>
                <p class="text-muted mx-auto" style="max-width: 600px;">
                    Espacios diseñados para el desarrollo deportivo, el bienestar físico y la convivencia de nuestros socios.
                </p>
            </div>

            <div class="row g-4">
                <div class="col-md-6 col-lg-4">
                    <div class="facility-card p-4">
                        <div class="facility-icon-wrapper">
                            <i class="bx bx-tennis-ball"></i>
                        </div>
                        <h4 class="fw-bold text-dark mb-2">Tenis & Pádel</h4>
                        <p class="text-muted small mb-0">
                            Canchas reglamentarias de arcilla y pasto sintético iluminadas para juego nocturno. Sede del torneo Open Polanco y clínicas para todas las edades.
                        </p>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4">
                    <div class="facility-card p-4">
                        <div class="facility-icon-wrapper">
                            <i class="bx bx-swim"></i>
                        </div>
                        <h4 class="fw-bold text-dark mb-2">Complejo Acuático</h4>
                        <p class="text-muted small mb-0">
                            Piscina semiolímpica para entrenamiento y natación libre, área de recreación familiar, zona de asoleadero y chapoteadero para los más pequeños.
                        </p>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4">
                    <div class="facility-card p-4">
                        <div class="facility-icon-wrapper">
                            <i class="bx bx-football"></i>
                        </div>
                        <h4 class="fw-bold text-dark mb-2">Fútbol, Racquet & Frontón</h4>
                        <p class="text-muted small mb-0">
                            Canchas de césped natural para fútbol infantil y senior, así como pabellones cerrados para racquetball y pelota frontón tradicional.
                        </p>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4">
                    <div class="facility-card p-4">
                        <div class="facility-icon-wrapper">
                            <i class="bx bx-dumbbell"></i>
                        </div>
                        <h4 class="fw-bold text-dark mb-2">Gimnasio & Fitness</h4>
                        <p class="text-muted small mb-0">
                            Área de pesas libres, máquinas de cardio de alta gama, salas para clases grupales de spinning, pilates y entrenadores personalizados certificados.
                        </p>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4">
                    <div class="facility-card p-4">
                        <div class="facility-icon-wrapper">
                            <i class="bx bx-restaurant"></i>
                        </div>
                        <h4 class="fw-bold text-dark mb-2">Restaurante & Terraza Club</h4>
                        <p class="text-muted small mb-0">
                            Exclusivo servicio gastronómico, parrillas, bar lounge y áreas sociales donde celebrar con amigos y familia con vistas panorámicas al club.
                        </p>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4">
                    <div class="facility-card p-4">
                        <div class="facility-icon-wrapper">
                            <i class="bx bx-party"></i>
                        </div>
                        <h4 class="fw-bold text-dark mb-2">Salones de Eventos Sociales</h4>
                        <p class="text-muted small mb-0">
                            Salones climatizados y equipados para recepciones, cumpleaños, conferencias y eventos privados con tarifas preferenciales para socios.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Membresías Section -->
    <section id="membresias" class="py-5 bg-light">
        <div class="container py-4">
            <div class="text-center mb-5">
                <span class="text-success fw-bold text-uppercase small tracking-wide">Planes de Afiliación</span>
                <h2 class="fw-bold text-dark display-6 mt-1">Categorías de Membresía</h2>
                <p class="text-muted mx-auto" style="max-width: 600px;">
                    Planes diseñados para adaptarse a sus necesidades familiares, individuales o deportivas.
                </p>
            </div>

            <div class="row g-4 justify-content-center">
                <!-- Familiar (Destacada) -->
                <div class="col-lg-4 col-md-6">
                    <div class="pricing-card featured p-4 h-100">
                        <span class="badge-popular">Más Solicitada</span>
                        <div class="text-center pt-3 mb-4">
                            <span class="badge bg-label-primary text-uppercase fw-bold px-3 py-1 mb-2">Categoría Familiar</span>
                            <h2 class="fw-bold text-dark mb-0 display-5">$120.00 <small class="fs-6 text-muted fw-normal">/ mes</small></h2>
                            <p class="text-muted small mt-1">Para toda la familia</p>
                        </div>
                        <ul class="list-unstyled mb-4 small d-flex flex-column gap-2">
                            <li class="d-flex align-items-center"><i class="bx bx-check text-success fs-5 me-2"></i> Incluye titular, cónyuge e hijos menores</li>
                            <li class="d-flex align-items-center"><i class="bx bx-check text-success fs-5 me-2"></i> Acceso ilimitado a todas las canchas</li>
                            <li class="d-flex align-items-center"><i class="bx bx-check text-success fs-5 me-2"></i> Uso de piscinas y áreas recreativas</li>
                            <li class="d-flex align-items-center"><i class="bx bx-check text-success fs-5 me-2"></i> Portal de socio con pagos QR y tarjeta</li>
                            <li class="d-flex align-items-center"><i class="bx bx-check text-success fs-5 me-2"></i> Descuentos en alquiler de salones</li>
                        </ul>
                        <a href="#contacto" class="btn btn-polanco w-100 py-2">Solicitar Membresía</a>
                    </div>
                </div>

                <!-- VIP -->
                <div class="col-lg-4 col-md-6">
                    <div class="pricing-card p-4 h-100" style="border-top: 4px solid #c9a84c;">
                        <div class="text-center pt-3 mb-4">
                            <span class="badge bg-warning text-dark text-uppercase fw-bold px-3 py-1 mb-2">Categoría VIP</span>
                            <h2 class="fw-bold text-dark mb-0 display-5" style="color:#c9a84c !important;">$180.00 <small class="fs-6 text-muted fw-normal">/ mes</small></h2>
                            <p class="text-muted small mt-1">Experiencia exclusiva total</p>
                        </div>
                        <ul class="list-unstyled mb-4 small d-flex flex-column gap-2">
                            <li class="d-flex align-items-center"><i class="bx bx-check text-success fs-5 me-2"></i> Todos los beneficios familiares incluidos</li>
                            <li class="d-flex align-items-center"><i class="bx bx-check text-success fs-5 me-2"></i> Reserva prioritaria en tenis y pádel</li>
                            <li class="d-flex align-items-center"><i class="bx bx-check text-success fs-5 me-2"></i> Lockers privados y toallas en piscina</li>
                            <li class="d-flex align-items-center"><i class="bx bx-check text-success fs-5 me-2"></i> Pases de cortesía para invitados al mes</li>
                            <li class="d-flex align-items-center"><i class="bx bx-check text-success fs-5 me-2"></i> Atención personalizada de recepción</li>
                        </ul>
                        <a href="#contacto" class="btn btn-gold w-100 py-2">Solicitar Membresía VIP</a>
                    </div>
                </div>

                <!-- Individual / Junior -->
                <div class="col-lg-4 col-md-6">
                    <div class="pricing-card p-4 h-100">
                        <div class="text-center pt-3 mb-4">
                            <span class="badge bg-secondary text-uppercase fw-bold px-3 py-1 mb-2">Individual / Junior</span>
                            <h2 class="fw-bold text-dark mb-0 display-5">$90.00 <small class="fs-6 text-muted fw-normal">/ mes</small></h2>
                            <p class="text-muted small mt-1">(Junior hasta 25 años: $65.00/mes)</p>
                        </div>
                        <ul class="list-unstyled mb-4 small d-flex flex-column gap-2">
                            <li class="d-flex align-items-center"><i class="bx bx-check text-success fs-5 me-2"></i> Membresía personal individual</li>
                            <li class="d-flex align-items-center"><i class="bx bx-check text-success fs-5 me-2"></i> Acceso completo a gimnasio y canchas</li>
                            <li class="d-flex align-items-center"><i class="bx bx-check text-success fs-5 me-2"></i> Participación en ligas y torneos</li>
                            <li class="d-flex align-items-center"><i class="bx bx-check text-success fs-5 me-2"></i> Portal de socio y pagos en línea</li>
                            <li class="d-flex align-items-center"><i class="bx bx-check text-success fs-5 me-2"></i> Acceso a restaurante y bar lounge</li>
                        </ul>
                        <a href="#contacto" class="btn btn-outline-success w-100 py-2">Solicitar Información</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Banner Portal de Socios -->
    <section class="py-5">
        <div class="container py-2">
            <div class="portal-banner shadow-lg">
                <div class="row align-items-center g-4">
                    <div class="col-lg-8">
                        <span class="badge bg-white text-dark text-uppercase fw-bold mb-3 px-3 py-1">Para Socios Registrados</span>
                        <h2 class="text-white fw-bold mb-2">Acceda a su Portal de Socio en Línea</h2>
                        <p class="text-white-50 mb-0" style="font-size: 1.05rem; line-height: 1.6;">
                            Sin contraseñas difíciles: ingrese únicamente con su <strong>Código de Socio</strong> y <strong>Fecha de Nacimiento</strong>. Consulte su historial, liquide su cuota mensual al instante con <strong>QR Dinámico o Tarjeta</strong> y descargue sus recibos oficiales.
                        </p>
                    </div>
                    <div class="col-lg-4 text-lg-end text-center">
                        <a href="{{ route('portal.login') }}" class="btn btn-gold py-3 px-4 fw-bold fs-6">
                            <i class="bx bx-id-card me-1"></i> Entrar al Portal de Socios
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Demostración en Vivo Standalone (Versión Beta para Vercel) -->
    <section class="py-5 bg-white border-top border-bottom" id="demostracion-beta">
        <div class="container py-3">
            <div class="text-center mb-5">
                <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill fw-bold text-uppercase small mb-2 border border-success border-opacity-25">
                    <i class="bx bx-bolt-circle me-1"></i> Demostración en Vivo • Versión Beta Standalone
                </span>
                <h2 class="display-6 fw-bold text-dark mb-2">Prueba el Sistema de Pagos y Consulta Aquí Mismo</h2>
                <p class="text-muted mx-auto" style="max-width: 650px;">
                    Todos los datos funcionan en la misma página y en el sistema integrado sin depender de base de datos local ni servidor externo.
                </p>
            </div>

            <div class="row g-4 justify-content-center align-items-stretch">
                <!-- Panel Interactivo de Socio -->
                <div class="col-lg-7">
                    <div class="card h-100 shadow-sm border rounded-4 overflow-hidden">
                        <div class="card-header bg-success text-white py-3 d-flex justify-content-between align-items-center">
                            <span class="fw-bold fs-6"><i class="bx bx-id-card me-1"></i> Simulador de Consulta de Socio</span>
                            <span class="badge bg-white text-success fw-bold">100% Funcional</span>
                        </div>
                        <div class="card-body p-4">
                            <label class="form-label text-muted small fw-semibold">Seleccione un socio registrado para ver sus datos en vivo:</label>
                            <div class="d-flex flex-wrap gap-2 mb-4">
                                <button type="button" class="btn btn-outline-success btn-sm rounded-pill active demo-btn" onclick="selectDemoSocio('carlos', this)">
                                    <i class="bx bx-user me-1"></i> Carlos Mendoza (VIP)
                                </button>
                                <button type="button" class="btn btn-outline-secondary btn-sm rounded-pill demo-btn" onclick="selectDemoSocio('mariana', this)">
                                    <i class="bx bx-user me-1"></i> Mariana Silva (Familiar)
                                </button>
                                <button type="button" class="btn btn-outline-danger btn-sm rounded-pill demo-btn" onclick="selectDemoSocio('rodrigo', this)">
                                    <i class="bx bx-error me-1"></i> Rodrigo Morales (Moroso)
                                </button>
                                <button type="button" class="btn btn-outline-info btn-sm rounded-pill demo-btn" onclick="selectDemoSocio('sofia', this)">
                                    <i class="bx bx-cake me-1"></i> Sofía Benítez (Junior)
                                </button>
                            </div>

                            <!-- Tarjeta de Datos del Socio -->
                            <div class="bg-light p-3 rounded-3 mb-4 border">
                                <div class="d-flex align-items-center justify-content-between mb-3 flex-wrap gap-2">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="avatar avatar-lg rounded-circle bg-success text-white d-flex align-items-center justify-content-center fs-3 fw-bold shadow-sm" id="demoAvatar" style="width: 50px; height: 50px;">
                                            CM
                                        </div>
                                        <div>
                                            <h5 class="fw-bold mb-0 text-dark" id="demoNombre">Carlos Mendoza</h5>
                                            <small class="text-muted" id="demoCodigo">Código de Acceso: <code>CP-789012</code></small>
                                        </div>
                                    </div>
                                    <div id="demoStatusBadge">
                                        <span class="badge bg-success fs-7 px-3 py-2 rounded-pill"><i class="bx bx-check-circle me-1"></i> Membresía Al Día</span>
                                    </div>
                                </div>
                                <hr class="my-2 text-muted opacity-25">
                                <div class="row g-2 text-center pt-2">
                                    <div class="col-4 border-end">
                                        <span class="text-muted d-block small">Categoría</span>
                                        <strong class="text-dark" id="demoCategoria">VIP</strong>
                                    </div>
                                    <div class="col-4 border-end">
                                        <span class="text-muted d-block small">Cuota Mensual</span>
                                        <strong class="text-success fs-5" id="demoCuota">$180.00</strong>
                                    </div>
                                    <div class="col-4">
                                        <span class="text-muted d-block small">Vencimiento</span>
                                        <strong class="text-dark small" id="demoVencimiento">15/10/2026</strong>
                                    </div>
                                </div>
                            </div>

                            <!-- Botones de Acción Inmediata -->
                            <div class="d-flex flex-wrap gap-2 align-items-center justify-content-between">
                                <button type="button" class="btn btn-success fw-bold px-3 py-2 rounded-pill shadow-sm" onclick="openQrModal()">
                                    <i class="bx bx-qr-scan me-1"></i> Pagar Cuota con QR Dinámico
                                </button>
                                <form action="{{ route('portal.login.submit') }}" method="POST" class="d-inline" id="portalDirectForm">
                                    @csrf
                                    <input type="hidden" name="codigo" id="portalInputCodigo" value="CP-789012">
                                    <input type="hidden" name="fecha_nacimiento" id="portalInputFecha" value="1985-06-15">
                                    <button type="submit" class="btn btn-outline-success fw-semibold px-3 py-2 rounded-pill">
                                        <i class="bx bx-log-in-circle me-1"></i> Entrar al Portal con este Socio
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Panel de Acceso Administrativo Beta -->
                <div class="col-lg-5">
                    <div class="card h-100 shadow-sm border rounded-4 overflow-hidden">
                        <div class="card-header bg-dark text-white py-3 d-flex justify-content-between align-items-center">
                            <span class="fw-bold fs-6"><i class="bx bx-shield-quarter me-1"></i> Acceso al Panel de Control</span>
                            <span class="badge bg-warning text-dark fw-bold">1-Clic Demo</span>
                        </div>
                        <div class="card-body p-4 d-flex flex-column justify-content-between">
                            <div>
                                <p class="text-muted small mb-3">
                                    La aplicación incluye su base de datos integrada lista para desplegar en Vercel. Ingrese con 1 solo clic a los roles del sistema:
                                </p>

                                <div class="p-3 border rounded-3 mb-3 bg-light">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <strong class="text-dark"><i class="bx bx-shield-alt text-primary me-1"></i> Administrador General</strong>
                                        <span class="badge bg-primary bg-opacity-10 text-primary">Acceso Total</span>
                                    </div>
                                    <small class="text-muted d-block">Usuario: <code>admin@clubpolanco.com</code></small>
                                    <small class="text-muted d-block mb-2">Clave: <code>admin123</code></small>
                                    <form action="{{ route('login.submit') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="email" value="admin@clubpolanco.com">
                                        <input type="hidden" name="password" value="admin123">
                                        <button type="submit" class="btn btn-sm btn-primary w-100 rounded-pill fw-semibold">
                                            <i class="bx bx-log-in me-1"></i> Entrar como Administrador
                                        </button>
                                    </form>
                                </div>

                                <div class="p-3 border rounded-3 bg-light">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <strong class="text-dark"><i class="bx bx-user-pin text-info me-1"></i> Operador de Caja / CRM</strong>
                                        <span class="badge bg-info bg-opacity-10 text-info">Caja y WhatsApp</span>
                                    </div>
                                    <small class="text-muted d-block">Usuario: <code>operador@clubpolanco.com</code></small>
                                    <small class="text-muted d-block mb-2">Clave: <code>operador123</code></small>
                                    <form action="{{ route('login.submit') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="email" value="operador@clubpolanco.com">
                                        <input type="hidden" name="password" value="operador123">
                                        <button type="submit" class="btn btn-sm btn-outline-dark w-100 rounded-pill fw-semibold">
                                            <i class="bx bx-log-in me-1"></i> Entrar como Operador
                                        </button>
                                    </form>
                                </div>
                            </div>

                            <div class="pt-3 text-center">
                                <small class="text-muted"><i class="bx bx-check-circle text-success me-1"></i> Base de datos SQLite embebida, autónoma y lista para Vercel.</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contacto & Ubicación Section -->
    <section id="contacto" class="py-5 bg-light">
        <div class="container py-4">
            <div class="row g-5">
                <div class="col-lg-6">
                    <span class="text-success fw-bold text-uppercase small tracking-wide">Contáctenos</span>
                    <h2 class="fw-bold text-dark display-6 mt-1 mb-3">¿Desea Afiliarse al Club?</h2>
                    <p class="text-muted mb-4">
                        Visítenos en nuestras instalaciones o escríbanos por WhatsApp para coordinar un recorrido guiado por el club y conocer los requisitos de membresía.
                    </p>

                    <div class="d-flex flex-column gap-3 mb-4">
                        <div class="d-flex align-items-center gap-3">
                            <div class="avatar avatar-md rounded bg-white shadow-sm d-flex align-items-center justify-content-center text-success fs-4">
                                <i class="bx bx-map"></i>
                            </div>
                            <div>
                                <span class="fw-semibold text-dark d-block">Ubicación</span>
                                <small class="text-muted">Av. Juan Pablo II N°3300, Santa Cruz de la Sierra</small>
                            </div>
                        </div>

                        <div class="d-flex align-items-center gap-3">
                            <div class="avatar avatar-md rounded bg-white shadow-sm d-flex align-items-center justify-content-center text-success fs-4">
                                <i class="bx bxl-whatsapp"></i>
                            </div>
                            <div>
                                <span class="fw-semibold text-dark d-block">WhatsApp Oficial</span>
                                <a href="https://wa.me/59169250075?text=Hola%20Club%20Polanco,%20deseo%20solicitar%20información%20sobre%20membresías." target="_blank" class="text-success text-decoration-none fw-semibold">
                                    +591 69250075 <small class="text-muted">(Clic para chatear)</small>
                                </a>
                            </div>
                        </div>

                        <div class="d-flex align-items-center gap-3">
                            <div class="avatar avatar-md rounded bg-white shadow-sm d-flex align-items-center justify-content-center text-success fs-4">
                                <i class="bx bx-envelope"></i>
                            </div>
                            <div>
                                <span class="fw-semibold text-dark d-block">Correo Electrónico</span>
                                <small class="text-muted">clubpolancooficial@gmail.com / recepcion@clubpolanco.com</small>
                            </div>
                        </div>

                        <div class="d-flex align-items-center gap-3">
                            <div class="avatar avatar-md rounded bg-white shadow-sm d-flex align-items-center justify-content-center text-primary fs-4">
                                <i class="bx bxl-facebook-circle"></i>
                            </div>
                            <div>
                                <span class="fw-semibold text-dark d-block">Página Oficial de Facebook</span>
                                <a href="https://www.facebook.com/ClubPolancoOficial/" target="_blank" class="text-primary text-decoration-none small">
                                    facebook.com/ClubPolancoOficial
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contact Form to WhatsApp -->
                <div class="col-lg-6">
                    <div class="card p-4 border-0 shadow-sm rounded-4 bg-white">
                        <h4 class="fw-bold text-dark mb-1">Solicitar Información</h4>
                        <p class="text-muted small mb-4">Complete los datos para comunicarnos directamente con usted vía WhatsApp.</p>

                        <form id="contactForm" onsubmit="sendToWhatsApp(event)">
                            <div class="mb-3">
                                <label class="form-label small fw-semibold" for="inputNombre">Nombre y Apellido</label>
                                <input type="text" class="form-control" id="inputNombre" placeholder="Ej. Roberto Mendoza" required />
                            </div>

                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <label class="form-label small fw-semibold" for="inputTel">Teléfono / WhatsApp</label>
                                    <input type="text" class="form-control" id="inputTel" placeholder="Ej. 69250075" required />
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-semibold" for="selectCat">Membresía de Interés</label>
                                    <select class="form-select" id="selectCat">
                                        <option value="Familiar">Familiar</option>
                                        <option value="VIP">VIP</option>
                                        <option value="Individual">Individual</option>
                                        <option value="Junior">Junior</option>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label small fw-semibold" for="inputMensaje">Consulta o Mensaje Adicional</label>
                                <textarea class="form-control" id="inputMensaje" rows="3" placeholder="¿Desea agendar una visita o consultar tarifas?"></textarea>
                            </div>

                            <button type="submit" class="btn btn-success w-100 py-3 fw-bold shadow-sm" style="background-color: #25D366; border-color: #25D366;">
                                <i class="bx bxl-whatsapp me-1 fs-5 align-middle"></i> Enviar Mensaje por WhatsApp
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="landing-footer">
        <div class="container">
            <div class="row g-4 mb-5">
                <div class="col-lg-4">
                    <img src="{{ asset('assets/img/branding/logo.png') }}" alt="Club Social Petrolero Polanco" width="56" height="56" class="rounded-circle mb-3 shadow bg-white p-1" style="object-fit: contain;" />
                    <h5 class="text-white fw-bold mb-2">Club Social Petrolero Polanco</h5>
                    <p class="small text-muted mb-3" style="line-height: 1.6;">
                        Institución social, deportiva y cultural sin fines de lucro. Dedicada a fomentar la actividad física, la sana recreación y el bienestar familiar.
                    </p>
                    <a href="https://www.facebook.com/ClubPolancoOficial/" target="_blank" class="btn btn-sm btn-outline-light px-3 py-1">
                        <i class="bx bxl-facebook me-1"></i> Seguir en Facebook
                    </a>
                </div>

                <div class="col-lg-3 col-md-4">
                    <h6 class="text-white fw-bold mb-3 text-uppercase small">Instalaciones</h6>
                    <a href="#instalaciones" class="footer-link">Canchas de Tenis & Pádel</a>
                    <a href="#instalaciones" class="footer-link">Piscina Semiolímpica</a>
                    <a href="#instalaciones" class="footer-link">Canchas de Fútbol & Raquet</a>
                    <a href="#instalaciones" class="footer-link">Gimnasio & Centro Fitness</a>
                    <a href="#instalaciones" class="footer-link">Restaurante & Terraza Club</a>
                </div>

                <div class="col-lg-2 col-md-4">
                    <h6 class="text-white fw-bold mb-3 text-uppercase small">Accesos</h6>
                    <a href="{{ route('portal.login') }}" class="footer-link">Portal de Socios</a>
                    <a href="{{ route('portal.login') }}" class="footer-link">Pagos QR Dinámico</a>
                    <a href="{{ route('login') }}" class="footer-link">Panel Administrativo</a>
                    <a href="#contacto" class="footer-link">Contacto & Ubicación</a>
                </div>

                <div class="col-lg-3 col-md-4">
                    <h6 class="text-white fw-bold mb-3 text-uppercase small">Atención al Socio</h6>
                    <p class="small text-muted mb-1"><i class="bx bx-time me-1 text-success"></i> Martes a Domingo: 06:00 - 22:00</p>
                    <p class="small text-muted mb-1"><i class="bx bx-phone me-1 text-success"></i> +591 69250075</p>
                    <p class="small text-muted mb-0"><i class="bx bx-map me-1 text-success"></i> Av. Juan Pablo II N°3300</p>
                </div>
            </div>

            <div class="border-top pt-4 text-center small text-muted border-secondary">
                <p class="mb-0">© {{ date('Y') }} <strong>Club Social Petrolero Polanco</strong>. Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>

    <!-- Modal QR Demo en la misma página -->
    <div class="modal fade" id="modalQrDemo" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 border-0 shadow">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title fw-bold"><i class="bx bx-qr-scan me-1"></i> Cobro de Cuota con QR Dinámico</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center p-4">
                    <p class="text-muted small mb-2">Escanee este código desde la app de su banco o billetera móvil para liquidar su cuota:</p>
                    <div class="p-3 bg-light border rounded-3 d-inline-block mb-3 shadow-sm">
                        <img id="qrModalImg" src="https://api.qrserver.com/v1/create-qr-code/?size=180x180&data=CLUBPOLANCO-CP-789012-180USD" 
                             alt="QR de Pago" width="180" height="180" class="img-fluid" />
                    </div>
                    <h4 class="fw-bold text-success mb-1" id="qrModalMonto">$180.00 USD</h4>
                    <p class="small text-muted mb-3" id="qrModalConcepto">Concepto: Mantenimiento e Instalaciones • Carlos Mendoza</p>
                    
                    <div id="qrAlertExito" class="alert alert-success d-none py-2 small fw-semibold">
                        <i class="bx bx-check-circle me-1"></i> ¡Pago procesado con éxito! Estado de cuenta actualizado al día.
                    </div>

                    <div class="d-flex gap-2 justify-content-center">
                        <button type="button" class="btn btn-success px-4 rounded-pill fw-bold" onclick="simularPagoQrExitoso()">
                            <i class="bx bx-check me-1"></i> Simular Confirmación de Pago
                        </button>
                        <button type="button" class="btn btn-outline-secondary px-3 rounded-pill" data-bs-dismiss="modal">
                            Cerrar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    const demoSocios = {
        carlos: {
            nombre: 'Carlos Mendoza',
            avatar: 'CM',
            codigo: 'CP-789012',
            fecha: '1985-06-15',
            categoria: 'VIP',
            cuota: '$180.00',
            montoRaw: '180USD',
            vencimiento: '15/10/2026',
            badge: '<span class="badge bg-success fs-7 px-3 py-2 rounded-pill"><i class="bx bx-check-circle me-1"></i> Membresía Al Día</span>'
        },
        mariana: {
            nombre: 'Mariana Silva',
            avatar: 'MS',
            codigo: 'CP-456789',
            fecha: '1992-11-20',
            categoria: 'Familiar',
            cuota: '$120.00',
            montoRaw: '120USD',
            vencimiento: '20/10/2026',
            badge: '<span class="badge bg-success fs-7 px-3 py-2 rounded-pill"><i class="bx bx-check-circle me-1"></i> Membresía Al Día</span>'
        },
        rodrigo: {
            nombre: 'Rodrigo Morales',
            avatar: 'RM',
            codigo: 'CP-123456',
            fecha: '1978-03-10',
            categoria: 'Individual',
            cuota: '$90.00',
            montoRaw: '90USD',
            vencimiento: '10/09/2026 (Vencido)',
            badge: '<span class="badge bg-danger fs-7 px-3 py-2 rounded-pill"><i class="bx bx-error-circle me-1"></i> Cuota Pendiente / Moroso</span>'
        },
        sofia: {
            nombre: 'Sofía Benítez',
            avatar: 'SB',
            codigo: 'CP-334455',
            fecha: '2001-09-12',
            categoria: 'Junior',
            cuota: '$65.00',
            montoRaw: '65USD',
            vencimiento: '12/10/2026',
            badge: '<span class="badge bg-info fs-7 px-3 py-2 rounded-pill"><i class="bx bx-cake me-1"></i> ¡Cumpleañera del Mes!</span>'
        }
    };

    let socioActual = demoSocios.carlos;

    function selectDemoSocio(key, btn) {
        document.querySelectorAll('.demo-btn').forEach(b => {
            b.classList.remove('active', 'btn-success');
            if(!b.classList.contains('btn-outline-danger') && !b.classList.contains('btn-outline-info')) {
                b.classList.add('btn-outline-secondary');
            }
        });
        if(btn) {
            btn.classList.add('active');
            btn.classList.remove('btn-outline-secondary');
        }

        const s = demoSocios[key];
        socioActual = s;

        document.getElementById('demoAvatar').innerText = s.avatar;
        document.getElementById('demoNombre').innerText = s.nombre;
        document.getElementById('demoCodigo').innerHTML = `Código de Acceso: <code>${s.codigo}</code>`;
        document.getElementById('demoStatusBadge').innerHTML = s.badge;
        document.getElementById('demoCategoria').innerText = s.categoria;
        document.getElementById('demoCuota').innerText = s.cuota;
        document.getElementById('demoVencimiento').innerText = s.vencimiento;
        
        document.getElementById('portalInputCodigo').value = s.codigo;
        document.getElementById('portalInputFecha').value = s.fecha;
    }

    function openQrModal() {
        document.getElementById('qrModalMonto').innerText = socioActual.cuota + ' USD';
        document.getElementById('qrModalConcepto').innerText = `Concepto: Mantenimiento e Instalaciones • ${socioActual.nombre}`;
        document.getElementById('qrModalImg').src = `https://api.qrserver.com/v1/create-qr-code/?size=180x180&data=CLUBPOLANCO-${socioActual.codigo}-${socioActual.montoRaw}`;
        document.getElementById('qrAlertExito').classList.add('d-none');
        
        const modal = new bootstrap.Modal(document.getElementById('modalQrDemo'));
        modal.show();
    }

    function simularPagoQrExitoso() {
        document.getElementById('qrAlertExito').classList.remove('d-none');
        socioActual.badge = '<span class="badge bg-success fs-7 px-3 py-2 rounded-pill"><i class="bx bx-check-circle me-1"></i> ¡Pago Recién Completado!</span>';
        document.getElementById('demoStatusBadge').innerHTML = socioActual.badge;
        document.getElementById('demoVencimiento').innerText = '15/11/2026';
    }

    function sendToWhatsApp(e) {
        e.preventDefault();
        const nombre = document.getElementById('inputNombre').value;
        const tel = document.getElementById('inputTel').value;
        const cat = document.getElementById('selectCat').value;
        const msg = document.getElementById('inputMensaje').value || 'Sin mensaje adicional';
        
        const texto = `Hola Club Polanco, mi nombre es ${nombre} (Tel: ${tel}). Me interesa la Membresía ${cat}. Mensaje: ${msg}`;
        const url = `https://wa.me/59169250075?text=${encodeURIComponent(texto)}`;
        window.open(url, '_blank');
    }
    </script>
</body>
</html>
