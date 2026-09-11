@extends('layouts/contentNavbarLayout')

@section('title', 'Recordatorios & Cumpleaños - Club Polanco')

@section('content')
<div class="row g-4 mb-4">
    <!-- Header -->
    <div class="col-12 d-flex flex-wrap justify-content-between align-items-center gap-2">
        <div>
            <h4 class="fw-bold mb-1" style="color: #1a7a3c;">Recordatorios de Cobro & Cumpleaños</h4>
            <p class="text-muted mb-0 small">Seguimiento proactivo de cuotas por vencer y atenciones personalizadas a socios</p>
        </div>
        <a href="{{ route('crm.mensajes') }}" class="btn btn-outline-success">
            <i class="bx bxl-whatsapp me-1"></i> Ir a Bandeja de Mensajes
        </a>
    </div>

    <!-- Seccion 1: Cobranza y Vencimientos -->
    <div class="col-lg-7">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-2">
                    <span class="avatar avatar-xs bg-label-warning rounded">
                        <i class="bx bx-bell"></i>
                    </span>
                    <h6 class="mb-0 fw-bold">Socios por Vencer o Vencidos ({{ $sociosPorCobrar->count() }})</h6>
                </div>
                <span class="badge bg-label-warning">Prioridad Cobranza</span>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Socio</th>
                            <th>Vencimiento</th>
                            <th>Cuota</th>
                            <th class="text-center">Acción WhatsApp</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sociosPorCobrar as $s)
                        @php
                            $msgCobro = "Hola {$s->nombre}, le saludamos de Club Polanco. Le recordamos amablemente que su membresía mensual de \${$s->cuota_mensual} se encuentra próxima a vencer o vencida. Puede pagarla en línea o en recepción.";
                        @endphp
                        <tr>
                            <td>
                                <div class="fw-semibold text-dark">{{ $s->nombre_completo }}</div>
                                <small class="text-muted">{{ $s->codigo_acceso }} • +{{ $s->telefono }}</small>
                            </td>
                            <td>
                                @if($s->estado === 'moroso')
                                <span class="badge bg-label-danger"><i class="bx bx-error-circle me-1"></i> Vencido</span>
                                @else
                                <span class="badge bg-label-warning">{{ $s->fecha_vencimiento ? \Carbon\Carbon::parse($s->fecha_vencimiento)->format('d/m/Y') : 'Próximo' }}</span>
                                @endif
                            </td>
                            <td><strong class="text-success">${{ number_format($s->cuota_mensual, 2) }}</strong></td>
                            <td class="text-center">
                                @if($s->telefono)
                                <a href="https://wa.me/{{ preg_replace('/\D/', '', $s->telefono) }}?text={{ urlencode($msgCobro) }}" 
                                   target="_blank" 
                                   class="btn btn-sm btn-success" 
                                   style="background-color: #25D366; border-color: #25D366;">
                                    <i class="bx bxl-whatsapp me-1"></i> Cobrar
                                </a>
                                @else
                                <span class="badge bg-label-secondary">Sin teléfono</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-4 text-muted small">
                                <i class="bx bx-check-double text-success fs-3 d-block mb-1"></i>
                                Todos los socios se encuentran al corriente.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Seccion 2: Cumpleañeros del Mes -->
    <div class="col-lg-5">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-2">
                    <span class="avatar avatar-xs bg-label-info rounded">
                        <i class="bx bx-cake"></i>
                    </span>
                    <h6 class="mb-0 fw-bold">Cumpleaños de este Mes ({{ $cumpleanerosMes->count() }})</h6>
                </div>
                <span class="badge bg-label-info">{{ now()->translatedFormat('F') }}</span>
            </div>

            <div class="card-body p-0">
                <ul class="list-group list-group-flush">
                    @forelse($cumpleanerosMes as $s)
                    @php
                        $dia = \Carbon\Carbon::parse($s->fecha_nacimiento)->format('d');
                        $esHoy = \Carbon\Carbon::parse($s->fecha_nacimiento)->day === now()->day;
                        $msgCumple = "¡Feliz Cumpleaños {$s->nombre}! Todo el equipo de Club Polanco le desea un día formidable. Le esperamos en el club para obsequiarle una cortesía especial.";
                    @endphp
                    <li class="list-group-item d-flex justify-content-between align-items-center py-3 {{ $esHoy ? 'bg-light-success' : '' }}">
                        <div class="d-flex align-items-center">
                            <div class="avatar avatar-sm me-3">
                                <span class="avatar-initial rounded-circle {{ $esHoy ? 'bg-success text-white' : 'bg-label-info' }} fw-bold">
                                    {{ $dia }}
                                </span>
                            </div>
                            <div>
                                <h6 class="mb-0 fw-semibold text-dark">
                                    {{ $s->nombre_completo }}
                                    @if($esHoy)
                                    <span class="badge bg-label-danger ms-1">¡HOY! 🎂</span>
                                    @endif
                                </h6>
                                <small class="text-muted">+{{ $s->telefono }} • {{ ucfirst($s->categoria) }}</small>
                            </div>
                        </div>

                        @if($s->telefono)
                        <a href="https://wa.me/{{ preg_replace('/\D/', '', $s->telefono) }}?text={{ urlencode($msgCumple) }}" 
                           target="_blank" 
                           class="btn btn-xs btn-outline-success" 
                           title="Felicitar por WhatsApp">
                            <i class="bx bxl-whatsapp me-1"></i> Felicitar
                        </a>
                        @endif
                    </li>
                    @empty
                    <li class="list-group-item text-center py-4 text-muted small">
                        No hay socios que cumplan años durante este mes.
                    </li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
