@extends('layouts/contentNavbarLayout')

@section('title', 'Gestión de Pagos - Club Polanco')

@section('content')
<div class="row g-4 mb-4">
    <!-- Header -->
    <div class="col-12 d-flex flex-wrap justify-content-between align-items-center gap-2">
        <div>
            <h4 class="fw-bold mb-1" style="color: #1a7a3c;">Gestión de Pagos</h4>
            <p class="text-muted mb-0 small">Control integral de cobranzas, transacciones electrónicas y métodos de cobro</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('pagos.qr') }}" class="btn btn-outline-primary">
                <i class="bx bx-qr-scan me-1"></i> Cobro QR
            </a>
            <a href="{{ route('pagos.tarjeta') }}" class="btn btn-primary" style="background-color: #1a7a3c; border-color: #1a7a3c;">
                <i class="bx bx-credit-card me-1"></i> TPV Tarjeta
            </a>
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

    <!-- KPI Cards -->
    <div class="col-sm-6 col-xl-3">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="fw-semibold d-block mb-1 text-muted">Recaudación Mes</span>
                        <h3 class="card-title mb-0" style="color: #1a7a3c;">${{ number_format($kpis['total_mes'], 2) }}</h3>
                    </div>
                    <div class="avatar avatar-md">
                        <span class="avatar-initial rounded bg-label-success">
                            <i class="bx bx-wallet fs-3"></i>
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
                        <span class="fw-semibold d-block mb-1 text-muted">Cobros por QR</span>
                        <h3 class="card-title mb-0 text-primary">${{ number_format($kpis['total_qr'], 2) }}</h3>
                    </div>
                    <div class="avatar avatar-md">
                        <span class="avatar-initial rounded bg-label-primary">
                            <i class="bx bx-qr-scan fs-3"></i>
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
                        <span class="fw-semibold d-block mb-1 text-muted">Cobros Tarjeta</span>
                        <h3 class="card-title mb-0 text-info">${{ number_format($kpis['total_tarjeta'], 2) }}</h3>
                    </div>
                    <div class="avatar avatar-md">
                        <span class="avatar-initial rounded bg-label-info">
                            <i class="bx bx-credit-card fs-3"></i>
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
                        <span class="fw-semibold d-block mb-1 text-muted">Por Verificar</span>
                        <h3 class="card-title mb-0 text-warning">{{ $kpis['pendientes'] }}</h3>
                    </div>
                    <div class="avatar avatar-md">
                        <span class="avatar-initial rounded bg-label-warning">
                            <i class="bx bx-time fs-3"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters & Payments Table -->
    <div class="col-12">
        <div class="card shadow-sm border-0">
            <div class="card-header pb-2 border-bottom">
                <form method="GET" action="{{ route('pagos.index') }}" class="row g-2 align-items-center">
                    <div class="col-md-4">
                        <div class="input-group">
                            <span class="input-group-text"><i class="bx bx-search"></i></span>
                            <input type="text" name="search" class="form-control" placeholder="Buscar por socio, folio o concepto..." value="{{ request('search') }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <select name="metodo" class="form-select" onchange="this.form.submit()">
                            <option value="">Todos los Métodos</option>
                            <option value="qr" {{ request('metodo') == 'qr' ? 'selected' : '' }}>QR Dinámico</option>
                            <option value="tarjeta" {{ request('metodo') == 'tarjeta' ? 'selected' : '' }}>Tarjeta</option>
                            <option value="transferencia" {{ request('metodo') == 'transferencia' ? 'selected' : '' }}>Transferencia</option>
                            <option value="efectivo" {{ request('metodo') == 'efectivo' ? 'selected' : '' }}>Efectivo</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select name="estado" class="form-select" onchange="this.form.submit()">
                            <option value="">Todos los Estados</option>
                            <option value="completado" {{ request('estado') == 'completado' ? 'selected' : '' }}>Completado</option>
                            <option value="pendiente" {{ request('estado') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                            <option value="rechazado" {{ request('estado') == 'rechazado' ? 'selected' : '' }}>Rechazado</option>
                        </select>
                    </div>
                    <div class="col-md-2 text-end">
                        <a href="{{ route('pagos.index') }}" class="btn btn-outline-secondary w-100">Limpiar</a>
                    </div>
                </form>
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
                            <th>Monto</th>
                            <th>Estado</th>
                            <th class="text-center">Recibo</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pagos as $p)
                        <tr>
                            <td>
                                <strong>{{ \Carbon\Carbon::parse($p->fecha_pago)->format('d/m/Y') }}</strong>
                                <small class="text-muted d-block">{{ $p->created_at->format('H:i') }}</small>
                            </td>
                            <td>
                                <span class="badge bg-label-secondary font-monospace">{{ $p->referencia ?? 'S/F' }}</span>
                            </td>
                            <td>
                                @if($p->socio)
                                <div class="d-flex align-items-center">
                                    <div class="avatar avatar-xs me-2">
                                        <span class="avatar-initial rounded-circle bg-label-primary">
                                            {{ $p->socio->iniciales }}
                                        </span>
                                    </div>
                                    <div>
                                        <a href="{{ route('clientes.show', $p->socio) }}" class="fw-semibold text-dark text-decoration-none">
                                            {{ $p->socio->nombre_completo }}
                                        </a>
                                        <small class="text-muted d-block font-monospace">{{ $p->socio->codigo_acceso }}</small>
                                    </div>
                                </div>
                                @else
                                <span class="text-muted">Socio no asignado</span>
                                @endif
                            </td>
                            <td>
                                <span class="fw-semibold text-dark">{{ $p->concepto }}</span>
                            </td>
                            <td>
                                <span class="badge {{ $p->metodo_badge }}">
                                    <i class="{{ $p->metodo_icon }} me-1"></i> {{ $p->metodo_label }}
                                </span>
                            </td>
                            <td>
                                <strong class="fs-6 text-success">${{ number_format($p->monto, 2) }}</strong>
                            </td>
                            <td>
                                <span class="badge {{ $p->estado_badge }}">{{ $p->estado_label }}</span>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('pagos.recibo.show', $p) }}" class="btn btn-sm btn-icon btn-outline-primary" target="_blank" title="Imprimir Recibo">
                                    <i class="bx bx-printer"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-5 text-muted">
                                <i class="bx bx-wallet fs-1 d-block mb-2"></i>
                                No se encontraron registros de pagos con los filtros seleccionados.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($pagos->hasPages())
            <div class="card-footer py-2 border-top">
                {{ $pagos->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
