@extends('layouts/contentNavbarLayout')

@section('title', 'Mi Perfil - Club Polanco')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <!-- User Card Info -->
        <div class="card mb-4 shadow-sm border-0">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="avatar avatar-xl me-4">
                        <span class="avatar-initial rounded-circle bg-label-primary fs-2 fw-bold">
                            {{ strtoupper(substr($user->name, 0, 2)) }}
                        </span>
                    </div>
                    <div>
                        <h4 class="mb-1 fw-bold">{{ $user->name }}</h4>
                        <div class="d-flex align-items-center gap-2">
                            <span class="badge {{ $user->role === 'admin' ? 'bg-label-danger' : 'bg-label-info' }} text-uppercase">
                                <i class="bx {{ $user->role === 'admin' ? 'bx-shield-quarter' : 'bx-user-check' }} me-1"></i>
                                {{ $user->role }}
                            </span>
                            <span class="text-muted small"><i class="bx bx-envelope me-1"></i> {{ $user->email }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Update Form -->
        <div class="card shadow-sm border-0">
            <div class="card-header border-bottom pb-3">
                <h5 class="mb-0 fw-bold" style="color: #1a7a3c;">
                    <i class="bx bx-cog me-1"></i> Configuración de Mi Cuenta
                </h5>
            </div>
            <div class="card-body pt-4">
                @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bx bx-check-circle me-1"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul class="mb-0 small">
                        @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                <form method="POST" action="{{ route('usuarios.perfil.update') }}">
                    @csrf
                    @method('PUT')

                    <h6 class="text-muted text-uppercase small fw-bold mb-3">Datos Personales</h6>
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label" for="name">Nombre Completo</label>
                            <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="email">Correo Electrónico</label>
                            <input type="email" id="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="telefono">Teléfono de Contacto</label>
                            <input type="text" id="telefono" name="telefono" class="form-control" value="{{ old('telefono', $user->telefono) }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Rol Asignado</label>
                            <input type="text" class="form-control" value="{{ ucfirst($user->role) }}" disabled readonly>
                        </div>
                    </div>

                    <h6 class="text-muted text-uppercase small fw-bold mb-3 border-top pt-3">Cambio de Contraseña (Opcional)</h6>
                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <label class="form-label" for="current_password">Contraseña Actual</label>
                            <input type="password" id="current_password" name="current_password" class="form-control" placeholder="••••••••">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label" for="new_password">Nueva Contraseña</label>
                            <input type="password" id="new_password" name="new_password" class="form-control" placeholder="Mínimo 6 caracteres">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label" for="new_password_confirmation">Confirmar Nueva Contraseña</label>
                            <input type="password" id="new_password_confirmation" name="new_password_confirmation" class="form-control" placeholder="••••••••">
                        </div>
                    </div>

                    <div class="border-top pt-3 text-end">
                        <button type="submit" class="btn btn-primary" style="background-color: #1a7a3c; border-color: #1a7a3c;">
                            <i class="bx bx-save me-1"></i> Actualizar Perfil
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
