<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Socio;
use App\Models\Pago;
use App\Models\CrmMensaje;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Usuarios del Sistema
        User::updateOrCreate(
            ['email' => 'admin@clubpolanco.com'],
            [
                'name' => 'Administrador General',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'telefono' => '+52 55 1234 5678',
                'estado' => 'activo',
            ]
        );

        User::updateOrCreate(
            ['email' => 'operador@clubpolanco.com'],
            [
                'name' => 'Operador de Recepción',
                'password' => Hash::make('operador123'),
                'role' => 'operador',
                'telefono' => '+52 55 8765 4321',
                'estado' => 'activo',
            ]
        );

        // 2. Socios
        $socio1 = Socio::updateOrCreate(
            ['cedula' => '17892345'],
            [
                'codigo_acceso' => 'CP-789012',
                'nombre' => 'Carlos',
                'apellido' => 'Mendoza',
                'email' => 'carlos.mendoza@email.com',
                'telefono' => '525512345678',
                'fecha_nacimiento' => '1985-06-15',
                'categoria' => 'vip',
                'estado' => 'activo',
                'cuota_mensual' => 180.00,
                'fecha_ingreso' => '2023-01-10',
                'fecha_vencimiento' => now()->addDays(20)->toDateString(),
                'direccion' => 'Av. Campos Elíseos 204, Polanco',
                'notas' => 'Socio fundador, uso preferencial de canchas de tenis',
            ]
        );

        $socio2 = Socio::updateOrCreate(
            ['cedula' => '18903456'],
            [
                'codigo_acceso' => 'CP-456789',
                'nombre' => 'Mariana',
                'apellido' => 'Silva',
                'email' => 'mariana.silva@email.com',
                'telefono' => '525523456789',
                'fecha_nacimiento' => '1992-11-20',
                'categoria' => 'familiar',
                'estado' => 'activo',
                'cuota_mensual' => 120.00,
                'fecha_ingreso' => '2023-05-15',
                'fecha_vencimiento' => now()->addDays(12)->toDateString(),
                'direccion' => 'Horacio 832, Depto 4B, Polanco',
                'notas' => 'Incluye cónyuge y dos menores',
            ]
        );

        $socio3 = Socio::updateOrCreate(
            ['cedula' => '14567890'],
            [
                'codigo_acceso' => 'CP-123456',
                'nombre' => 'Rodrigo',
                'apellido' => 'Morales',
                'email' => 'rodrigo.morales@email.com',
                'telefono' => '525534567890',
                'fecha_nacimiento' => '1978-03-10',
                'categoria' => 'individual',
                'estado' => 'moroso',
                'cuota_mensual' => 90.00,
                'fecha_ingreso' => '2022-08-01',
                'fecha_vencimiento' => now()->subDays(15)->toDateString(),
                'direccion' => 'Homero 1420, Polanco',
                'notas' => 'Cuota vencida hace 15 días, pendiente aviso de cobro',
            ]
        );

        $socio4 = Socio::updateOrCreate(
            ['cedula' => '22334455'],
            [
                'codigo_acceso' => 'CP-334455',
                'nombre' => 'Sofía',
                'apellido' => 'Benítez',
                'email' => 'sofia.benitez@email.com',
                'telefono' => '525545678901',
                'fecha_nacimiento' => '2001-09-12', // Cumpleaños en septiembre!
                'categoria' => 'junior',
                'estado' => 'activo',
                'cuota_mensual' => 65.00,
                'fecha_ingreso' => '2024-02-01',
                'fecha_vencimiento' => now()->addDays(5)->toDateString(),
                'direccion' => 'Lope de Vega 310, Polanco',
                'notas' => 'Cumpleaños este mes, aplicar promoción cortesía',
            ]
        );

        $socio5 = Socio::updateOrCreate(
            ['cedula' => '16789012'],
            [
                'codigo_acceso' => 'CP-998877',
                'nombre' => 'Andrés',
                'apellido' => 'Valenzuela',
                'email' => 'andres.valenzuela@email.com',
                'telefono' => '525556789012',
                'fecha_nacimiento' => '1980-04-05',
                'categoria' => 'familiar',
                'estado' => 'inactivo',
                'cuota_mensual' => 120.00,
                'fecha_ingreso' => '2021-11-20',
                'fecha_vencimiento' => now()->subMonths(2)->toDateString(),
                'direccion' => 'Moliere 540, Polanco',
                'notas' => 'Membresía pausada por viaje temporal',
            ]
        );

        // 3. Pagos de Ejemplo
        Pago::updateOrCreate(
            ['referencia' => 'CP-PAY-9801'],
            [
                'socio_id' => $socio1->id,
                'concepto' => 'Cuota Mensual VIP - Septiembre',
                'monto' => 180.00,
                'metodo' => 'tarjeta',
                'estado' => 'completado',
                'fecha_pago' => now()->subDays(5)->toDateString(),
                'notas' => 'Aprobado automáticamente con Visa terminada en 4242',
            ]
        );

        Pago::updateOrCreate(
            ['referencia' => 'CP-PAY-9802'],
            [
                'socio_id' => $socio2->id,
                'concepto' => 'Cuota Familiar - Septiembre',
                'monto' => 120.00,
                'metodo' => 'qr',
                'estado' => 'completado',
                'fecha_pago' => now()->subDays(3)->toDateString(),
                'notas' => 'Pago escaneado vía QR Dinámico CoDi/Bancario',
            ]
        );

        Pago::updateOrCreate(
            ['referencia' => 'CP-PAY-9803'],
            [
                'socio_id' => $socio3->id,
                'concepto' => 'Cuota Mensual Individual - Agosto',
                'monto' => 90.00,
                'metodo' => 'transferencia',
                'estado' => 'pendiente',
                'fecha_pago' => now()->subDay()->toDateString(),
                'notas' => 'Comprobante subido por socio, pendiente conciliación en caja',
            ]
        );

        Pago::updateOrCreate(
            ['referencia' => 'CP-PAY-9804'],
            [
                'socio_id' => $socio4->id,
                'concepto' => 'Cuota Junior - Septiembre',
                'monto' => 65.00,
                'metodo' => 'qr',
                'estado' => 'pendiente',
                'fecha_pago' => now()->toDateString(),
                'notas' => 'QR generado en recepción esperando confirmación',
            ]
        );

        Pago::updateOrCreate(
            ['referencia' => 'CP-PAY-9799'],
            [
                'socio_id' => $socio1->id,
                'concepto' => 'Cuota Mensual VIP - Agosto',
                'monto' => 180.00,
                'metodo' => 'tarjeta',
                'estado' => 'completado',
                'fecha_pago' => now()->subMonth()->toDateString(),
                'notas' => 'Cobranza mensual recurrente exitosa',
            ]
        );

        // 4. Mensajes CRM / WhatsApp
        CrmMensaje::updateOrCreate(
            ['telefono' => '525534567890', 'tipo' => 'recordatorio_pago'],
            [
                'socio_id' => $socio3->id,
                'tipo' => 'recordatorio_pago',
                'canal' => 'whatsapp',
                'mensaje' => 'Hola Rodrigo Morales, le recordamos amablemente de Club Polanco que su membresía mensual de $90.00 se encuentra vencida. Puede regularizarla en línea o en recepción.',
                'estado' => 'enviado',
                'fecha_envio' => now()->subDays(2),
            ]
        );

        CrmMensaje::updateOrCreate(
            ['telefono' => '525545678901', 'tipo' => 'cumpleanos'],
            [
                'socio_id' => $socio4->id,
                'tipo' => 'cumpleanos',
                'canal' => 'whatsapp',
                'mensaje' => '¡Feliz cumpleaños Sofía Benítez! Todo el equipo de Club Polanco le desea un día excepcional. Le invitamos a disfrutar de una bebida de cortesía en nuestro restaurante club.',
                'estado' => 'programado',
                'fecha_envio' => now(),
            ]
        );
    }
}