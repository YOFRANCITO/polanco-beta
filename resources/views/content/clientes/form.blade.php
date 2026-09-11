@extends('layouts/contentNavbarLayout')

@section('title', ($socio ? 'Editar' : 'Nuevo') . ' Socio — Club Polanco')

@section('content')

<div class="d-flex align-items-center gap-2 mb-5">
  <a href="{{ route('clientes.index') }}" class="btn btn-sm btn-outline-secondary btn-icon">
    <i class="bx bx-arrow-back"></i>
  </a>
  <div>
    <h4 class="fw-bold mb-0">{{ $socio ? 'Editar Socio' : 'Nuevo Socio' }}</h4>
    <p class="text-muted mb-0 small">{{ $socio ? $socio->nombre_completo : 'Completa los datos del integrante' }}</p>
  </div>
</div>

<form action="{{ $socio ? route('clientes.update', $socio) : route('clientes.store') }}"
      method="POST" autocomplete="off">
  @csrf
  @if($socio) @method('PUT') @endif

  <div class="row g-4">

    {{-- Datos personales --}}
    <div class="col-xl-8">
      <div class="card mb-4">
        <div class="card-header">
          <h6 class="card-title mb-0 fw-semibold">Datos Personales</h6>
        </div>
        <div class="card-body">
          <div class="row g-3">
            <div class="col-sm-6">
              <label class="form-label fw-semibold small">Nombre <span class="text-danger">*</span></label>
              <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror"
                     value="{{ old('nombre', $socio?->nombre) }}" required>
              @error('nombre')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-sm-6">
              <label class="form-label fw-semibold small">Apellido <span class="text-danger">*</span></label>
              <input type="text" name="apellido" class="form-control @error('apellido') is-invalid @enderror"
                     value="{{ old('apellido', $socio?->apellido) }}" required>
              @error('apellido')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-sm-6">
              <label class="form-label fw-semibold small">Email</label>
              <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                     value="{{ old('email', $socio?->email) }}">
              @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-sm-6">
              <label class="form-label fw-semibold small">Teléfono</label>
              <input type="text" name="telefono" class="form-control"
                     value="{{ old('telefono', $socio?->telefono) }}">
            </div>
            <div class="col-sm-6">
              <label class="form-label fw-semibold small">Fecha de Nacimiento <span class="text-danger">*</span></label>
              <input type="date" name="fecha_nacimiento" class="form-control @error('fecha_nacimiento') is-invalid @enderror"
                     value="{{ old('fecha_nacimiento', $socio?->fecha_nacimiento?->format('Y-m-d')) }}" required>
              @error('fecha_nacimiento')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-sm-6">
              <label class="form-label fw-semibold small">Cédula / ID</label>
              <input type="text" name="cedula" class="form-control @error('cedula') is-invalid @enderror"
                     value="{{ old('cedula', $socio?->cedula) }}">
              @error('cedula')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-12">
              <label class="form-label fw-semibold small">Dirección</label>
              <input type="text" name="direccion" class="form-control"
                     value="{{ old('direccion', $socio?->direccion) }}">
            </div>
            <div class="col-12">
              <label class="form-label fw-semibold small">Notas internas</label>
              <textarea name="notas" class="form-control" rows="3">{{ old('notas', $socio?->notas) }}</textarea>
            </div>
          </div>
        </div>
      </div>
    </div>

    {{-- Membresía --}}
    <div class="col-xl-4">
      <div class="card mb-4">
        <div class="card-header">
          <h6 class="card-title mb-0 fw-semibold">Membresía</h6>
        </div>
        <div class="card-body">
          <div class="mb-3">
            <label class="form-label fw-semibold small">Categoría <span class="text-danger">*</span></label>
            <select name="categoria" class="form-select @error('categoria') is-invalid @enderror" required>
              @foreach(['familiar'=>'Familiar','individual'=>'Individual','junior'=>'Junior','vip'=>'VIP'] as $val=>$label)
              <option value="{{ $val }}" {{ old('categoria', $socio?->categoria)==$val ? 'selected' : '' }}>{{ $label }}</option>
              @endforeach
            </select>
            @error('categoria')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
          @if($socio)
          <div class="mb-3">
            <label class="form-label fw-semibold small">Estado</label>
            <select name="estado" class="form-select">
              <option value="activo"   {{ $socio->estado=='activo'   ? 'selected' : '' }}>Activo</option>
              <option value="moroso"   {{ $socio->estado=='moroso'   ? 'selected' : '' }}>Moroso</option>
              <option value="inactivo" {{ $socio->estado=='inactivo' ? 'selected' : '' }}>Inactivo</option>
            </select>
          </div>
          @endif
          <div class="mb-3">
            <label class="form-label fw-semibold small">Cuota Mensual (RD$) <span class="text-danger">*</span></label>
            <input type="number" name="cuota_mensual" class="form-control @error('cuota_mensual') is-invalid @enderror"
                   value="{{ old('cuota_mensual', $socio?->cuota_mensual ?? 2500) }}" step="0.01" min="0" required>
            @error('cuota_mensual')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
          <div class="mb-3">
            <label class="form-label fw-semibold small">Fecha de Ingreso <span class="text-danger">*</span></label>
            <input type="date" name="fecha_ingreso" class="form-control"
                   value="{{ old('fecha_ingreso', $socio?->fecha_ingreso?->format('Y-m-d') ?? now()->format('Y-m-d')) }}" required>
          </div>
          <div class="mb-3">
            <label class="form-label fw-semibold small">Fecha de Vencimiento</label>
            <input type="date" name="fecha_vencimiento" class="form-control"
                   value="{{ old('fecha_vencimiento', $socio?->fecha_vencimiento?->format('Y-m-d')) }}">
          </div>
        </div>
      </div>

      @if(!$socio)
      <div class="alert d-flex align-items-start gap-2" style="background:rgba(26,122,60,.08); border:1px solid rgba(26,122,60,.2); border-radius:8px;">
        <i class="bx bx-info-circle mt-1" style="color:#1a7a3c;"></i>
        <p class="small mb-0">Al guardar, se generará automáticamente un <strong>código de acceso</strong> único para el socio.</p>
      </div>
      @endif

      <div class="d-grid gap-2">
        <button type="submit" class="btn btn-primary">
          <i class="bx bx-save me-1"></i>{{ $socio ? 'Guardar Cambios' : 'Registrar Socio' }}
        </button>
        <a href="{{ $socio ? route('clientes.show', $socio) : route('clientes.index') }}" class="btn btn-outline-secondary">
          Cancelar
        </a>
      </div>
    </div>

  </div>
</form>

@endsection
