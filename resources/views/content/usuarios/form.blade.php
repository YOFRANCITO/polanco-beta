@extends('layouts/contentNavbarLayout')

@section('title', ($user->exists ? 'Editar' : 'Nuevo') . ' Usuario - Club Polanco')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm border-0">
            <div class="card-header d-flex justify-content-between align-items-center border-bottom pb-3">
                <h5 class="mb-0 fw-bold" style="color: #1a7a3c;">
                    <i class="bx {{ $user->exists ? 'bx-edit' : 'bx-user-plus' }} me-1"></i>
                    {{ $user->exists ? 'Editar Usuario: ' . $user->name : 'Crear Nuevo Usuario del Sistema' }}
                </h5>
                <a href="{{ route('usuarios.index') }}" class="btn btn-sm btn-outline-secondary">
                    <i class="bx bx-arrow-back me-1"></i> Volver al Listado
                </a>
            </div>

            <div class="card-body pt-4">
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

                <form method="POST" action="{{ $user->exists ? route('usuarios.update', $user) : route('usuarios.store') }}">
                    @csrf
                    @if($user->exists)
                        @method('PUT')
                    @endif

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label" for="name">Nombre Completo <span class="text-danger">*</span></label>
                            <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $user->name) }}" required placeholder="Ej. Juan Pérez">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="email">Correo Electrónico <span class="text-danger">*</span></label>
                            <input type="email" id="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required placeholder="usuario@clubpolanco.com">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="telefono">Teléfono / Móvil</label>
                            <input type="text" id="telefono" name="telefono" class="form-control" value="{{ old('telefono', $user->telefono) }}" placeholder="+52 55 1234 5678">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="role">Rol Funcional <span class="text-danger">*</span></label>
                            <select id="role" name="role" class="form-select" required>
                                <option value="operador" {{ old('role', $user->role) === 'operador' ? 'selected' : '' }}>
                                    Operador (Recepción, Socios, Cobros, WhatsApp)
                                </option>
                                <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>
                                    Administrador (Control Total del Sistema)
                                </option>
                            </select>
                            <div class="form-text small">Los administradores pueden gestionar usuarios y configuraciones críticas.</div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="estado">Estado de la Cuenta <span class="text-danger">*</span></label>
                            <select id="estado" name="estado" class="form-select" required>
                                <option value="activo" {{ old('estado', $user->estado ?? 'activo') === 'activo' ? 'selected' : '' }}>Activo</option>
                                <option value="inactivo" {{ old('estado', $user->estado) === 'inactivo' ? 'selected' : '' }}>Inactivo (Acceso Bloqueado)</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="password">
                                Contraseña {{ $user->exists ? '(Dejar en blanco para no cambiar)' : '*' }}
                            </label>
                            <input type="password" id="password" name="password" class="form-control" {{ $user->exists ? '' : 'required' }} placeholder="Mínimo 6 caracteres">
                        </div>

                        <div class="col-12 mt-4 pt-2 border-top d-flex justify-content-end gap-2">
                            <a href="{{ route('usuarios.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                            <button type="submit" class="btn btn-primary" style="background-color: #1a7a3c; border-color: #1a7a3c;">
                                <i class="bx bx-save me-1"></i> {{ $user->exists ? 'Guardar Cambios' : 'Registrar Usuario' }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
