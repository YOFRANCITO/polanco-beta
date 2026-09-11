<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    use HasFactory;

    protected $table = 'pagos';

    protected $fillable = [
        'socio_id',
        'concepto',
        'monto',
        'metodo',
        'estado',
        'referencia',
        'comprobante',
        'fecha_pago',
        'notas',
    ];

    protected $casts = [
        'monto' => 'float',
        'fecha_pago' => 'date',
    ];

    public function socio()
    {
        return $this->belongsTo(Socio::class);
    }

    public function getMetodoLabelAttribute(): string
    {
        return match ($this->metodo) {
            'qr' => 'QR Dinámico',
            'tarjeta' => 'Tarjeta de Crédito/Débito',
            'transferencia' => 'Transferencia Bancaria',
            'efectivo' => 'Efectivo',
            default => ucfirst($this->metodo),
        };
    }

    public function getMetodoBadgeAttribute(): string
    {
        return match ($this->metodo) {
            'qr' => 'bg-label-primary',
            'tarjeta' => 'bg-label-info',
            'transferencia' => 'bg-label-warning',
            'efectivo' => 'bg-label-success',
            default => 'bg-label-secondary',
        };
    }

    public function getMetodoIconAttribute(): string
    {
        return match ($this->metodo) {
            'qr' => 'bx bx-qr-scan',
            'tarjeta' => 'bx bx-credit-card',
            'transferencia' => 'bx bx-transfer',
            'efectivo' => 'bx bx-money',
            default => 'bx bx-wallet',
        };
    }

    public function getEstadoBadgeAttribute(): string
    {
        return match ($this->estado) {
            'completado' => 'bg-label-success',
            'pendiente' => 'bg-label-warning',
            'rechazado' => 'bg-label-danger',
            default => 'bg-label-secondary',
        };
    }

    public function getEstadoLabelAttribute(): string
    {
        return match ($this->estado) {
            'completado' => 'Completado',
            'pendiente' => 'Pendiente Verificación',
            'rechazado' => 'Rechazado',
            default => ucfirst($this->estado),
        };
    }
}
