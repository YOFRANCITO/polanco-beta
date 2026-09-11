@extends('layouts/contentNavbarLayout')

@section('title', 'Cobro con QR Dinámico - Club Polanco')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold mb-1" style="color: #1a7a3c;">Generador de QR Dinámico</h4>
                <p class="text-muted mb-0 small">Emisión de códigos QR interoperables CoDi / SPEI para cobro en recepción</p>
            </div>
            <a href="{{ route('pagos.index') }}" class="btn btn-outline-secondary">
                <i class="bx bx-arrow-back me-1"></i> Volver a Pagos
            </a>
        </div>

        <div class="row g-4">
            <!-- Form Column -->
            <div class="col-md-7">
                <div class="card shadow-sm border-0">
                    <div class="card-header border-bottom py-3">
                        <h5 class="mb-0 fw-bold"><i class="bx bx-cog me-1 text-primary"></i> Parámetros de Cobro</h5>
                    </div>
                    <div class="card-body pt-4">
                        <form id="qrForm" action="{{ route('pagos.qr.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="referencia" id="inputReferencia" value="CP-QR-{{ strtoupper(substr(uniqid(), -6)) }}">

                            <div class="mb-3">
                                <label class="form-label fw-semibold" for="socio_id">Seleccionar Socio <span class="text-danger">*</span></label>
                                <select class="form-select" id="socio_id" name="socio_id" required onchange="onSocioSelect(this)">
                                    <option value="">-- Seleccionar Socio --</option>
                                    @foreach($socios as $s)
                                    <option value="{{ $s->id }}" 
                                            data-monto="{{ $s->cuota_mensual }}" 
                                            data-nombre="{{ $s->nombre_completo }}"
                                            data-codigo="{{ $s->codigo_acceso }}"
                                            data-cat="{{ ucfirst($s->categoria) }}">
                                        {{ $s->nombre_completo }} ({{ $s->codigo_acceso }}) - ${{ number_format($s->cuota_mensual, 2) }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold" for="monto">Monto a Cobrar ($ MXN) <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text">$</span>
                                        <input type="number" step="0.01" class="form-control fw-bold text-success fs-5" id="monto" name="monto" value="120.00" required oninput="updateQr()">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Referencia Única</label>
                                    <input type="text" class="form-control font-monospace bg-light" id="displayRef" value="" readonly>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-semibold" for="concepto">Concepto del Pago <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="concepto" name="concepto" value="Cuota Mensual Club Polanco" required oninput="updateQr()">
                            </div>

                            <button type="submit" class="btn btn-primary w-100 py-2 fw-bold" style="background-color: #1a7a3c; border-color: #1a7a3c;">
                                <i class="bx bx-check-circle me-1"></i> Confirmar Pago Escaneado y Registrar
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Interactive QR Display Column -->
            <div class="col-md-5">
                <div class="card shadow-sm border-0 text-center h-100">
                    <div class="card-header border-bottom py-3 bg-light">
                        <span class="badge bg-label-success text-uppercase">QR Dinámico en Vivo</span>
                        <div class="small text-muted mt-1" id="timer">Vence en: <strong id="countdown">15:00</strong> min</div>
                    </div>
                    <div class="card-body d-flex flex-column align-items-center justify-content-center py-4">
                        <div class="p-3 bg-white border rounded-4 shadow-sm mb-3">
                            <img id="qrImage" 
                                 src="https://api.qrserver.com/v1/create-qr-code/?size=220x220&data=CLUB-POLANCO|CP-QR-1000|120.00" 
                                 alt="QR Dinámico" 
                                 style="width: 220px; height: 220px;" 
                                 class="img-fluid rounded" />
                        </div>

                        <div class="bg-light p-3 rounded-3 w-100 border text-start small">
                            <div class="d-flex justify-content-between mb-1">
                                <span class="text-muted">Socio:</span>
                                <strong id="qrSocioName">Seleccione un socio</strong>
                            </div>
                            <div class="d-flex justify-content-between mb-1">
                                <span class="text-muted">Monto:</span>
                                <strong class="text-success fs-6" id="qrMontoDisplay">$120.00 MXN</strong>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span class="text-muted">Folio:</span>
                                <span class="font-monospace fw-semibold" id="qrRefDisplay">-</span>
                            </div>
                        </div>

                        <p class="text-muted small mt-3 mb-0">
                            <i class="bx bx-mobile-alt me-1 text-primary"></i> Muestre este código al socio en pantalla o tableta para su escaneo inmediato.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function onSocioSelect(select) {
    const opt = select.options[select.selectedIndex];
    if (opt && opt.value) {
        document.getElementById('monto').value = opt.getAttribute('data-monto');
        document.getElementById('concepto').value = 'Cuota Mensual ' + opt.getAttribute('data-cat') + ' - ' + opt.getAttribute('data-nombre');
        document.getElementById('qrSocioName').innerText = opt.getAttribute('data-nombre');
    } else {
        document.getElementById('qrSocioName').innerText = 'Seleccione un socio';
    }
    updateQr();
}

function updateQr() {
    const ref = document.getElementById('inputReferencia').value;
    const monto = document.getElementById('monto').value || '0.00';
    const concepto = document.getElementById('concepto').value || 'Cuota';
    
    document.getElementById('displayRef').value = ref;
    document.getElementById('qrRefDisplay').innerText = ref;
    document.getElementById('qrMontoDisplay').innerText = '$' + parseFloat(monto).toFixed(2) + ' MXN';

    const qrData = encodeURIComponent(`CLUB-POLANCO|${ref}|${monto}|${concepto}`);
    document.getElementById('qrImage').src = `https://api.qrserver.com/v1/create-qr-code/?size=220x220&data=${qrData}`;
}

document.addEventListener('DOMContentLoaded', () => {
    updateQr();
});
</script>
@endsection
