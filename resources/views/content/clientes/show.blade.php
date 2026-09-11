@extends('layouts/contentNavbarLayout')

@section('title', $socio->nombre_completo . ' — Club Polanco')

@section('content')

{{-- Back + acciones --}}
<div class="d-flex align-items-center justify-content-between mb-5 flex-wrap gap-3">
  <div class="d-flex align-items-center gap-2">
    <a href="{{ route('clientes.index') }}" class="btn btn-sm btn-outline-secondary btn-icon">
      <i class="bx bx-arrow-back"></i>
    </a>
    <div>
      <h4 class="fw-bold mb-0">Perfil del Socio</h4>
      <p class="text-muted mb-0 small">Código: <code>{{ $socio->codigo_acceso }}</code></p>
    </div>
  </div>
  <div class="d-flex gap-2">
    <a href="{{ route('clientes.edit', $socio) }}" class="btn btn-sm btn-outline-primary d-flex align-items-center gap-1">
      <i class="bx bx-edit"></i> Editar
    </a>
    <form action="{{ route('clientes.destroy', $socio) }}" method="POST" onsubmit="return confirm('¿Desactivar este socio?')">
      @csrf @method('DELETE')
      <button class="btn btn-sm btn-outline-danger d-flex align-items-center gap-1">
        <i class="bx bx-user-x"></i> Desactivar
      </button>
    </form>
  </div>
</div>

