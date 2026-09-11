<?php

namespace App\Http\Controllers\pagos;

use App\Http\Controllers\Controller;
use App\Models\Pago;
use App\Models\Socio;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PagosController extends Controller
{
    /**
     * Display a listing of all payments.
     */
    public function index(Request $request)
    {
        $query = Pago::with('socio');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('referencia', 'like', "%{$search}%")
                  ->orWhere('concepto', 'like', "%{$search}%")
                  ->orWhereHas('socio', function ($sq) use ($search) {
                      $sq->where('nombre', 'like', "%{$search}%")
                         ->orWhere('apellido', 'like', "%{$search}%")
                         ->orWhere('codigo_acceso', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('metodo')) {
            $query->where('metodo', $request->metodo);
        }

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        $pagos = $query->orderBy('created_at', 'desc')->paginate(15)->withQueryString();

        $kpis = [
            'total_mes' => Pago::where('estado', 'completado')->whereMonth('fecha_pago', now()->month)->sum('monto'),
            'total_qr' => Pago::where('metodo', 'qr')->where('estado', 'completado')->sum('monto'),
            'total_tarjeta' => Pago::where('metodo', 'tarjeta')->where('estado', 'completado')->sum('monto'),
            'pendientes' => Pago::where('estado', 'pendiente')->count(),
        ];

        return view('content.pagos.index', compact('pagos', 'kpis'));
    }

    /**
     * QR Dinámico page for reception.
     */
    public function qr()
    {
        $socios = Socio::where('estado', '!=', 'inactivo')->orderBy('nombre')->get();
        return view('content.pagos.qr', compact('socios'));
    }

    /**
     * Process reception QR payment.
     */
    public function storeQr(Request $request)
    {
        $request->validate([
            'socio_id' => 'required|exists:socios,id',
            'monto' => 'required|numeric|min:1',
            'concepto' => 'required|string|max:255',
            'referencia' => 'required|string|max:50',
        ]);

        $socio = Socio::findOrFail($request->socio_id);

        $pago = Pago::create([
            'socio_id' => $socio->id,
            'concepto' => $request->concepto,
            'monto' => $request->monto,
            'metodo' => 'qr',
            'estado' => 'completado',
            'referencia' => $request->referencia,
            'fecha_pago' => now()->toDateString(),
            'notas' => 'Pago por QR Dinámico confirmado en ventanilla de recepción',
        ]);

        // Renew membership
        $currentExpiry = $socio->fecha_vencimiento ? Carbon::parse($socio->fecha_vencimiento) : now();
        $newExpiry = $currentExpiry->isFuture() ? $currentExpiry->addMonth() : now()->addMonth();

        $socio->update([
            'estado' => 'activo',
            'fecha_vencimiento' => $newExpiry->toDateString(),
        ]);

        return redirect()->route('pagos.index')->with('success', '¡Pago por QR de $' . number_format($pago->monto, 2) . ' registrado con éxito para ' . $socio->nombre_completo . '!');
    }

    /**
     * Virtual POS / Terminal de Tarjeta page.
     */
    public function tarjeta()
    {
        $socios = Socio::where('estado', '!=', 'inactivo')->orderBy('nombre')->get();
        return view('content.pagos.tarjeta', compact('socios'));
    }

    /**
     * Process Virtual POS card payment.
     */
    public function storeTarjeta(Request $request)
    {
        $request->validate([
            'socio_id' => 'required|exists:socios,id',
            'monto' => 'required|numeric|min:1',
            'titular' => 'required|string|max:100',
            'numero_tarjeta' => 'required|string|min:16',
            'concepto' => 'required|string|max:255',
        ]);

        $socio = Socio::findOrFail($request->socio_id);
        $ultimos4 = substr(str_replace(' ', '', $request->numero_tarjeta), -4);
        $ref = 'CP-TPV-' . strtoupper(substr(uniqid(), -6));

        $pago = Pago::create([
            'socio_id' => $socio->id,
            'concepto' => $request->concepto,
            'monto' => $request->monto,
            'metodo' => 'tarjeta',
            'estado' => 'completado',
            'referencia' => $ref,
            'fecha_pago' => now()->toDateString(),
            'notas' => 'TPV Recepción: Aprobado con tarjeta terminada en ' . $ultimos4 . ' (' . $request->titular . ')',
        ]);

        // Renew membership
        $currentExpiry = $socio->fecha_vencimiento ? Carbon::parse($socio->fecha_vencimiento) : now();
        $newExpiry = $currentExpiry->isFuture() ? $currentExpiry->addMonth() : now()->addMonth();

        $socio->update([
            'estado' => 'activo',
            'fecha_vencimiento' => $newExpiry->toDateString(),
        ]);

        return redirect()->route('pagos.index')->with('success', 'Cobro con tarjeta aprobado exitosamente. Folio: ' . $ref);
    }

    /**
     * Verification tray for pending payments.
     */
    public function verificacion()
    {
        $pagosPendientes = Pago::with('socio')->where('estado', 'pendiente')->orderBy('created_at', 'asc')->paginate(10);
        $totalPendienteMonto = Pago::where('estado', 'pendiente')->sum('monto');

        return view('content.pagos.verificacion', compact('pagosPendientes', 'totalPendienteMonto'));
    }

    /**
     * Approve pending payment.
     */
    public function aprobar(Pago $pago)
    {
        $pago->update([
            'estado' => 'completado',
            'fecha_pago' => now()->toDateString(),
        ]);

        if ($pago->socio) {
            $socio = $pago->socio;
            $currentExpiry = $socio->fecha_vencimiento ? Carbon::parse($socio->fecha_vencimiento) : now();
            $newExpiry = $currentExpiry->isFuture() ? $currentExpiry->addMonth() : now()->addMonth();
            $socio->update([
                'estado' => 'activo',
                'fecha_vencimiento' => $newExpiry->toDateString(),
            ]);
        }

        return back()->with('success', 'Pago con referencia ' . $pago->referencia . ' aprobado correctamente.');
    }

    /**
     * Reject pending payment.
     */
    public function rechazar(Pago $pago)
    {
        $pago->update(['estado' => 'rechazado']);
        return back()->with('success', 'Pago marcado como rechazado.');
    }

    /**
     * Receipts and invoices list.
     */
    public function recibos(Request $request)
    {
        $query = Pago::with('socio')->where('estado', 'completado');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('referencia', 'like', "%{$search}%")
                  ->orWhereHas('socio', function ($sq) use ($search) {
                      $sq->where('nombre', 'like', "%{$search}%")
                         ->orWhere('apellido', 'like', "%{$search}%")
                         ->orWhere('codigo_acceso', 'like', "%{$search}%");
                  });
            });
        }

        $recibos = $query->orderBy('fecha_pago', 'desc')->paginate(15)->withQueryString();

        return view('content.pagos.recibos', compact('recibos'));
    }

    /**
     * Show single official receipt for printing.
     */
    public function showRecibo(Pago $pago)
    {
        $pago->load('socio');
        $socio = $pago->socio;
        return view('portal.recibo', compact('socio', 'pago'));
    }

    /**
     * Automatic billing dashboard.
     */
    public function cobranzaAutomatica()
    {
        $sociosParaCobro = Socio::where('estado', '!=', 'inactivo')
            ->where(function ($q) {
                $q->whereNull('fecha_vencimiento')
                  ->orWhere('fecha_vencimiento', '<=', now()->addDays(3)->toDateString());
            })->get();

        $cobrosRecientes = Pago::with('socio')
            ->where('notas', 'like', '%Cobranza recurrente%')
            ->orWhere('notas', 'like', '%Cobranza mensual%')
            ->latest()
            ->limit(10)
            ->get();

        return view('content.pagos.cobranza-automatica', compact('sociosParaCobro', 'cobrosRecientes'));
    }

    /**
     * Execute automatic billing batch.
     */
    public function ejecutarCobranzaAutomatica()
    {
        $socios = Socio::where('estado', '!=', 'inactivo')
            ->where(function ($q) {
                $q->whereNull('fecha_vencimiento')
                  ->orWhere('fecha_vencimiento', '<=', now()->addDays(3)->toDateString());
            })->get();

        $count = 0;
        $total = 0;

        foreach ($socios as $socio) {
            Pago::create([
                'socio_id' => $socio->id,
                'concepto' => 'Cobro Automático Membresía (' . ucfirst($socio->categoria) . ')',
                'monto' => $socio->cuota_mensual,
                'metodo' => 'tarjeta',
                'estado' => 'completado',
                'referencia' => 'CP-AUTO-' . strtoupper(substr(uniqid(), -6)),
                'fecha_pago' => now()->toDateString(),
                'notas' => 'Cobranza mensual recurrente programada ejecutada por el sistema',
            ]);

            $currentExpiry = $socio->fecha_vencimiento ? Carbon::parse($socio->fecha_vencimiento) : now();
            $newExpiry = $currentExpiry->isFuture() ? $currentExpiry->addMonth() : now()->addMonth();

            $socio->update([
                'estado' => 'activo',
                'fecha_vencimiento' => $newExpiry->toDateString(),
            ]);

            $count++;
            $total += $socio->cuota_mensual;
        }

        return back()->with('success', "Cobranza automática ejecutada exitosamente: {$count} cuotas procesadas por un total de $" . number_format($total, 2) . ' MXN.');
    }
}
