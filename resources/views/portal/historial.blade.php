@extends('portal.layout')

@section('title', 'Historial de Pagos - Portal de Socios Club Polanco')

@section('content')
<div class="row g-4">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <div>
            <h4 class="fw-bold mb-1" style="color: #1a7a3c;">Mi Historial de Pagos</h4>
            <p class="text-muted mb-0 small">Consulte sus recibos y comprobantes de membresía mensual</p>
        </div>
        <a href="{{ route('portal.pagar') }}" class="btn btn-primary" style="background-color: #1a7a3c; border-color: #1a7a3c;">
            <i class="bx bx-credit-card me-1"></i> Realizar Nuevo Pago
        </a>
    </div>

    <!-- Payment History Card -->
    <div class="col-12">
        <div class="card portal-card">
            <div class="table-responsive text-nowrap">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Fecha</th>
                            <th>Folio / Referencia</th>
                            <th>Concepto</th>
                            <th>Método</th>
                            <th>Monto Pagado</th>
                            <th>Estado</th>
                            <th class="text-center">Comprobante</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pagos as $pago)
                        <tr>
                            <td>
                                <strong>{{ \Carbon\Carbon::parse($pago->fecha_pago)->format('d/m/Y') }}</strong>
                                <span class="text-muted small d-block">{{ $pago->created_at->format('H:i') }} hrs</span>
                            </td>
                            <td>
                                <span class="badge bg-label-secondary font-monospace">{{ $pago->referencia ?? 'S/R' }}</span>
                            </td>
                            <td>
                                <div class="fw-semibold text-dark">{{ $pago->concepto }}</div>
                                @if($pago->notas)
                                <small class="text-muted">{{ $pago->notas }}</small>
                                @endif
                            </td>
                            <td>
                                <span class="badge {{ $pago->metodo_badge }}">
                                    <i class="{{ $pago->metodo_icon }} me-1"></i> {{ $pago->metodo_label }}
                                </span>
                            </td>
                            <td>
                                <strong class="fs-6 text-success">${{ number_format($pago->monto, 2) }} <small class="text-muted">MXN</small></strong>
                            </td>
                            <td>
                                <span class="badge {{ $pago->estado_badge }}">{{ $pago->estado_label }}</span>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('portal.recibo', $pago) }}" class="btn btn-sm btn-outline-primary" target="_blank">
                                    <i class="bx bx-receipt me-1"></i> Ver Recibo
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                <i class="bx bx-receipt fs-1 d-block mb-2"></i>
                                Aún no tiene pagos registrados en su historial.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($pagos->hasPages())
            <div class="card-footer py-2 bg-white border-top">
                {{ $pagos->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
