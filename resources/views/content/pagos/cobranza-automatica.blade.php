@extends('layouts/contentNavbarLayout')

@section('title', 'Cobranza Automática - Club Polanco')

@section('content')
<div class="row g-4 mb-4">
    <!-- Header -->
    <div class="col-12 d-flex flex-wrap justify-content-between align-items-center gap-2">
        <div>
            <h4 class="fw-bold mb-1" style="color: #1a7a3c;">Cobranza Automática Recurrente</h4>
            <p class="text-muted mb-0 small">Automatización de cargos periódicos a socios y conciliación de membresías</p>
        </div>
        <form action="{{ route('pagos.cobranza.ejecutar') }}" method="POST" onsubmit="return confirm('¿Confirma la ejecución del proceso de débito automático para los socios programados?');">
            @csrf
            <button type="submit" class="btn btn-primary" style="background-color: #1a7a3c; border-color: #1a7a3c;">
                <i class="bx bx-play-circle me-1"></i> Ejecutar Lote de Cobranza del Día
            </button>
        </form>
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

    <!-- Socios Scheduled For Billing -->
    <div class="col-lg-7">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
                <h6 class="mb-0 fw-bold"><i class="bx bx-calendar-event me-1 text-primary"></i> Próximos Socios a Cobrar ({{ $sociosParaCobro->count() }})</h6>
                <span class="badge bg-label-info">Lote Actual</span>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Socio</th>
                            <th>Categoría</th>
                            <th>Vencimiento</th>
                            <th>Cuota</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sociosParaCobro as $socio)
                        <tr>
                            <td>
                                <div class="fw-semibold text-dark">{{ $socio->nombre_completo }}</div>
                                <small class="text-muted font-monospace">{{ $socio->codigo_acceso }}</small>
                            </td>
                            <td><span class="badge bg-label-primary text-uppercase">{{ $socio->categoria }}</span></td>
                            <td>
                                <strong class="text-danger">
                                    {{ $socio->fecha_vencimiento ? \Carbon\Carbon::parse($socio->fecha_vencimiento)->format('d/m/Y') : 'Vencida' }}
                                </strong>
                            </td>
                            <td><strong class="text-success">${{ number_format($socio->cuota_mensual, 2) }}</strong></td>
                            <td>
                                <span class="badge {{ $socio->estado === 'activo' ? 'bg-label-success' : 'bg-label-warning' }}">
                                    {{ ucfirst($socio->estado) }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted small">No hay socios con cuotas pendientes en el lote actual.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Recent Automatic Charges Log -->
    <div class="col-lg-5">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-white border-bottom py-3">
                <h6 class="mb-0 fw-bold"><i class="bx bx-history me-1 text-success"></i> Bitácora de Débitos Recientes</h6>
            </div>
            <div class="card-body p-0">
                <ul class="list-group list-group-flush">
                    @forelse($cobrosRecientes as $c)
                    <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar avatar-sm me-3">
                                <span class="avatar-initial rounded bg-label-success">
                                    <i class="bx bx-check"></i>
                                </span>
                            </div>
                            <div>
                                <h6 class="mb-0 fw-semibold">{{ $c->socio->nombre_completo ?? 'Socio' }}</h6>
                                <small class="text-muted">{{ $c->referencia }} • {{ \Carbon\Carbon::parse($c->fecha_pago)->format('d/m/Y') }}</small>
                            </div>
                        </div>
                        <strong class="text-success">${{ number_format($c->monto, 2) }}</strong>
                    </li>
                    @empty
                    <li class="list-group-item text-center py-4 text-muted small">
                        Sin débitos automáticos ejecutados recientemente.
                    </li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
