@extends('layouts/contentNavbarLayout')

@section('title', 'Recibos y Facturas - Club Polanco')

@section('content')
<div class="row g-4 mb-4">
    <!-- Header -->
    <div class="col-12 d-flex flex-wrap justify-content-between align-items-center gap-2">
        <div>
            <h4 class="fw-bold mb-1" style="color: #1a7a3c;">Recibos & Facturación</h4>
            <p class="text-muted mb-0 small">Emisión, consulta e impresión de comprobantes de pago de cuotas</p>
        </div>
        <a href="{{ route('pagos.index') }}" class="btn btn-outline-secondary">
            <i class="bx bx-arrow-back me-1"></i> Volver a Pagos
        </a>
    </div>

    <!-- Table -->
    <div class="col-12">
        <div class="card shadow-sm border-0">
            <div class="card-header pb-2 border-bottom">
                <form method="GET" action="{{ route('pagos.recibos') }}" class="row g-2 align-items-center">
                    <div class="col-md-8">
                        <div class="input-group">
                            <span class="input-group-text"><i class="bx bx-search"></i></span>
                            <input type="text" name="search" class="form-control" placeholder="Buscar comprobante por folio o nombre del socio..." value="{{ request('search') }}">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100" style="background-color: #1a7a3c; border-color: #1a7a3c;">Buscar</button>
                    </div>
                    <div class="col-md-2">
                        <a href="{{ route('pagos.recibos') }}" class="btn btn-outline-secondary w-100">Limpiar</a>
                    </div>
                </form>
            </div>

            <div class="table-responsive text-nowrap">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Folio Recibo</th>
                            <th>Fecha Emisión</th>
                            <th>Socio</th>
                            <th>Concepto</th>
                            <th>Método</th>
                            <th>Total Pagado</th>
                            <th class="text-center">Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recibos as $recibo)
                        <tr>
                            <td>
                                <strong class="font-monospace text-primary">{{ $recibo->referencia ?? ('CP-REC-' . str_pad($recibo->id, 5, '0', STR_PAD_LEFT)) }}</strong>
                            </td>
                            <td>
                                <strong>{{ \Carbon\Carbon::parse($recibo->fecha_pago)->format('d/m/Y') }}</strong>
                            </td>
                            <td>
                                @if($recibo->socio)
                                <div class="fw-semibold text-dark">{{ $recibo->socio->nombre_completo }}</div>
                                <small class="text-muted">{{ $recibo->socio->codigo_acceso }} • {{ ucfirst($recibo->socio->categoria) }}</small>
                                @else
                                <span class="text-muted">Socio no asignado</span>
                                @endif
                            </td>
                            <td>{{ $recibo->concepto }}</td>
                            <td>
                                <span class="badge {{ $recibo->metodo_badge }}">
                                    <i class="{{ $recibo->metodo_icon }} me-1"></i> {{ $recibo->metodo_label }}
                                </span>
                            </td>
                            <td>
                                <strong class="fs-6 text-success">${{ number_format($recibo->monto, 2) }} MXN</strong>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('pagos.recibo.show', $recibo) }}" class="btn btn-sm btn-outline-primary" target="_blank">
                                    <i class="bx bx-printer me-1"></i> Ver / Imprimir
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                <i class="bx bx-receipt fs-1 d-block mb-2"></i>
                                No se encontraron recibos emitidos.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($recibos->hasPages())
            <div class="card-footer py-2 border-top">
                {{ $recibos->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
