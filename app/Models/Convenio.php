<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Convenio extends Model
{
    protected $fillable = [
        'type',
        'number',
        'name',
        'start_date',
        'end_date',
        'amount',
        'object',
        'pdf_document',
        'observations'
    ];

    public function planteles()
    {
        return $this->belongsToMany(Plantel::class, 'convenio_plantel');
    }

    public function poblaciones()
    {
        return $this->belongsToMany(Poblacion::class, 'convenio_poblacion');
    }

    public function companies()
    {
        return $this->belongsToMany(Company::class);
    }

    public function grupos()
    {
        return $this->belongsToMany(Grupo::class);
    }
}
