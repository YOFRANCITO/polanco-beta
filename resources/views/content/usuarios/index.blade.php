@extends('layouts/contentNavbarLayout')

@section('title', 'Usuarios del Sistema - Club Polanco')

@section('content')
<div class="row g-4 mb-4">
    <!-- Header -->
    <div class="col-12 d-flex justify-content-between align-items-center">
        <div>
            <h4 class="fw-bold mb-1" style="color: #1a7a3c;">Usuarios del Sistema</h4>
            <p class="text-muted mb-0 small">Administración de accesos y roles funcionales del personal</p>
        </div>
        <a href="{{ route('usuarios.create') }}" class="btn btn-primary" style="background-color: #1a7a3c; border-color: #1a7a3c;">
            <i class="bx bx-plus me-1"></i> Nuevo Usuario
        </a>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
    <div class="col-12">
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bx bx-check-circle me-1"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
    @endif
    @if(session('error'))
    <div class="col-12">
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bx bx-error-circle me-1"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
    @endif

    <!-- KPI Cards -->
    <div class="col-sm-6 col-xl-3">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="fw-semibold d-block mb-1 text-muted">Total Usuarios</span>
                        <h3 class="card-title mb-0">{{ $kpis['total'] }}</h3>
                    </div>
                    <div class="avatar avatar-md">
                        <span class="avatar-initial rounded bg-label-primary">
                            <i class="bx bx-user-circle fs-3"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="fw-semibold d-block mb-1 text-muted">Administradores</span>
                        <h3 class="card-title mb-0 text-danger">{{ $kpis['admins'] }}</h3>
                    </div>
                    <div class="avatar avatar-md">
                        <span class="avatar-initial rounded bg-label-danger">
                            <i class="bx bx-shield-quarter fs-3"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="fw-semibold d-block mb-1 text-muted">Operadores</span>
                        <h3 class="card-title mb-0 text-info">{{ $kpis['operadores'] }}</h3>
                    </div>
                    <div class="avatar avatar-md">
                        <span class="avatar-initial rounded bg-label-info">
                            <i class="bx bx-user-check fs-3"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="fw-semibold d-block mb-1 text-muted">Activos</span>
                        <h3 class="card-title mb-0 text-success">{{ $kpis['activos'] }}</h3>
                    </div>
                    <div class="avatar avatar-md">
                        <span class="avatar-initial rounded bg-label-success">
                            <i class="bx bx-check-shield fs-3"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters & Table -->
    <div class="col-12">
        <div class="card shadow-sm border-0">
            <div class="card-header pb-2 border-bottom">
                <form method="GET" action="{{ route('usuarios.index') }}" class="row g-2 align-items-center">
                    <div class="col-md-5">
                        <div class="input-group">
                            <span class="input-group-text"><i class="bx bx-search"></i></span>
                            <input type="text" name="search" class="form-control" placeholder="Buscar por nombre, email o teléfono..." value="{{ request('search') }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <select name="role" class="form-select" onchange="this.form.submit()">
                            <option value="">Todos los Roles</option>
                            <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Administrador</option>
                            <option value="operador" {{ request('role') == 'operador' ? 'selected' : '' }}>Operador</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select name="estado" class="form-select" onchange="this.form.submit()">
                            <option value="">Todos los Estados</option>
                            <option value="activo" {{ request('estado') == 'activo' ? 'selected' : '' }}>Activo</option>
                            <option value="inactivo" {{ request('estado') == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                        </select>
                    </div>
                    <div class="col-md-2 text-end">
                        <a href="{{ route('usuarios.index') }}" class="btn btn-outline-secondary w-100">Limpiar</a>
                    </div>
                </form>
            </div>

            <div class="table-responsive text-nowrap">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Usuario</th>
                            <th>Email</th>
                            <th>Teléfono</th>
                            <th>Rol Funcional</th>
                            <th>Estado</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($usuarios as $u)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar avatar-sm me-3">
                                        <span class="avatar-initial rounded-circle {{ $u->role === 'admin' ? 'bg-label-danger' : 'bg-label-primary' }} fw-bold">
                                            {{ strtoupper(substr($u->name, 0, 2)) }}
                                        </span>
                                    </div>
                                    <div>
                                        <h6 class="mb-0 fw-semibold">{{ $u->name }}</h6>
                                        @if($u->id === Auth::id())
                                        <span class="badge bg-label-secondary" style="font-size: 0.65rem;">Tú</span>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td>{{ $u->email }}</td>
                            <td>{{ $u->telefono ?? '—' }}</td>
                            <td>
                                @if($u->role === 'admin')
                                <span class="badge bg-label-danger"><i class="bx bx-shield-quarter me-1"></i> Administrador</span>
                                @else
                                <span class="badge bg-label-info"><i class="bx bx-user-check me-1"></i> Operador</span>
                                @endif
                            </td>
                            <td>
                                @if($u->estado === 'activo')
                                <span class="badge bg-label-success">Activo</span>
                                @else
                                <span class="badge bg-label-secondary">Inactivo</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="d-inline-flex gap-1">
                                    <a href="{{ route('usuarios.edit', $u) }}" class="btn btn-sm btn-icon btn-outline-primary" title="Editar">
                                        <i class="bx bx-edit-alt"></i>
                                    </a>
                                    @if($u->id !== Auth::id())
                                    <form action="{{ route('usuarios.destroy', $u) }}" method="POST" onsubmit="return confirm('¿Seguro que desea eliminar a este usuario?');" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-icon btn-outline-danger" title="Eliminar">
                                            <i class="bx bx-trash"></i>
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">
                                <i class="bx bx-user-x fs-1 d-block mb-2"></i>
                                No se encontraron usuarios con los filtros aplicados.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($usuarios->hasPages())
            <div class="card-footer py-2">
                {{ $usuarios->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
