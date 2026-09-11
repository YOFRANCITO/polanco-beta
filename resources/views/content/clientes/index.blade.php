@extends('layouts/contentNavbarLayout')

@section('title', 'Cartera de Socios — Club Polanco')

@section('content')

{{-- Header --}}
<div class="d-flex align-items-center justify-content-between mb-5 flex-wrap gap-3">
  <div>
    <h4 class="fw-bold mb-1">Cartera de Socios</h4>
    <p class="text-muted mb-0 small">Gestiona los integrantes del club</p>
  </div>
  <a href="{{ route('clientes.create') }}" class="btn btn-primary d-flex align-items-center gap-2">
    <i class="bx bx-plus"></i> Nuevo Socio
  </a>
</div>

{{-- Mensaje de éxito --}}
@if(session('success'))
<div class="alert alert-success alert-dismissible fade show d-flex align-items-center gap-2 mb-4" role="alert">
  <i class="bx bx-check-circle fs-5"></i>
  <span>{{ session('success') }}</span>
  <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

{{-- KPI Cards --}}
<div class="row mb-5 g-3">
  <div class="col-6 col-md-3">
    <div class="card text-center">
      <div class="card-body py-4">
        <div class="avatar avatar-sm rounded mx-auto mb-2" style="background:rgba(26,122,60,.1);">
          <i class="bx bx-group" style="color:#1a7a3c;"></i>
        </div>
        <h4 class="fw-bold mb-0">{{ $stats['total'] }}</h4>
        <p class="text-muted small mb-0">Total Socios</p>
      </div>
    </div>
  </div>
  <div class="col-6 col-md-3">
    <div class="card text-center">
      <div class="card-body py-4">
        <div class="avatar avatar-sm rounded mx-auto mb-2" style="background:rgba(26,122,60,.1);">
          <i class="bx bx-user-check" style="color:#1a7a3c;"></i>
        </div>
        <h4 class="fw-bold mb-0">{{ $stats['activos'] }}</h4>
        <p class="text-muted small mb-0">Activos</p>
      </div>
    </div>
  </div>
  <div class="col-6 col-md-3">
    <div class="card text-center">
      <div class="card-body py-4">
        <div class="avatar avatar-sm rounded mx-auto mb-2" style="background:rgba(255,171,0,.1);">
          <i class="bx bx-time" style="color:#ffab00;"></i>
        </div>
        <h4 class="fw-bold mb-0">{{ $stats['morosos'] }}</h4>
        <p class="text-muted small mb-0">Morosos</p>
      </div>
    </div>
  </div>
  <div class="col-6 col-md-3">
    <div class="card text-center">
      <div class="card-body py-4">
        <div class="avatar avatar-sm rounded mx-auto mb-2" style="background:rgba(255,62,29,.1);">
          <i class="bx bx-user-x" style="color:#ff3e1d;"></i>
        </div>
        <h4 class="fw-bold mb-0">{{ $stats['inactivos'] }}</h4>
        <p class="text-muted small mb-0">Inactivos</p>
      </div>
    </div>
  </div>
</div>

{{-- Filtros y búsqueda --}}
<div class="card mb-4">
  <div class="card-body py-3">
    <form method="GET" action="{{ route('clientes.index') }}" class="row g-3 align-items-end">
      <div class="col-md-5">
        <label class="form-label small fw-semibold text-muted mb-1">Buscar</label>
        <div class="input-group">
          <span class="input-group-text"><i class="bx bx-search"></i></span>
          <input type="text" name="buscar" class="form-control" placeholder="Nombre, cédula, código..." value="{{ request('buscar') }}">
        </div>
      </div>
      <div class="col-md-3">
        <label class="form-label small fw-semibold text-muted mb-1">Categoría</label>
        <select name="categoria" class="form-select">
          <option value="">Todas</option>
          <option value="familiar"   {{ request('categoria')=='familiar'   ? 'selected' : '' }}>Familiar</option>
          <option value="individual" {{ request('categoria')=='individual' ? 'selected' : '' }}>Individual</option>
          <option value="junior"     {{ request('categoria')=='junior'     ? 'selected' : '' }}>Junior</option>
          <option value="vip"        {{ request('categoria')=='vip'        ? 'selected' : '' }}>VIP</option>
        </select>
      </div>
      <div class="col-md-2">
        <label class="form-label small fw-semibold text-muted mb-1">Estado</label>
        <select name="estado" class="form-select">
          <option value="">Todos</option>
          <option value="activo"   {{ request('estado')=='activo'   ? 'selected' : '' }}>Activo</option>
          <option value="moroso"   {{ request('estado')=='moroso'   ? 'selected' : '' }}>Moroso</option>
          <option value="inactivo" {{ request('estado')=='inactivo' ? 'selected' : '' }}>Inactivo</option>
        </select>
      </div>
      <div class="col-md-2 d-flex gap-2">
        <button type="submit" class="btn btn-primary flex-grow-1">Filtrar</button>
        <a href="{{ route('clientes.index') }}" class="btn btn-outline-secondary"><i class="bx bx-x"></i></a>
      </div>
    </form>
  </div>
