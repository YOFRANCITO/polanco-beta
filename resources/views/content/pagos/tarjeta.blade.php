@extends('layouts/contentNavbarLayout')

@section('title', 'TPV Tarjeta Virtual - Club Polanco')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold mb-1" style="color: #1a7a3c;">Terminal Punto de Venta (TPV Virtual)</h4>
                <p class="text-muted mb-0 small">Procesamiento de cobros directos con tarjeta de crédito o débito en ventanilla</p>
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
                        <h5 class="mb-0 fw-bold"><i class="bx bx-credit-card me-1 text-primary"></i> Datos del Cobro con Tarjeta</h5>
                    </div>
                    <div class="card-body pt-4">
                        <form action="{{ route('pagos.tarjeta.store') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label fw-semibold" for="socio_id">Socio <span class="text-danger">*</span></label>
                                <select class="form-select" id="socio_id" name="socio_id" required onchange="onSocioCardSelect(this)">
                                    <option value="">-- Seleccionar Socio --</option>
                                    @foreach($socios as $s)
                                    <option value="{{ $s->id }}" 
                                            data-monto="{{ $s->cuota_mensual }}" 
                                            data-nombre="{{ $s->nombre_completo }}">
                                        {{ $s->nombre_completo }} ({{ $s->codigo_acceso }}) - ${{ number_format($s->cuota_mensual, 2) }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold" for="monto">Importe ($ MXN) <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text">$</span>
                                        <input type="number" step="0.01" class="form-control fw-bold text-success fs-5" id="monto" name="monto" value="180.00" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold" for="concepto">Concepto <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="concepto" name="concepto" value="Cuota Mensual Membresía" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold" for="titular">Nombre del Titular <span class="text-danger">*</span></label>
                                <input type="text" class="form-control text-uppercase" id="titular" name="titular" placeholder="NOMBRE APELLIDO" required oninput="document.getElementById('cardHolderDisplay').innerText = this.value || 'NOMBRE DEL TITULAR'">
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold" for="numero_tarjeta">Número de Tarjeta <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bx bx-credit-card"></i></span>
                                    <input type="text" class="form-control font-monospace" id="numero_tarjeta" name="numero_tarjeta" placeholder="4532 •••• •••• 4242" maxlength="19" required oninput="formatCardNumber(this)">
                                </div>
                            </div>

                            <div class="row g-3 mb-4">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold" for="expiracion">Vencimiento (MM/AA) <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control text-center" id="expiracion" name="expiracion" placeholder="12/28" maxlength="5" required oninput="document.getElementById('cardExpDisplay').innerText = this.value || 'MM/AA'">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold" for="cvv">CVV <span class="text-danger">*</span></label>
                                    <input type="password" class="form-control text-center font-monospace" id="cvv" name="cvv" placeholder="•••" maxlength="4" required>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 py-2 fw-bold" style="background-color: #1a7a3c; border-color: #1a7a3c;">
                                <i class="bx bx-check-shield me-1"></i> Procesar Cobro con Tarjeta
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Visual Credit Card Column -->
            <div class="col-md-5">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-header border-bottom py-3 bg-light">
                        <span class="badge bg-label-primary text-uppercase">Vista Previa de Tarjeta</span>
                    </div>
                    <div class="card-body d-flex flex-column align-items-center justify-content-center py-4">
                        <!-- Plastic Card Mockup -->
                        <div class="p-4 rounded-4 shadow-lg text-white w-100" style="background: linear-gradient(135deg, #114b25 0%, #1a7a3c 50%, #c9a84c 100%); min-height: 200px; position: relative;">
                            <div class="d-flex justify-content-between align-items-start mb-4">
                                <span class="fw-bold tracking-wide">CLUB POLANCO</span>
                                <i class="bx bxl-visa fs-1 lh-1"></i>
                            </div>

                            <div class="font-monospace fs-4 tracking-widest my-3" id="cardNumberDisplay">
                                •••• •••• •••• ••••
                            </div>

                            <div class="d-flex justify-content-between align-items-end mt-3 text-uppercase font-monospace small">
                                <div>
                                    <span class="text-white-50 d-block" style="font-size: 0.65rem;">TITULAR</span>
                                    <strong id="cardHolderDisplay">NOMBRE DEL TITULAR</strong>
                                </div>
                                <div>
                                    <span class="text-white-50 d-block" style="font-size: 0.65rem;">VENCE</span>
                                    <strong id="cardExpDisplay">MM/AA</strong>
                                </div>
                            </div>
                        </div>

                        <!-- Card helper quick fills -->
                        <div class="mt-4 w-100">
                            <button type="button" class="btn btn-xs btn-outline-secondary w-100 mb-2" onclick="testVisa()">
                                <i class="bx bx-magic-wand me-1"></i> Cargar Tarjeta Visa de Prueba
                            </button>
                            <small class="text-muted text-center d-block" style="font-size: 0.72rem;">
                                Transacción de prueba con tokenización bancaria segura.
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function onSocioCardSelect(select) {
    const opt = select.options[select.selectedIndex];
    if (opt && opt.value) {
        document.getElementById('monto').value = opt.getAttribute('data-monto');
        document.getElementById('titular').value = opt.getAttribute('data-nombre').toUpperCase();
        document.getElementById('cardHolderDisplay').innerText = opt.getAttribute('data-nombre').toUpperCase();
    }
}

function formatCardNumber(input) {
    let val = input.value.replace(/\D/g, '').substring(0, 16);
    let formatted = val.match(/.{1,4}/g)?.join(' ') || val;
    input.value = formatted;
    document.getElementById('cardNumberDisplay').innerText = formatted || '•••• •••• •••• ••••';
}

function testVisa() {
    document.getElementById('numero_tarjeta').value = '4242 4242 4242 4242';
    document.getElementById('cardNumberDisplay').innerText = '4242 4242 4242 4242';
    document.getElementById('expiracion').value = '12/28';
    document.getElementById('cardExpDisplay').innerText = '12/28';
    document.getElementById('cvv').value = '789';
}
</script>
@endsection
