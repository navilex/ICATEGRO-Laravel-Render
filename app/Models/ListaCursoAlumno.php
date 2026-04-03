<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ListaCursoAlumno extends Model
{
    protected $table = 'lista_cursos_alumnos';

    protected $fillable = [
        'student_id',
        'group_status',
        'plantel',
        'group_id',
        'grupos_vulnerables',
        'discapacidades',
        'escolaridad',
        'name',
        'start_date',
        'end_date',
        'student_status',
        'calificacion',
        'doc_type',
        'folio',
        'folio_motivo_cambio',
    ];

    protected $casts = [
        'grupos_vulnerables' => 'array',
        'discapacidades' => 'array',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }
}
