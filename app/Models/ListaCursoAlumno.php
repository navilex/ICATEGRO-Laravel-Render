<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ListaCursoAlumno extends Model
{
    protected $table = 'lista_cursos_alumnos';

    protected $fillable = [
        'student_id',
        'group_id',
        'grupos_vulnerables',
        'discapacidades',
        'escolaridad',
        'curso_id',
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

    //Relación con el Grupo
    public function grupo()
    {
        return $this->belongsTo(Grupo::class, 'group_id');
    }

    //Relación con el Curso
    public function curso()
    {
        return $this->belongsTo(Curso::class, 'curso_id');
    }
}
