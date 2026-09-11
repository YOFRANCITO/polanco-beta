@extends('layouts/blankLayout')

@section('title', 'Acceso Portal de Socios - Club Polanco')

@section('page-style')
@vite(['resources/assets/vendor/scss/pages/page-auth.scss'])
<style>
    .portal-bg {
        background: radial-gradient(circle at top right, #e8f5e9, #f5f5f9 60%);
        min-height: 100vh;
    }
</style>
@endsection

@section('content')
<div class="portal-bg d-flex align-items-center justify-content-center py-5">
    <div class="container" style="max-width: 460px;">
        <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
            <!-- Header Banner -->
            <div class="p-4 text-center text-white" style="background: linear-gradient(135deg, #1a7a3c 0%, #0d4a23 100%);">
                <div class="mb-2 d-inline-block rounded-circle shadow-sm" style="width: 76px; height: 76px;">
                    @include('_partials.macros', ['width' => 76])
                </div>
                <p class="text-white-50 mb-0 small text-uppercase" style="letter-spacing: 1px;">Portal Exclusivo de Socios</p>
            </div>

            <div class="card-body p-4">
                <div class="text-center mb-4">
                    <h5 class="fw-bold mb-1" style="color: #2b3d4f;">Bienvenido a su Club</h5>
                    <p class="text-muted small">
                        Ingrese con su <strong>Código de Acceso</strong> proporcionado por el club y su <strong>Fecha de Nacimiento</strong>.
                    </p>
                </div>

                @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show py-2" role="alert">
                    <small><i class="bx bx-error-circle me-1"></i> {{ session('error') }}</small>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show py-2" role="alert">
                    <small><i class="bx bx-error-circle me-1"></i> {{ $errors->first() }}</small>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                <form action="{{ route('portal.login.submit') }}" method="POST" class="mb-3">
                    @csrf
                    <div class="mb-3">
                        <label for="codigo_acceso" class="form-label fw-semibold">
                            <i class="bx bx-barcode me-1 text-primary"></i> Código de Acceso
                        </label>
                        <div class="input-group input-group-merge">
                            <span class="input-group-text"><i class="bx bx-id-card"></i></span>
                            <input type="text" 
                                   class="form-control text-uppercase fw-bold letter-spacing-1 @error('codigo_acceso') is-invalid @enderror" 
                                   id="codigo_acceso" 
                                   name="codigo_acceso" 
                                   value="{{ old('codigo_acceso') }}" 
                                   placeholder="Ej: CP-789012" 
                                   required 
                                   autofocus />
                        </div>
                        <div class="form-text small">Código de 8 caracteres asignado al registrar su membresía.</div>
                    </div>

                    <div class="mb-4">
                        <label for="fecha_nacimiento" class="form-label fw-semibold">
                            <i class="bx bx-cake me-1 text-primary"></i> Fecha de Nacimiento
                        </label>
                        <div class="input-group input-group-merge">
                            <span class="input-group-text"><i class="bx bx-calendar"></i></span>
                            <input type="date" 
                                   class="form-control @error('fecha_nacimiento') is-invalid @enderror" 
                                   id="fecha_nacimiento" 
                                   name="fecha_nacimiento" 
                                   value="{{ old('fecha_nacimiento') }}" 
                                   required />
                        </div>
                    </div>

                    <button class="btn btn-primary d-grid w-100 py-2 fw-bold shadow-sm" type="submit" style="background-color: #1a7a3c; border-color: #1a7a3c;">
                        <i class="bx bx-check-shield me-1"></i> Ingresar al Portal
                    </button>
                </form>

                <!-- Demo Quick Access -->
                @if(isset($demoSocios) && $demoSocios->count() > 0)
                <div class="p-3 rounded-3 mb-3 bg-light border">
                    <p class="small fw-semibold mb-2 text-muted text-center">
                        <i class="bx bx-test-tube me-1 text-primary"></i> Datos de Socios para Pruebas:
                    </p>
                    <div class="d-flex flex-column gap-1">
                        @foreach($demoSocios as $ds)
                        <button type="button" class="btn btn-xs btn-outline-secondary text-start py-1 px-2 d-flex justify-content-between align-items-center" 
                                onclick="fillSocio('{{ $ds->codigo_acceso }}', '{{ is_object($ds->fecha_nacimiento) ? $ds->fecha_nacimiento->format('Y-m-d') : substr($ds->fecha_nacimiento, 0, 10) }}')">
                            <span><strong>{{ $ds->nombre_completo }}</strong> <small class="text-muted">({{ $ds->codigo_acceso }})</small></span>
                            <span class="badge {{ $ds->estado === 'activo' ? 'bg-label-success' : 'bg-label-warning' }}">{{ ucfirst($ds->estado) }}</span>
                        </button>
                        @endforeach
                    </div>
                </div>
                @endif

                <div class="text-center pt-2 border-top">
                    <span class="small text-muted">¿Eres personal administrativo?</span>
                    <a href="{{ route('login') }}" class="small fw-semibold text-primary d-block mt-1">
                        <i class="bx bx-shield-quarter me-1"></i> Ingresar al Panel de Gestión
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function fillSocio(code, bday) {
    document.getElementById('codigo_acceso').value = code;
    document.getElementById('fecha_nacimiento').value = bday;
}
</script>
@endsection
