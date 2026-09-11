<?php

namespace App\Http\Controllers\crm;

use App\Http\Controllers\Controller;
use App\Models\CrmMensaje;
use App\Models\Socio;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CrmController extends Controller
{
    /**
     * Bandeja de Mensajes WhatsApp.
     */
    public function mensajes(Request $request)
    {
        $query = CrmMensaje::with('socio');

        if ($request->filled('tipo')) {
            $query->where('tipo', $request->tipo);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('telefono', 'like', "%{$search}%")
                  ->orWhere('mensaje', 'like', "%{$search}%")
                  ->orWhereHas('socio', function ($sq) use ($search) {
                      $sq->where('nombre', 'like', "%{$search}%")
                         ->orWhere('apellido', 'like', "%{$search}%");
                  });
            });
        }

        $mensajes = $query->orderBy('created_at', 'desc')->paginate(15)->withQueryString();
        $socios = Socio::whereNotNull('telefono')->orderBy('nombre')->get();

        $stats = [
            'total' => CrmMensaje::count(),
            'recordatorios' => CrmMensaje::where('tipo', 'recordatorio_pago')->count(),
            'cumpleanos' => CrmMensaje::where('tipo', 'cumpleanos')->count(),
            'enviados' => CrmMensaje::where('estado', 'enviado')->count(),
        ];

        return view('content.crm.mensajes', compact('mensajes', 'socios', 'stats'));
    }

    /**
     * Store and dispatch new WhatsApp message.
     */
    public function storeMensaje(Request $request)
    {
        $request->validate([
            'socio_id' => 'nullable|exists:socios,id',
            'telefono' => 'required|string|min:8',
            'tipo' => 'required|string|in:recordatorio_pago,cumpleanos,bienvenida,aviso',
            'mensaje' => 'required|string',
        ]);

        $limpioTel = preg_replace('/\D/', '', $request->telefono);

        $mensaje = CrmMensaje::create([
            'socio_id' => $request->socio_id,
            'tipo' => $request->tipo,
            'canal' => 'whatsapp',
            'telefono' => $limpioTel,
            'mensaje' => $request->mensaje,
            'estado' => 'enviado',
            'fecha_envio' => now(),
        ]);

        $waUrl = 'https://wa.me/' . $limpioTel . '?text=' . urlencode($request->mensaje);

        return redirect()->route('crm.mensajes')
            ->with('success', 'Mensaje registrado con éxito.')
            ->with('wa_url', $waUrl);
    }

    /**
     * Automatización de reglas de cobranza y cumpleaños.
     */
    public function automatizacion()
    {
        $reglas = [
            [
                'id' => 1,
                'nombre' => 'Recordatorio Previo de Pago',
                'gatillo' => '3 días antes de la fecha de vencimiento',
                'canal' => 'WhatsApp',
                'estado' => 'Activo',
                'plantilla' => 'Estimado(a) {nombre}, le recordamos amablemente de Club Polanco que su membresía vencerá el {fecha}. Su cuota a liquidar es de ${monto} MXN.',
            ],
            [
                'id' => 2,
                'nombre' => 'Aviso de Vencimiento de Cuota',
                'gatillo' => 'El día del corte de membresía',
                'canal' => 'WhatsApp',
                'estado' => 'Activo',
                'plantilla' => 'Hola {nombre}, hoy vence su membresía en Club Polanco. Realice su pago por QR o tarjeta en su portal: {link}',
            ],
            [
                'id' => 3,
                'nombre' => 'Felicitación de Cumpleaños & Cortesía',
                'gatillo' => 'Día del cumpleaños del socio (09:00 AM)',
                'canal' => 'WhatsApp',
                'estado' => 'Activo',
                'plantilla' => '¡Feliz Cumpleaños {nombre}! En Club Polanco celebramos contigo. Te obsequiamos una bebida de cortesía y acceso libre a invitados especiales en tu semana de festejo.',
            ],
            [
                'id' => 4,
                'nombre' => 'Notificación de Cuota Vencida / Morosidad',
                'gatillo' => '5 días posteriores al vencimiento',
                'canal' => 'WhatsApp',
                'estado' => 'Activo',
                'plantilla' => 'Aviso importante: Estimado(a) {nombre}, su membresía de Club Polanco presenta un atraso de pago. Evite la suspensión de sus beneficios regularizando su saldo.',
            ],
        ];

        return view('content.crm.automatizacion', compact('reglas'));
    }

    /**
     * Trigger automations execution.
     */
    public function ejecutarAutomatizacion()
    {
        $today = now();
        $count = 0;

        // 1. Cumpleañeros de hoy
        $cumpleaneros = Socio::whereMonth('fecha_nacimiento', $today->month)
            ->whereDay('fecha_nacimiento', $today->day)
            ->get();

        foreach ($cumpleaneros as $s) {
            if ($s->telefono) {
                CrmMensaje::create([
                    'socio_id' => $s->id,
                    'tipo' => 'cumpleanos',
                    'canal' => 'whatsapp',
                    'telefono' => preg_replace('/\D/', '', $s->telefono),
                    'mensaje' => "¡Feliz Cumpleaños {$s->nombre}! En Club Polanco nos llena de alegría celebrar contigo. Disfruta hoy de una cortesía especial en el restaurante.",
                    'estado' => 'enviado',
                    'fecha_envio' => now(),
                ]);
                $count++;
            }
        }

        // 2. Vencimientos en próximos 3 días
        $porVencer = Socio::where('estado', 'activo')
            ->whereDate('fecha_vencimiento', '<=', $today->copy()->addDays(3))
            ->whereDate('fecha_vencimiento', '>=', $today)
            ->get();

        foreach ($porVencer as $s) {
            if ($s->telefono) {
                CrmMensaje::create([
                    'socio_id' => $s->id,
                    'tipo' => 'recordatorio_pago',
                    'canal' => 'whatsapp',
                    'telefono' => preg_replace('/\D/', '', $s->telefono),
                    'mensaje' => "Hola {$s->nombre}, le recordamos de Club Polanco que su cuota mensual de \${$s->cuota_mensual} vence el {$s->fecha_vencimiento->format('d/m/Y')}. Puede liquidarla fácilmente en su portal.",
                    'estado' => 'enviado',
                    'fecha_envio' => now(),
                ]);
                $count++;
            }
        }

        return back()->with('success', "Proceso de automatización ejecutado: se generaron {$count} mensajes automáticos.");
    }

    /**
     * Recordatorios de Pago y Cumpleañeros del Mes.
     */
    public function recordatorios()
    {
        $today = now();

        // Socios morosos o por vencer
        $sociosPorCobrar = Socio::where('estado', 'moroso')
            ->orWhere(function ($q) use ($today) {
                $q->where('estado', 'activo')
                  ->whereDate('fecha_vencimiento', '<=', $today->copy()->addDays(7));
            })
            ->orderBy('fecha_vencimiento', 'asc')
            ->get();

        // Cumpleañeros de este mes
        $cumpleanerosMes = Socio::whereMonth('fecha_nacimiento', $today->month)
            ->orderByRaw('DAY(fecha_nacimiento) ASC')
            ->get();

        return view('content.crm.recordatorios', compact('sociosPorCobrar', 'cumpleanerosMes'));
    }
}
