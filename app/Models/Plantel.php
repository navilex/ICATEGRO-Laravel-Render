<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plantel extends Model
{
    protected $table = 'planteles';

    protected $fillable = [
        'name',
        'clasificacion',
        'tipo',
        'clave_cct',
        'estado',
        'municipio',
        'colonia',
        'calle',
        'numero_exterior',
        'numero_interior',
        'codigo_postal',
        'tipo_asignacion'
    ];

    public function convenios()
    {
        return $this->belongsToMany(Convenio::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