<div class="row g-4">

  {{-- Columna izquierda: info principal --}}
  <div class="col-xl-4">

    {{-- Avatar y estado --}}
    <div class="card mb-4">
      <div class="card-body text-center py-5">
        <div class="d-inline-flex align-items-center justify-content-center rounded-circle fw-bold text-white mb-3"
             style="width:80px; height:80px; background:{{ $socio->color_categoria }}; font-size:1.8rem;">
          {{ $socio->iniciales }}
        </div>
        <h5 class="fw-bold mb-1">{{ $socio->nombre_completo }}</h5>
        <p class="text-muted small mb-3">{{ $socio->email ?? 'Sin email' }}</p>
        <div class="d-flex justify-content-center gap-2 mb-3">
          <span class="badge rounded-pill text-capitalize" style="background:{{ $socio->color_categoria }}1a; color:{{ $socio->color_categoria }};">
            {{ $socio->categoria }}
          </span>
          @php $c = ['activo'=>'#1a7a3c','moroso'=>'#ffab00','inactivo'=>'#ff3e1d'][$socio->estado] ?? '#8592a3'; @endphp
          <span class="badge rounded-pill text-capitalize" style="background:{{ $c }}1a; color:{{ $c }};">
            {{ $socio->estado }}
          </span>
        </div>
        <div class="border rounded p-3 text-start">
          <p class="small text-muted mb-1 fw-semibold">Código de Acceso</p>
          <div class="d-flex align-items-center gap-2">
            <code class="fs-6 fw-bold" style="color:#1a7a3c; letter-spacing:.15em;">{{ $socio->codigo_acceso }}</code>
            <button class="btn btn-sm btn-icon btn-outline-secondary" onclick="navigator.clipboard.writeText('{{ $socio->codigo_acceso }}')" title="Copiar">
              <i class="bx bx-copy"></i>
            </button>
          </div>
        </div>
      </div>
    </div>

    {{-- Datos personales --}}
    <div class="card">
      <div class="card-header">
        <h6 class="card-title mb-0 fw-semibold">Información Personal</h6>
      </div>
      <div class="card-body">
        <ul class="list-unstyled mb-0">
          <li class="d-flex justify-content-between py-2 border-bottom">
            <span class="small text-muted">Cédula</span>
            <span class="small fw-semibold">{{ $socio->cedula ?? '—' }}</span>
          </li>
          <li class="d-flex justify-content-between py-2 border-bottom">
            <span class="small text-muted">Teléfono</span>
            <span class="small fw-semibold">{{ $socio->telefono ?? '—' }}</span>
          </li>
          <li class="d-flex justify-content-between py-2 border-bottom">
            <span class="small text-muted">Cumpleaños</span>
            <span class="small fw-semibold">{{ $socio->fecha_nacimiento->format('d/m/Y') }}</span>
          </li>
          <li class="d-flex justify-content-between py-2 border-bottom">
            <span class="small text-muted">Ingreso</span>
            <span class="small fw-semibold">{{ $socio->fecha_ingreso->format('d/m/Y') }}</span>
          </li>
          <li class="d-flex justify-content-between py-2 border-bottom">
            <span class="small text-muted">Vencimiento</span>
            <span class="small fw-semibold">{{ $socio->fecha_vencimiento?->format('d/m/Y') ?? '—' }}</span>
          </li>
          <li class="d-flex justify-content-between py-2">
            <span class="small text-muted">Cuota Mensual</span>
            <span class="small fw-bold" style="color:#1a7a3c;">RD$ {{ number_format($socio->cuota_mensual, 0) }}</span>
          </li>
        </ul>
        @if($socio->notas)
        <div class="mt-3 p-3 rounded" style="background:#f8f9fa;">
          <p class="small text-muted mb-1 fw-semibold">Notas</p>
          <p class="small mb-0">{{ $socio->notas }}</p>
        </div>
        @endif
      </div>
    </div>

  </div>

  {{-- Columna derecha: historial de pagos --}}
  <div class="col-xl-8">

    {{-- Resumen financiero --}}
    @php
      $pagadoAnio = $socio->pagos->where('estado', 'completado')->where('fecha_pago', '>=', now()->startOfYear())->sum('monto');
      $pendiente = $socio->pagos->where('estado', 'pendiente')->sum('monto');
      $totalPagos = $socio->pagos->count();
    @endphp
    <div class="row g-3 mb-4">
      <div class="col-sm-4">
        <div class="card h-100 text-center shadow-sm border-0">
          <div class="card-body py-4">
            <h4 class="fw-bold mb-0" style="color:#1a7a3c;">${{ number_format($pagadoAnio, 2) }}</h4>
            <p class="text-muted small mb-0 mt-1">Pagado este año</p>
          </div>
        </div>
      </div>
      <div class="col-sm-4">
        <div class="card h-100 text-center shadow-sm border-0">
          <div class="card-body py-4">
            <h4 class="fw-bold mb-0" style="color:#ffab00;">${{ number_format($pendiente, 2) }}</h4>
            <p class="text-muted small mb-0 mt-1">Pendiente de Aprobación</p>
          </div>
        </div>
      </div>
      <div class="col-sm-4">
        <div class="card h-100 text-center shadow-sm border-0">
          <div class="card-body py-4">
            <h4 class="fw-bold mb-0 text-dark">{{ $totalPagos }}</h4>
            <p class="text-muted small mb-0 mt-1">Transacciones Registradas</p>
          </div>
        </div>
      </div>
    </div>

    {{-- Historial de pagos real --}}
    <div class="card shadow-sm border-0">
      <div class="card-header d-flex align-items-center justify-content-between border-bottom py-3">
        <h6 class="card-title mb-0 fw-bold"><i class="bx bx-receipt me-1 text-primary"></i> Historial de Pagos del Socio</h6>
        <div class="d-flex gap-2">
          <a href="{{ route('pagos.qr') }}" class="btn btn-sm btn-outline-primary">
            <i class="bx bx-qr-scan me-1"></i> Cobro QR
          </a>
          <a href="{{ route('pagos.tarjeta') }}" class="btn btn-sm btn-primary" style="background-color: #1a7a3c; border-color: #1a7a3c;">
            <i class="bx bx-credit-card me-1"></i> Cobro Tarjeta
          </a>
        </div>
      </div>
      <div class="table-responsive text-nowrap">
        <table class="table table-hover align-middle mb-0">
          <thead class="table-light">
            <tr>
              <th>Fecha</th>
              <th>Folio</th>
              <th>Concepto</th>
              <th>Método</th>
              <th>Monto</th>
              <th>Estado</th>
              <th class="text-center">Recibo</th>
            </tr>
          </thead>
          <tbody>
            @forelse($socio->pagos as $p)
            <tr>
              <td>
                <strong>{{ \Carbon\Carbon::parse($p->fecha_pago)->format('d/m/Y') }}</strong>
              </td>
              <td><span class="badge bg-label-secondary font-monospace">{{ $p->referencia ?? 'S/R' }}</span></td>
              <td><span class="fw-semibold text-dark">{{ $p->concepto }}</span></td>
              <td>
                <span class="badge {{ $p->metodo_badge }}">
                  <i class="{{ $p->metodo_icon }} me-1"></i> {{ $p->metodo_label }}
                </span>
              </td>
              <td><strong class="text-success">${{ number_format($p->monto, 2) }}</strong></td>
              <td><span class="badge {{ $p->estado_badge }}">{{ $p->estado_label }}</span></td>
              <td class="text-center">
                <a href="{{ route('pagos.recibo.show', $p) }}" class="btn btn-xs btn-outline-primary" target="_blank" title="Ver Recibo">
                  <i class="bx bx-printer"></i>
                </a>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="7" class="text-center py-4 text-muted small">
                <i class="bx bx-receipt fs-2 d-block mb-1 opacity-50"></i>
                Este socio no tiene pagos registrados en su historial todavía.
              </td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>

  </div>
</div>

@endsection
