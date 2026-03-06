<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instructor extends Model
{
    use HasFactory;

    protected $fillable = [
        'curp',
        'nombre',
        'apellido_1',
        'apellido_2',
        'tipo_sangre',
        'estado_civil',
        'archivo_identificacion',
        'archivo_curp',
        'archivo_acta_nacimiento',
        'estado',
        'municipio',
        'localidad',
        'colonia',
        'calle',
        'numero_exterior',
        'numero_interior',
        'codigo_postal',
        'archivo_comprobante_domicilio',
        'telefono_1',
        'telefono_2',
        'email',
        'email_trabajo',
        'cuenta_servicio_medico',
        'nombre_servicio_medico',
        'escolaridad',
        'condicion_escolar',
        'nombre_escuela',
        'cedula_profesional',
        'archivo_comprobante_estudios',
        'tiene_registro_stps',
        'registro_stps',
        'tipo_instructor',
        'experiencia_laboral',
        'experiencia_docente',
        'experiencia_sector_productivo',
        'archivo_rfc',
        'archivo_constancias_cursos',
        'banco_tipo',
        'banco_nombre',
        'clabe',
        'numero_cuenta',
        'numero_tarjeta',
        'archivo_estado_cuenta',
        'archivo_cv',
        'archivo_solicitud_empleo',
        'observaciones',
        'plantel_id',
    ];

    public function plantel()
    {
        return $this->belongsTo(Plantel::class);
    }

    public function idiomas()
    {
        return $this->hasMany(InstructorIdioma::class);
    }

    public function habilidades()
    {
        return $this->hasMany(InstructorHabilidad::class);
    }

    public function cursos()
    {
        return $this->hasMany(InstructorCurso::class);
    }

    public function grupos()
    {
        return $this->belongsToMany(Grupo::class, 'grupo_instructor')
            ->withPivot(['tipo', 'fecha_inicio', 'fecha_termino', 'duracion_dias', 'duracion_horas', 'horario', 'pago_instructor', 'fecha_pago', 'tipo_pago'])
            ->withTimestamps();
    }
}
