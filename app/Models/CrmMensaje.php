<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CrmMensaje extends Model
{
    use HasFactory;

    protected $table = 'crm_mensajes';

    protected $fillable = [
        'socio_id',
        'tipo',
        'canal',
        'telefono',
        'mensaje',
        'estado',
        'fecha_envio',
    ];

    protected $casts = [
        'fecha_envio' => 'datetime',
    ];

    public function socio()
    {
        return $this->belongsTo(Socio::class);
    }

    public function getTipoLabelAttribute(): string
    {
        return match ($this->tipo) {
            'recordatorio_pago' => 'Recordatorio de Cobro',
            'cumpleanos' => 'Felicitación de Cumpleaños',
            'bienvenida' => 'Bienvenida a Club Polanco',
            'aviso' => 'Aviso General',
            default => ucfirst($this->tipo),
        };
    }

    public function getTipoBadgeAttribute(): string
    {
        return match ($this->tipo) {
            'recordatorio_pago' => 'bg-label-warning',
            'cumpleanos' => 'bg-label-info',
            'bienvenida' => 'bg-label-primary',
            'aviso' => 'bg-label-secondary',
            default => 'bg-label-dark',
        };
    }
}
