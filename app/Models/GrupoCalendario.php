<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GrupoCalendario extends Model
{
    use HasFactory;

    protected $fillable = [
        'grupo_id',
        'tipo_fecha',
        'fecha_inicial',
        'fecha_final',
        'hora_inicial',
        'hora_final',
        'total_dias',
        'total_horas',
    ];

    public function grupo()
    {
        return $this->belongsTo(Grupo::class);
    }
}
