@extends('layouts/blankLayout')

@section('title', 'Iniciar Sesión - Club Polanco')

@section('page-style')
@vite(['resources/assets/vendor/scss/pages/page-auth.scss'])
@endsection

@section('content')
<div class="container-xxl">
    <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner">
            <!-- Card Login -->
            <div class="card px-sm-6 px-0 shadow-sm border-0">
                <div class="card-body">
                    <!-- Logo -->
                    <div class="app-brand justify-content-center mb-4">
                        <a href="{{ url('/') }}" class="app-brand-link justify-content-center">
                            <span class="app-brand-logo demo">@include('_partials.macros', ['width' => 80])</span>
                        </a>
                    </div>
                    <!-- /Logo -->
                    <h4 class="mb-1 text-center fw-bold">Panel Administrativo 👋</h4>
                    <p class="mb-4 text-center text-muted small">Ingrese sus credenciales de usuario del sistema</p>

                    @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show py-2" role="alert">
                        <small>{{ session('success') }}</small>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif

                    @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show py-2" role="alert">
                        <small>{{ $errors->first() }}</small>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif

                    <form id="formAuthentication" class="mb-3" action="{{ route('login.submit') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label">Usuario o Correo Electrónico</label>
                            <input type="text" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" placeholder="admin o admin@clubpolanco.com" autofocus required />
                        </div>
                        <div class="mb-3 form-password-toggle">
                            <label class="form-label" for="password">Contraseña</label>
                            <div class="input-group input-group-merge">
                                <input type="password" id="password" class="form-control" name="password" placeholder="············" required />
                                <span class="input-group-text cursor-pointer"><i class="icon-base bx bx-hide"></i></span>
                            </div>
                        </div>
                        <div class="mb-3 d-flex justify-content-between align-items-center">
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="checkbox" id="remember" name="remember" />
                                <label class="form-check-label small" for="remember">Recordarme</label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <button class="btn btn-primary d-grid w-100 py-2 fw-semibold" type="submit" style="background-color: #1a7a3c; border-color: #1a7a3c;">
                                <i class="bx bx-log-in me-1"></i> Iniciar Sesión
                            </button>
                        </div>
                    </form>

                    <!-- Quick Fill for Testing -->
                    <div class="p-3 rounded mb-3" style="background-color: #f8faf8; border: 1px dashed #1a7a3c;">
                        <p class="small fw-semibold mb-2 text-muted text-center"><i class="bx bx-key me-1 text-primary"></i> Credenciales de Acceso Rápido:</p>
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-xs btn-outline-success w-50 py-1" onclick="quickFill('admin@clubpolanco.com', 'admin123')">
                                <i class="bx bx-shield-quarter"></i> Admin
                            </button>
                            <button type="button" class="btn btn-xs btn-outline-primary w-50 py-1" onclick="quickFill('operador@clubpolanco.com', 'operador123')">
                                <i class="bx bx-user-check"></i> Operador
                            </button>
                        </div>
                    </div>

                    <div class="text-center pt-2 border-top">
                        <span class="small text-muted">¿Eres socio del club?</span>
                        <a href="{{ route('portal.login') }}" class="small fw-semibold text-primary d-block mt-1">
                            <i class="bx bx-id-card me-1"></i> Acceder al Portal de Socios
                        </a>
                    </div>
                </div>
            </div>
            <!-- /Card Login -->
        </div>
    </div>
</div>

<script>
function quickFill(email, password) {
    document.getElementById('email').value = email;
    document.getElementById('password').value = password;
}
</script>
@endsection
