@extends('portal.layout')

@section('title', 'Mi Perfil - Portal de Socios Club Polanco')

@section('content')
<div class="row g-4">
    <!-- Welcome Banner & Socio Info Card -->
    <div class="col-lg-8">
        <div class="card portal-card mb-4 overflow-hidden">
            <div class="card-body p-4">
                <div class="d-flex flex-column flex-md-row align-items-md-center gap-4">
                    <div class="avatar avatar-xl" style="width: 80px; height: 80px;">
                        <div class="avatar-initial rounded-circle fs-1 fw-bold text-white shadow-sm" style="background: linear-gradient(135deg, #1a7a3c 0%, #c9a84c 100%);">
                            {{ $socio->iniciales }}
                        </div>
                    </div>
                    <div class="flex-grow-1">
                        <div class="d-flex flex-wrap align-items-center gap-2 mb-1">
                            <h3 class="mb-0 fw-bold">{{ $socio->nombre_completo }}</h3>
                            <span class="badge bg-label-primary text-uppercase">{{ $socio->categoria }}</span>
                            @if($socio->estado === 'activo')
                            <span class="badge bg-success"><i class="bx bx-check-circle me-1"></i> Membresía Activa</span>
                            @elseif($socio->estado === 'moroso')
                            <span class="badge bg-warning"><i class="bx bx-time me-1"></i> Pago Pendiente</span>
                            @else
                            <span class="badge bg-danger"><i class="bx bx-x-circle me-1"></i> Inactiva</span>
                            @endif
                        </div>
                        <div class="text-muted small d-flex flex-wrap gap-3 mt-2">
                            <span><i class="bx bx-barcode me-1 text-primary"></i> Código: <strong>{{ $socio->codigo_acceso }}</strong></span>
                            <span><i class="bx bx-id-card me-1 text-primary"></i> Cédula: {{ $socio->cedula }}</span>
                            <span><i class="bx bx-calendar me-1 text-primary"></i> Ingreso: {{ \Carbon\Carbon::parse($socio->fecha_ingreso)->format('d/m/Y') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Personal Details -->
        <div class="card portal-card mb-4">
            <div class="card-header bg-white border-bottom py-3">
                <h5 class="mb-0 fw-bold text-dark"><i class="bx bx-user me-2 text-primary"></i> Datos Registrados</h5>
            </div>
            <div class="card-body py-3">
                <div class="row g-3">
                    <div class="col-sm-6">
                        <span class="text-muted small d-block">Correo Electrónico</span>
                        <strong class="text-dark">{{ $socio->email ?? 'No registrado' }}</strong>
                    </div>
                    <div class="col-sm-6">
                        <span class="text-muted small d-block">Teléfono / WhatsApp</span>
                        <strong class="text-dark">{{ $socio->telefono ?? 'No registrado' }}</strong>
                    </div>
                    <div class="col-sm-6">
                        <span class="text-muted small d-block">Fecha de Nacimiento</span>
                        <strong class="text-dark">{{ \Carbon\Carbon::parse($socio->fecha_nacimiento)->format('d/m/Y') }}</strong>
                    </div>
                    <div class="col-sm-6">
                        <span class="text-muted small d-block">Dirección Residencial</span>
                        <strong class="text-dark">{{ $socio->direccion ?? 'Polanco, CDMX' }}</strong>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Payments on Profile -->
        <div class="card portal-card">
            <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold text-dark"><i class="bx bx-receipt me-2 text-primary"></i> Últimos Pagos Registrados</h5>
                <a href="{{ route('portal.historial') }}" class="btn btn-sm btn-outline-primary">Ver Todo</a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Fecha</th>
                            <th>Concepto</th>
                            <th>Método</th>
                            <th>Monto</th>
                            <th>Estado</th>
                            <th>Recibo</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($socio->pagos as $pago)
                        <tr>
                            <td class="small">{{ \Carbon\Carbon::parse($pago->fecha_pago)->format('d/m/Y') }}</td>
                            <td><strong class="small">{{ $pago->concepto }}</strong></td>
                            <td>
                                <span class="badge {{ $pago->metodo_badge }}">
                                    <i class="{{ $pago->metodo_icon }} me-1"></i> {{ $pago->metodo_label }}
                                </span>
                            </td>
                            <td><strong class="text-success">${{ number_format($pago->monto, 2) }}</strong></td>
                            <td><span class="badge {{ $pago->estado_badge }}">{{ $pago->estado_label }}</span></td>
                            <td>
                                <a href="{{ route('portal.recibo', $pago) }}" class="btn btn-xs btn-outline-secondary" target="_blank">
                                    <i class="bx bx-printer"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-3 text-muted small">No tiene pagos registrados recientemente.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Membership Status & Quick Action Card -->
    <div class="col-lg-4">
        <!-- Membership Card -->
        <div class="card portal-card mb-4 text-white" style="background: linear-gradient(135deg, #1a7a3c 0%, #0d4a23 100%);">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div>
                        <span class="text-white-50 text-uppercase small fw-bold">Membresía {{ $socio->categoria }}</span>
                        <h4 class="text-white fw-bold mb-0">Club Polanco</h4>
                    </div>
                    <span class="badge bg-white text-dark fw-bold px-2 py-1">CP</span>
                </div>

                <div class="mb-4">
                    <span class="text-white-50 small d-block">Cuota Mensual</span>
                    <h2 class="text-white fw-bold mb-0">${{ number_format($socio->cuota_mensual, 2) }} <small class="fs-6 fw-normal text-white-50">MXN</small></h2>
                </div>

                <div class="pt-3 border-top border-white-50 d-flex justify-content-between align-items-center">
                    <div>
                        <span class="text-white-50 small d-block">Próximo Vencimiento</span>
                        <strong class="text-white">{{ $socio->fecha_vencimiento ? \Carbon\Carbon::parse($socio->fecha_vencimiento)->format('d/m/Y') : 'Al día' }}</strong>
                    </div>
                    <a href="{{ route('portal.pagar') }}" class="btn btn-light btn-sm fw-bold px-3 text-success shadow-sm">
                        <i class="bx bx-credit-card me-1"></i> Pagar Ahora
                    </a>
                </div>
            </div>
        </div>

        <!-- Club Info & Benefits -->
        <div class="card portal-card">
            <div class="card-header bg-white border-bottom py-3">
                <h6 class="mb-0 fw-bold text-dark"><i class="bx bx-award me-1 text-warning"></i> Beneficios de su Membresía</h6>
            </div>
            <div class="card-body">
                <ul class="list-unstyled mb-0 d-flex flex-column gap-2 small">
                    <li class="d-flex align-items-center text-muted">
                        <i class="bx bx-check text-success me-2 fs-5"></i> Acceso ilimitado a canchas y piscina
                    </li>
                    <li class="d-flex align-items-center text-muted">
                        <i class="bx bx-check text-success me-2 fs-5"></i> Reserva prioritaria en gimnasio y spa
                    </li>
                    <li class="d-flex align-items-center text-muted">
                        <i class="bx bx-check text-success me-2 fs-5"></i> Descuentos en restaurante y eventos
                    </li>
                    <li class="d-flex align-items-center text-muted">
                        <i class="bx bx-check text-success me-2 fs-5"></i> Facturación y recibos descargables
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
