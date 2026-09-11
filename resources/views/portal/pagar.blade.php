@extends('portal.layout')

@section('title', 'Pagar Membresía - Portal de Socios Club Polanco')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-9">
        <!-- Header summary -->
        <div class="card portal-card mb-4 overflow-hidden border-0 shadow-sm" style="background: linear-gradient(135deg, #1a7a3c 0%, #0d4a23 100%);">
            <div class="card-body p-4 text-white">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                    <div>
                        <span class="text-white-50 small text-uppercase fw-bold">Pago de Membresía Mensual</span>
                        <h3 class="text-white fw-bold mb-1">{{ $socio->nombre_completo }}</h3>
                        <div class="d-flex gap-2 align-items-center">
                            <span class="badge bg-white text-dark text-uppercase">{{ $socio->categoria }}</span>
                            <span class="text-white-50 small">Código: <strong>{{ $socio->codigo_acceso }}</strong></span>
                        </div>
                    </div>
                    <div class="text-md-end bg-white bg-opacity-10 p-3 rounded-3">
                        <span class="text-white-50 small d-block">Monto a Liquidar</span>
                        <h2 class="text-white fw-bold mb-0">${{ number_format($socio->cuota_mensual, 2) }} <small class="fs-6 text-white-50">MXN</small></h2>
                    </div>
                </div>
            </div>
        </div>

        <!-- Payment Methods Tabs -->
        <div class="card portal-card shadow-sm border-0">
            <div class="card-header bg-white border-bottom p-0">
                <ul class="nav nav-tabs nav-fill" role="tablist">
                    <li class="nav-item">
                        <button class="nav-link active py-3 fw-bold fs-6" data-bs-toggle="tab" data-bs-target="#tab-qr" type="button" role="tab">
                            <i class="bx bx-qr-scan me-2 text-primary fs-5"></i> Pago con QR Dinámico (CoDi / SPEI)
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link py-3 fw-bold fs-6" data-bs-toggle="tab" data-bs-target="#tab-tarjeta" type="button" role="tab">
                            <i class="bx bx-credit-card me-2 text-primary fs-5"></i> Pago con Tarjeta de Débito / Crédito
                        </button>
                    </li>
                </ul>
            </div>

            <div class="card-body p-4">
                <div class="tab-content">
                    <!-- Tab QR Dinámico -->
                    <div class="tab-pane fade show active" id="tab-qr" role="tabpanel">
                        <div class="row align-items-center g-4">
                            <div class="col-md-5 text-center">
                                <div class="p-3 bg-light rounded-4 d-inline-block border shadow-sm">
                                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data={{ urlencode('CLUB-POLANCO|' . $referenciaQr . '|' . $socio->cuota_mensual . '|' . $socio->codigo_acceso) }}" 
                                         alt="QR de Pago Club Polanco" 
                                         class="img-fluid rounded-3" 
                                         style="width: 200px; height: 200px;" />
                                </div>
                                <div class="mt-2 font-monospace small text-muted">
                                    Ref: <strong>{{ $referenciaQr }}</strong>
                                </div>
                            </div>

                            <div class="col-md-7">
                                <h5 class="fw-bold text-dark mb-2">Escanee con su App Bancaria</h5>
                                <p class="text-muted small mb-3">
                                    Abra su aplicación bancaria móvil (BBVA, Santander, Banorte, Citibanamex u otra compatible con CoDi / QR) y apunte al código para liquidar su cuota al instante.
                                </p>

                                <div class="bg-light p-3 rounded-3 mb-3 border">
                                    <div class="d-flex justify-content-between mb-1 small">
                                        <span class="text-muted">Concepto:</span>
                                        <span class="fw-semibold">Cuota Mensual {{ ucfirst($socio->categoria) }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-1 small">
                                        <span class="text-muted">Beneficiario:</span>
                                        <span class="fw-semibold">Club Polanco S.A. de C.V.</span>
                                    </div>
                                    <div class="d-flex justify-content-between small">
                                        <span class="text-muted">Total a Pagar:</span>
                                        <strong class="text-success fs-6">${{ number_format($socio->cuota_mensual, 2) }} MXN</strong>
                                    </div>
                                </div>

                                <form action="{{ route('portal.pagar.qr') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="referencia" value="{{ $referenciaQr }}">
                                    <button type="submit" class="btn btn-success w-100 py-2 fw-bold shadow-sm" style="background-color: #1a7a3c; border-color: #1a7a3c;">
                                        <i class="bx bx-check-circle me-1"></i> Simular Escaneo y Confirmar Pago
                                    </button>
                                </form>
                                <small class="text-muted text-center d-block mt-2" style="font-size: 0.72rem;">
                                    <i class="bx bx-shield-quarter me-1"></i> Verificación criptográfica instantánea segura
                                </small>
                            </div>
                        </div>
                    </div>

                    <!-- Tab Tarjeta -->
                    <div class="tab-pane fade" id="tab-tarjeta" role="tabpanel">
                        <form action="{{ route('portal.pagar.tarjeta') }}" method="POST">
                            @csrf
                            <div class="row g-3">
                                <div class="col-md-12">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <label class="form-label mb-0 fw-semibold" for="titular">Nombre del Titular</label>
                                        <div class="text-muted small">
                                            <i class="bx bxl-visa fs-4 align-middle text-primary"></i>
                                            <i class="bx bxl-mastercard fs-4 align-middle text-danger"></i>
                                        </div>
                                    </div>
                                    <input type="text" id="titular" name="titular" class="form-control" value="{{ old('titular', $socio->nombre_completo) }}" required placeholder="Como aparece en la tarjeta">
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label fw-semibold" for="numero_tarjeta">Número de Tarjeta</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bx bx-credit-card"></i></span>
                                        <input type="text" id="numero_tarjeta" name="numero_tarjeta" class="form-control font-monospace" placeholder="4520 1234 5678 9010" maxlength="19" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-semibold" for="expiracion">Vencimiento (MM/AA)</label>
                                    <input type="text" id="expiracion" name="expiracion" class="form-control text-center" placeholder="12/28" maxlength="5" required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-semibold" for="cvv">Código de Seguridad (CVV)</label>
                                    <input type="password" id="cvv" name="cvv" class="form-control text-center" placeholder="•••" maxlength="4" required>
                                </div>

                                <div class="col-12 mt-4">
                                    <button type="submit" class="btn btn-primary w-100 py-2 fw-bold shadow-sm" style="background-color: #1a7a3c; border-color: #1a7a3c;">
                                        <i class="bx bx-lock-alt me-1"></i> Pagar ${{ number_format($socio->cuota_mensual, 2) }} MXN con Tarjeta
                                    </button>
                                </div>
                            </div>
                        </form>

                        <div class="text-center mt-3 small text-muted">
                            <i class="bx bx-check-shield text-success me-1"></i> Transacción protegida con cifrado SSL de 256 bits. No almacenamos los datos de su tarjeta.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