</div>

{{-- Tabla de socios --}}
<div class="card">
  <div class="table-responsive">
    <table class="table table-hover align-middle mb-0">
      <thead style="background:rgba(26,122,60,.04);">
        <tr>
          <th class="ps-4 small text-muted fw-semibold" style="width:40%">Socio</th>
          <th class="small text-muted fw-semibold">Categoría</th>
          <th class="small text-muted fw-semibold">Cuota</th>
          <th class="small text-muted fw-semibold">Ingreso</th>
          <th class="small text-muted fw-semibold">Estado</th>
          <th class="pe-4 small text-muted fw-semibold text-end">Acciones</th>
        </tr>
      </thead>
      <tbody>
        @forelse($socios as $socio)
        <tr>
          <td class="ps-4">
            <div class="d-flex align-items-center gap-3">
              <div class="d-flex align-items-center justify-content-center rounded-circle fw-bold text-white"
                   style="width:40px; height:40px; min-width:40px; background:{{ $socio->color_categoria }}; font-size:.8rem;">
                {{ $socio->iniciales }}
              </div>
              <div>
                <p class="mb-0 fw-semibold">{{ $socio->nombre_completo }}</p>
                <span class="text-muted small">{{ $socio->email ?? $socio->cedula ?? '—' }}</span>
              </div>
            </div>
          </td>
          <td>
            <span class="badge rounded-pill text-capitalize" style="background:{{ $socio->color_categoria }}1a; color:{{ $socio->color_categoria }}; font-size:.75rem;">
              {{ $socio->categoria }}
            </span>
          </td>
          <td class="fw-semibold small">RD$ {{ number_format($socio->cuota_mensual, 0) }}</td>
          <td class="small text-muted">{{ $socio->fecha_ingreso->format('d/m/Y') }}</td>
          <td>
            @php
              $colores = ['activo'=>'#1a7a3c','moroso'=>'#ffab00','inactivo'=>'#ff3e1d'];
              $c = $colores[$socio->estado] ?? '#8592a3';
            @endphp
            <span class="badge rounded-pill text-capitalize" style="background:{{ $c }}1a; color:{{ $c }}; font-size:.75rem;">
              {{ $socio->estado }}
            </span>
          </td>
          <td class="pe-4 text-end">
            <a href="{{ route('clientes.show', $socio) }}" class="btn btn-sm btn-icon btn-outline-primary me-1" title="Ver perfil">
              <i class="bx bx-show"></i>
            </a>
            <a href="{{ route('clientes.edit', $socio) }}" class="btn btn-sm btn-icon btn-outline-secondary" title="Editar">
              <i class="bx bx-edit"></i>
            </a>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="6" class="text-center py-5 text-muted">
            <i class="bx bx-group fs-1 d-block mb-2 opacity-25"></i>
            No se encontraron socios
          </td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  @if($socios->hasPages())
  <div class="card-footer d-flex align-items-center justify-content-between py-3">
    <p class="text-muted small mb-0">Mostrando {{ $socios->firstItem() }}–{{ $socios->lastItem() }} de {{ $socios->total() }}</p>
    {{ $socios->links('pagination::bootstrap-5') }}
  </div>
  @endif
</div>

@endsection
