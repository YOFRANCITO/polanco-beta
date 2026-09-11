<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Socio extends Model
{
    use SoftDeletes;

    protected $table = 'socios';

    protected $fillable = [
        'codigo_acceso', 'nombre', 'apellido', 'email', 'telefono',
        'fecha_nacimiento', 'cedula', 'categoria', 'estado',
        'cuota_mensual', 'fecha_ingreso', 'fecha_vencimiento',
        'foto', 'direccion', 'notas',
    ];

    protected $casts = [
        'fecha_nacimiento'  => 'date',
        'fecha_ingreso'     => 'date',
        'fecha_vencimiento' => 'date',
        'cuota_mensual'     => 'decimal:2',
    ];

    // Nombre completo
    public function getNombreCompletoAttribute(): string
    {
        return "{$this->nombre} {$this->apellido}";
    }

    // Iniciales para avatar
    public function getInicialesAttribute(): string
    {
        return strtoupper(substr($this->nombre, 0, 1) . substr($this->apellido, 0, 1));
    }

    // Color según categoría
    public function getColorCategoriaAttribute(): string
    {
        return match ($this->categoria) {
            'familiar'   => '#1a7a3c',
            'individual' => '#8592a3',
            'junior'     => '#03c3ec',
            'vip'        => '#c9a84c',
            default      => '#8592a3',
        };
    }

    // Badge estado
    public function getColorEstadoAttribute(): string
    {
        return match ($this->estado) {
            'activo'   => '#1a7a3c',
            'moroso'   => '#ffab00',
            'inactivo' => '#ff3e1d',
            default    => '#8592a3',
        };
    }

    // Relación con pagos
    public function pagos()
    {
        return $this->hasMany(Pago::class)->orderBy('created_at', 'desc');
    }

    // Relación con mensajes de CRM
    public function crmMensajes()
    {
        return $this->hasMany(CrmMensaje::class)->orderBy('created_at', 'desc');
    }
}
