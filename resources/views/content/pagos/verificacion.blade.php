@extends('layouts/contentNavbarLayout')

@section('title', 'Verificación de Pagos - Club Polanco')

@section('content')
<div class="row g-4 mb-4">
    <!-- Header -->
    <div class="col-12 d-flex flex-wrap justify-content-between align-items-center gap-2">
        <div>
            <h4 class="fw-bold mb-1" style="color: #1a7a3c;">Bandeja de Verificación de Pagos</h4>
            <p class="text-muted mb-0 small">Conciliación de pagos reportados por transferencia bancaria o comprobantes pendientes</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <span class="badge bg-label-warning fs-6 px-3 py-2">
                <i class="bx bx-time me-1"></i> Total en Espera: ${{ number_format($totalPendienteMonto, 2) }} MXN
            </span>
        </div>
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

    <!-- Table -->
    <div class="col-12">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white border-bottom py-3">
                <h6 class="mb-0 fw-bold"><i class="bx bx-list-check me-1 text-primary"></i> Pagos Pendientes de Aprobación</h6>
            </div>

            <div class="table-responsive text-nowrap">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Fecha</th>
                            <th>Folio</th>
                            <th>Socio</th>
                            <th>Concepto</th>
                            <th>Método</th>
                            <th>Importe</th>
                            <th>Notas / Comprobante</th>
                            <th class="text-center">Acciones de Verificación</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pagosPendientes as $pago)
                        <tr>
                            <td>
                                <strong>{{ \Carbon\Carbon::parse($pago->fecha_pago)->format('d/m/Y') }}</strong>
                                <small class="text-muted d-block">{{ $pago->created_at->diffForHumans() }}</small>
                            </td>
                            <td>
                                <span class="badge bg-label-secondary font-monospace">{{ $pago->referencia ?? 'S/F' }}</span>
                            </td>
                            <td>
                                @if($pago->socio)
                                <div class="d-flex align-items-center">
                                    <div class="avatar avatar-xs me-2">
                                        <span class="avatar-initial rounded-circle bg-label-primary">
                                            {{ $pago->socio->iniciales }}
                                        </span>
                                    </div>
                                    <div>
                                        <a href="{{ route('clientes.show', $pago->socio) }}" class="fw-semibold text-dark">
                                            {{ $pago->socio->nombre_completo }}
                                        </a>
                                        <small class="text-muted d-block">{{ $pago->socio->codigo_acceso }}</small>
                                    </div>
                                </div>
                                @else
                                <span class="text-muted">Socio no asignado</span>
                                @endif
                            </td>
                            <td>{{ $pago->concepto }}</td>
                            <td>
                                <span class="badge {{ $pago->metodo_badge }}">
                                    <i class="{{ $pago->metodo_icon }} me-1"></i> {{ $pago->metodo_label }}
                                </span>
                            </td>
                            <td>
                                <strong class="fs-6 text-dark">${{ number_format($pago->monto, 2) }}</strong>
                            </td>
                            <td>
                                <small class="text-muted text-wrap d-inline-block" style="max-width: 220px;">
                                    {{ $pago->notas ?? 'Sin observaciones' }}
                                </small>
                            </td>
                            <td class="text-center">
                                <div class="d-inline-flex gap-2">
                                    <form action="{{ route('pagos.aprobar', $pago) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success" title="Aprobar Pago">
                                            <i class="bx bx-check me-1"></i> Aprobar
                                        </button>
                                    </form>
                                    <form action="{{ route('pagos.rechazar', $pago) }}" method="POST" onsubmit="return confirm('¿Seguro que desea rechazar este pago?');">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Rechazar Pago">
                                            <i class="bx bx-x me-1"></i> Rechazar
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-5 text-muted">
                                <i class="bx bx-check-shield text-success fs-1 d-block mb-2"></i>
                                <strong>¡Al día!</strong> No hay pagos pendientes de verificación en este momento.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($pagosPendientes->hasPages())
            <div class="card-footer py-2 border-top">
                {{ $pagosPendientes->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
