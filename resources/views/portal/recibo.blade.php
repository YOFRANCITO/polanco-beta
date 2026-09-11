<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Recibo de Pago {{ $pago->referencia ?? $pago->id }} - Club Polanco</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@2.1.4/css/boxicons.min.css">
    <style>
        body {
            background-color: #f5f5f9;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            color: #333;
        }
        .receipt-card {
            max-width: 680px;
            margin: 40px auto;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            border: 1px solid #e0e0e0;
        }
        .stamp-paid {
            border: 2px dashed #1a7a3c;
            color: #1a7a3c;
            text-transform: uppercase;
            font-weight: 800;
            padding: 6px 14px;
            border-radius: 6px;
            display: inline-block;
            transform: rotate(-5deg);
        }
        @media print {
            body { background: #fff; }
            .receipt-card { border: none; box-shadow: none; margin: 0; }
            .no-print { display: none !important; }
        }
    </style>
</head>
<body>
    <div class="container py-4">
        <div class="receipt-card p-4 p-md-5">
            <!-- Action buttons for screen -->
            <div class="no-print d-flex justify-content-between mb-4 pb-3 border-bottom">
                <a href="{{ route('portal.historial') }}" class="btn btn-sm btn-outline-secondary">
                    <i class="bx bx-arrow-back me-1"></i> Volver a Mi Historial
                </a>
                <button onclick="window.print()" class="btn btn-sm btn-primary" style="background-color: #1a7a3c; border-color: #1a7a3c;">
                    <i class="bx bx-printer me-1"></i> Imprimir Comprobante
                </button>
            </div>

            <!-- Header -->
            <div class="d-flex justify-content-between align-items-start mb-4">
                <div>
                    <h3 class="fw-bold mb-0" style="color: #1a7a3c;">CLUB POLANCO</h3>
                    <p class="text-muted small mb-0">Deporte, Recreación y Entretenimiento Exclusivo</p>
                    <p class="text-muted small mb-0">RFC: CPO-230910-AA1 • Polanco, CDMX</p>
                </div>
                <div class="text-end">
                    <span class="badge bg-light text-dark font-monospace fs-6 px-3 py-2 border">
                        FOLIO: {{ $pago->referencia ?? ('CP-REC-' . str_pad($pago->id, 5, '0', STR_PAD_LEFT)) }}
                    </span>
                    <div class="mt-2">
                        <span class="stamp-paid"><i class="bx bx-check-double me-1"></i> {{ strtoupper($pago->estado) }}</span>
                    </div>
                </div>
            </div>

            <hr>

            <!-- Socio Details -->
            <div class="row my-4 g-3">
                <div class="col-sm-6">
                    <span class="text-muted small d-block">DATOS DEL SOCIO:</span>
                    <strong class="fs-5 text-dark">{{ $socio->nombre_completo }}</strong>
                    <div class="text-muted small">Cód. Socio: <strong>{{ $socio->codigo_acceso }}</strong></div>
                    <div class="text-muted small">Cédula: {{ $socio->cedula }}</div>
                    <div class="text-muted small">Categoría: <span class="badge bg-light text-dark text-uppercase border">{{ $socio->categoria }}</span></div>
                </div>
                <div class="col-sm-6 text-sm-end">
                    <span class="text-muted small d-block">DETALLES DEL RECIBO:</span>
                    <div>Fecha de Emisión: <strong>{{ \Carbon\Carbon::parse($pago->fecha_pago)->format('d/m/Y') }}</strong></div>
                    <div>Método de Pago: <strong>{{ $pago->metodo_label }}</strong></div>
                    <div>Hora: {{ $pago->created_at->format('H:i:s') }} hrs</div>
                </div>
            </div>

            <!-- Table breakdown -->
            <table class="table table-bordered my-4">
                <thead class="table-light">
                    <tr>
                        <th>Descripción</th>
                        <th class="text-center" style="width: 100px;">Cant.</th>
                        <th class="text-end" style="width: 140px;">Importe</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <strong>{{ $pago->concepto }}</strong>
                            <div class="text-muted small">Membresía mensual Club Polanco - Renovación por 30 días</div>
                        </td>
                        <td class="text-center">1</td>
                        <td class="text-end">${{ number_format($pago->monto, 2) }}</td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="2" class="text-end">Subtotal:</th>
                        <td class="text-end">${{ number_format($pago->monto / 1.16, 2) }}</td>
                    </tr>
                    <tr>
                        <th colspan="2" class="text-end">IVA (16%):</th>
                        <td class="text-end">${{ number_format($pago->monto - ($pago->monto / 1.16), 2) }}</td>
                    </tr>
                    <tr class="table-light">
                        <th colspan="2" class="text-end fs-5">TOTAL PAGADO:</th>
                        <td class="text-end fs-5 fw-bold" style="color: #1a7a3c;">${{ number_format($pago->monto, 2) }} MXN</td>
                    </tr>
                </tfoot>
            </table>

            <!-- Footnote -->
            <div class="mt-4 pt-3 border-top text-center text-muted small">
                <p class="mb-1">Este recibo es un comprobante oficial de pago electrónico de cuota social de Club Polanco.</p>
                <p class="mb-0">Para cualquier aclaración o emisión de factura fiscal CFDI, contacte a cobranza@clubpolanco.com</p>
            </div>
        </div>
    </div>
</body>
</html>
