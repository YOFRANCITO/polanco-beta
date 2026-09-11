<?php

namespace App\Http\Controllers\portal;

use App\Http\Controllers\Controller;
use App\Models\Socio;
use App\Models\Pago;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PortalController extends Controller
{
    /**
     * Show portal access form.
     */
    public function showLogin()
    {
        if (session()->has('socio_id')) {
            return redirect()->route('portal.inicio');
        }

        // Fetch 2 sample socios for quick test in development
        $demoSocios = Socio::whereIn('estado', ['activo', 'moroso'])->limit(3)->get();

        return view('portal.login', compact('demoSocios'));
    }

    /**
     * Validate socio code and birthdate.
     */
    public function login(Request $request)
    {
        $request->validate([
            'codigo_acceso' => 'required|string',
            'fecha_nacimiento' => 'required|date',
        ], [
            'codigo_acceso.required' => 'El código de acceso es obligatorio.',
            'fecha_nacimiento.required' => 'La fecha de nacimiento es obligatoria.',
            'fecha_nacimiento.date' => 'Formato de fecha inválido.',
        ]);

        $codigo = strtoupper(trim($request->codigo_acceso));
        $fecha = $request->fecha_nacimiento;

        $socio = Socio::where('codigo_acceso', $codigo)
            ->whereDate('fecha_nacimiento', $fecha)
            ->first();

        if (!$socio) {
            return back()->withErrors([
                'codigo_acceso' => 'Código de acceso o fecha de nacimiento incorrectos. Si no recuerda su código, consulte en recepción de Club Polanco.',
            ])->withInput();
        }

        // Save session
        session(['socio_id' => $socio->id]);

        return redirect()->route('portal.inicio')->with('success', '¡Bienvenido(a), ' . $socio->nombre . '!');
    }

    /**
     * Socio Profile Dashboard.
     */
    public function inicio()
    {
        $socio = Socio::with(['pagos' => function ($q) {
            $q->latest()->limit(5);
        }])->findOrFail(session('socio_id'));

        return view('portal.inicio', compact('socio'));
    }

    /**
     * Socio Payment History.
     */
    public function historial()
    {
        $socio = Socio::findOrFail(session('socio_id'));
        $pagos = $socio->pagos()->paginate(10);

        return view('portal.historial', compact('socio', 'pagos'));
    }

    /**
     * Socio Payment Page (QR & Card).
     */
    public function pagar()
    {
        $socio = Socio::findOrFail(session('socio_id'));
        $referenciaQr = 'CP-QR-' . strtoupper(substr(uniqid(), -6));

        return view('portal.pagar', compact('socio', 'referenciaQr'));
    }

    /**
     * Process Card Payment from Socio Portal.
     */
    public function procesarTarjeta(Request $request)
    {
        $socio = Socio::findOrFail(session('socio_id'));

        $request->validate([
            'titular' => 'required|string|max:100',
            'numero_tarjeta' => 'required|string|min:16',
            'expiracion' => 'required|string',
            'cvv' => 'required|string|min:3|max:4',
        ], [
            'titular.required' => 'El nombre del titular es requerido.',
            'numero_tarjeta.required' => 'El número de tarjeta es requerido.',
            'expiracion.required' => 'La fecha de expiración es requerida.',
            'cvv.required' => 'El código CVV es requerido.',
        ]);

        $ultimos4 = substr(str_replace(' ', '', $request->numero_tarjeta), -4);

        // Record payment
        $pago = Pago::create([
            'socio_id' => $socio->id,
            'concepto' => 'Pago Membresía Mensual (' . ucfirst($socio->categoria) . ')',
            'monto' => $socio->cuota_mensual,
            'metodo' => 'tarjeta',
            'estado' => 'completado',
            'referencia' => 'CP-CARD-' . strtoupper(substr(uniqid(), -6)),
            'fecha_pago' => now()->toDateString(),
            'notas' => 'Pago en línea procesado con tarjeta terminada en ' . $ultimos4,
        ]);

        // Renew socio membership
        $currentExpiry = $socio->fecha_vencimiento ? Carbon::parse($socio->fecha_vencimiento) : now();
        $newExpiry = $currentExpiry->isFuture() ? $currentExpiry->addMonth() : now()->addMonth();

        $socio->update([
            'estado' => 'activo',
            'fecha_vencimiento' => $newExpiry->toDateString(),
        ]);

        return redirect()->route('portal.historial')->with('success', '¡Pago de $' . number_format($pago->monto, 2) . ' realizado con éxito! Su membresía ha sido renovada hasta el ' . $newExpiry->format('d/m/Y') . '.');
    }

    /**
     * Process QR Payment from Socio Portal (Simulation).
     */
    public function procesarQr(Request $request)
    {
        $socio = Socio::findOrFail(session('socio_id'));
        $referencia = $request->referencia ?? ('CP-QR-' . strtoupper(substr(uniqid(), -6)));

        // Record payment
        $pago = Pago::create([
            'socio_id' => $socio->id,
            'concepto' => 'Pago Membresía Mensual QR (' . ucfirst($socio->categoria) . ')',
            'monto' => $socio->cuota_mensual,
            'metodo' => 'qr',
            'estado' => 'completado',
            'referencia' => $referencia,
            'fecha_pago' => now()->toDateString(),
            'notas' => 'Pago escaneado y verificado instantáneamente vía QR CoDi / Club Polanco',
        ]);

        // Renew socio membership
        $currentExpiry = $socio->fecha_vencimiento ? Carbon::parse($socio->fecha_vencimiento) : now();
        $newExpiry = $currentExpiry->isFuture() ? $currentExpiry->addMonth() : now()->addMonth();

        $socio->update([
            'estado' => 'activo',
            'fecha_vencimiento' => $newExpiry->toDateString(),
        ]);

        return redirect()->route('portal.historial')->with('success', '¡Pago QR de $' . number_format($pago->monto, 2) . ' confirmado! Su membresía se encuentra activa.');
    }

    /**
     * View/Print Receipt for Socio.
     */
    public function recibo(Pago $pago)
    {
        $socio = Socio::findOrFail(session('socio_id'));

        if ($pago->socio_id !== $socio->id) {
            abort(403, 'Acceso denegado a este comprobante.');
        }

        return view('portal.recibo', compact('socio', 'pago'));
    }

    /**
     * Logout from Socio Portal.
     */
    public function logout()
    {
        session()->forget('socio_id');
        return redirect()->route('portal.login')->with('success', 'Ha cerrado sesión en el portal de socios.');
    }
}
