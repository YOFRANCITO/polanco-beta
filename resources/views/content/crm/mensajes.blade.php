@extends('layouts/contentNavbarLayout')

@section('title', 'WhatsApp & Mensajes CRM - Club Polanco')

@section('content')
<div class="row g-4 mb-4">
    <!-- Header -->
    <div class="col-12 d-flex flex-wrap justify-content-between align-items-center gap-2">
        <div>
            <h4 class="fw-bold mb-1" style="color: #1a7a3c;">Bandeja de Mensajes WhatsApp CRM</h4>
            <p class="text-muted mb-0 small">Comunicación directa, avisos de membresía y notificaciones a socios vía WhatsApp</p>
        </div>
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalNuevoMensaje" style="background-color: #25D366; border-color: #25D366; color: #fff;">
            <i class="bx bxl-whatsapp fs-5 align-middle me-1"></i> Redactar WhatsApp
        </button>
    </div>

    <!-- Alert Messages & WhatsApp Web Launch helper -->
    @if(session('success'))
    <div class="col-12">
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                <div>
                    <i class="bx bx-check-circle me-1"></i> {{ session('success') }}
                </div>
                @if(session('wa_url'))
                <a href="{{ session('wa_url') }}" target="_blank" class="btn btn-sm btn-dark">
                    <i class="bx bxl-whatsapp me-1 text-success"></i> Abrir Chat en WhatsApp Web
                </a>
                @endif
            </div>
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
                        <span class="fw-semibold d-block mb-1 text-muted">Total Enviados</span>
                        <h3 class="card-title mb-0">{{ $stats['total'] }}</h3>
                    </div>
                    <div class="avatar avatar-md">
                        <span class="avatar-initial rounded bg-label-success">
                            <i class="bx bxl-whatsapp fs-3"></i>
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
                        <span class="fw-semibold d-block mb-1 text-muted">Avisos de Cobro</span>
                        <h3 class="card-title mb-0 text-warning">{{ $stats['recordatorios'] }}</h3>
                    </div>
                    <div class="avatar avatar-md">
                        <span class="avatar-initial rounded bg-label-warning">
                            <i class="bx bx-bell fs-3"></i>
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
                        <span class="fw-semibold d-block mb-1 text-muted">Cumpleaños</span>
                        <h3 class="card-title mb-0 text-info">{{ $stats['cumpleanos'] }}</h3>
                    </div>
                    <div class="avatar avatar-md">
                        <span class="avatar-initial rounded bg-label-info">
                            <i class="bx bx-cake fs-3"></i>
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
                        <span class="fw-semibold d-block mb-1 text-muted">Entregados</span>
                        <h3 class="card-title mb-0 text-primary">{{ $stats['enviados'] }}</h3>
                    </div>
                    <div class="avatar avatar-md">
                        <span class="avatar-initial rounded bg-label-primary">
                            <i class="bx bx-check-double fs-3"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Messages Table & Filter -->
    <div class="col-12">
        <div class="card shadow-sm border-0">
            <div class="card-header pb-2 border-bottom">
                <form method="GET" action="{{ route('crm.mensajes') }}" class="row g-2 align-items-center">
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-text"><i class="bx bx-search"></i></span>
                            <input type="text" name="search" class="form-control" placeholder="Buscar por socio, teléfono o texto del mensaje..." value="{{ request('search') }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <select name="tipo" class="form-select" onchange="this.form.submit()">
                            <option value="">Todos los Tipos de Mensajes</option>
                            <option value="recordatorio_pago" {{ request('tipo') == 'recordatorio_pago' ? 'selected' : '' }}>Recordatorio de Cobro</option>
                            <option value="cumpleanos" {{ request('tipo') == 'cumpleanos' ? 'selected' : '' }}>Cumpleaños</option>
                            <option value="bienvenida" {{ request('tipo') == 'bienvenida' ? 'selected' : '' }}>Bienvenida</option>
                            <option value="aviso" {{ request('tipo') == 'aviso' ? 'selected' : '' }}>Aviso General</option>
                        </select>
                    </div>
                    <div class="col-md-2 text-end">
                        <a href="{{ route('crm.mensajes') }}" class="btn btn-outline-secondary w-100">Limpiar</a>
                    </div>
                </form>
            </div>

            <div class="table-responsive text-nowrap">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Fecha</th>
                            <th>Destinatario</th>
                            <th>Tipo</th>
                            <th>Mensaje WhatsApp</th>
                            <th>Estado</th>
                            <th class="text-center">Abrir Chat</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($mensajes as $msg)
                        <tr>
                            <td>
                                <strong>{{ $msg->created_at->format('d/m/Y') }}</strong>
                                <small class="text-muted d-block">{{ $msg->created_at->format('H:i') }} hrs</small>
                            </td>
                            <td>
                                @if($msg->socio)
                                <div class="fw-semibold text-dark">{{ $msg->socio->nombre_completo }}</div>
                                <small class="text-muted"><i class="bx bxl-whatsapp text-success"></i> +{{ $msg->telefono }}</small>
                                @else
                                <span class="fw-semibold text-dark">+{{ $msg->telefono }}</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge {{ $msg->tipo_badge }}">{{ $msg->tipo_label }}</span>
                            </td>
                            <td>
                                <div class="text-wrap small text-dark" style="max-width: 380px;">
                                    {{ $msg->mensaje }}
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-label-success">
                                    <i class="bx bx-check-double me-1"></i> {{ ucfirst($msg->estado) }}
                                </span>
                            </td>
                            <td class="text-center">
                                <a href="https://wa.me/{{ preg_replace('/\D/', '', $msg->telefono) }}?text={{ urlencode($msg->mensaje) }}" 
                                   target="_blank" 
                                   class="btn btn-sm btn-icon btn-outline-success" 
                                   title="Abrir WhatsApp">
                                    <i class="bx bxl-whatsapp fs-5"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="bx bxl-whatsapp fs-1 text-success d-block mb-2"></i>
                                No hay mensajes registrados en este momento.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($mensajes->hasPages())
            <div class="card-footer py-2 border-top">
                {{ $mensajes->links() }}
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Modal Redactar Mensaje -->
<div class="modal fade" id="modalNuevoMensaje" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-light border-bottom">
                <h5 class="modal-title fw-bold text-success">
                    <i class="bx bxl-whatsapp fs-4 align-middle me-1"></i> Nuevo Mensaje de WhatsApp
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('crm.mensajes.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold" for="socioSelect">Seleccionar Socio (Opcional)</label>
                        <select class="form-select" id="socioSelect" name="socio_id" onchange="onSocioMsgSelect(this)">
                            <option value="">-- Destinatario manual o seleccionar socio --</option>
                            @foreach($socios as $s)
                            <option value="{{ $s->id }}" 
                                    data-tel="{{ $s->telefono }}" 
                                    data-nombre="{{ $s->nombre }}"
                                    data-cuota="{{ $s->cuota_mensual }}">
                                {{ $s->nombre_completo }} (+{{ $s->telefono }})
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold" for="inputTelefono">Número de WhatsApp (con código país) <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bx bxl-whatsapp text-success"></i></span>
                            <input type="text" class="form-control" id="inputTelefono" name="telefono" placeholder="525512345678" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold" for="selectTipo">Tipo de Notificación <span class="text-danger">*</span></label>
                        <select class="form-select" id="selectTipo" name="tipo" required onchange="applyTemplate(this.value)">
                            <option value="recordatorio_pago">Recordatorio de Cobro de Membresía</option>
                            <option value="cumpleanos">Felicitación de Cumpleaños & Beneficio</option>
                            <option value="bienvenida">Bienvenida a Club Polanco</option>
                            <option value="aviso">Aviso General</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold" for="textMensaje">Contenido del Mensaje <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="textMensaje" name="mensaje" rows="4" required placeholder="Escriba aquí el mensaje..."></textarea>
                    </div>
                </div>
                <div class="modal-footer bg-light border-top">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success" style="background-color: #25D366; border-color: #25D366;">
                        <i class="bx bx-paper-plane me-1"></i> Registrar y Abrir WhatsApp
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
let currentNombre = 'Socio';
let currentCuota = '120.00';

function onSocioMsgSelect(select) {
    const opt = select.options[select.selectedIndex];
    if (opt && opt.value) {
        document.getElementById('inputTelefono').value = opt.getAttribute('data-tel');
        currentNombre = opt.getAttribute('data-nombre');
        currentCuota = opt.getAttribute('data-cuota');
    }
    applyTemplate(document.getElementById('selectTipo').value);
}

function applyTemplate(type) {
    const txt = document.getElementById('textMensaje');
    if (type === 'recordatorio_pago') {
        txt.value = `Hola ${currentNombre}, le saludamos cordialmente de Club Polanco. Le recordamos amablemente que su membresía mensual de $${currentCuota} MXN se encuentra próxima a vencer. Puede liquidarla fácilmente vía QR o tarjeta en su portal de socio.`;
    } else if (type === 'cumpleanos') {
        txt.value = `¡Feliz Cumpleaños ${currentNombre}! Todo el equipo de Club Polanco le desea un día formidable. Le esperamos hoy en el club para obsequiarle una cortesía especial en nuestro restaurante.`;
    } else if (type === 'bienvenida') {
        txt.value = `¡Bienvenido(a) a Club Polanco ${currentNombre}! Su membresía ha sido dada de alta con éxito. Ya puede disfrutar de todas las instalaciones, canchas y amenidades.`;
    } else {
        txt.value = `Estimado socio(a) ${currentNombre}, le compartimos este aviso de interés sobre las actividades y servicios de Club Polanco.`;
    }
}

document.addEventListener('DOMContentLoaded', () => {
    applyTemplate('recordatorio_pago');
});
</script>
@endsection
