@extends('layouts/contentNavbarLayout')

@section('title', 'Automatización de Mensajería CRM - Club Polanco')

@section('content')
<div class="row g-4 mb-4">
    <!-- Header -->
    <div class="col-12 d-flex flex-wrap justify-content-between align-items-center gap-2">
        <div>
            <h4 class="fw-bold mb-1" style="color: #1a7a3c;">Automatización de Cobranza y Mensajes</h4>
            <p class="text-muted mb-0 small">Disparadores automáticos de recordatorios de pago y saludos de cumpleaños</p>
        </div>
        <form action="{{ route('crm.automatizacion.ejecutar') }}" method="POST" onsubmit="return confirm('¿Desea ejecutar ahora la verificación automática de cobros y cumpleaños para enviar avisos pendientes?');">
            @csrf
            <button type="submit" class="btn btn-primary" style="background-color: #1a7a3c; border-color: #1a7a3c;">
                <i class="bx bx-play-circle me-1"></i> Disparar Reglas Automáticas Ahora
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

    <!-- Rules List -->
    @foreach($reglas as $r)
    <div class="col-md-6">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header border-bottom py-3 d-flex justify-content-between align-items-center bg-white">
                <div class="d-flex align-items-center gap-2">
                    <span class="avatar avatar-xs bg-label-success rounded">
                        <i class="bx bxl-whatsapp"></i>
                    </span>
                    <h6 class="mb-0 fw-bold text-dark">{{ $r['nombre'] }}</h6>
                </div>
                <span class="badge bg-label-success"><i class="bx bx-check-circle me-1"></i> {{ $r['estado'] }}</span>
            </div>
            <div class="card-body pt-3">
                <div class="mb-2 small">
                    <span class="text-muted fw-semibold">Disparador (Trigger):</span>
                    <span class="badge bg-label-info ms-1">{{ $r['gatillo'] }}</span>
                </div>
                <div class="mb-3 small">
                    <span class="text-muted fw-semibold">Canal:</span>
                    <span class="badge bg-label-secondary ms-1">{{ $r['canal'] }}</span>
                </div>

                <div class="p-3 bg-light rounded-3 border">
                    <span class="text-muted small fw-semibold d-block mb-1">Plantilla del Mensaje:</span>
                    <p class="small text-dark font-monospace mb-0" style="font-size: 0.82rem;">
                        {{ $r['plantilla'] }}
                    </p>
                </div>
            </div>
            <div class="card-footer bg-white border-top py-2 d-flex justify-content-between align-items-center small text-muted">
                <span><i class="bx bx-bot me-1 text-primary"></i> Tarea programada activa</span>
                <span class="text-success fw-semibold">Activa 24/7</span>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection
