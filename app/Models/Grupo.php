<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grupo extends Model
{
    use HasFactory;

    protected $fillable = [
        'estatus',
        'tipo_servicio',
        'modalidad_ce',
        'modalidad',
        'oferta_educativa_id',
        'campo_formacion_id',
        'especialidad_ocupacional_id',
        'curso_id',
        'curso_icategro_id',
        'alumnos_inician',
        'capacidad_maxima',
        'fecha_inicio',
        'fecha_termino',
        'duracion_dias',
        'duracion_horas',
        'numero_semanas',
        'numero_horas_semana',
        'horario',
        'plantel_id',
        'estado',
        'municipio',
        'localidad',
        'nombre_espacio',
        'tipo_pago_grupo',
        'costo_por_persona',
        'costo_por_grupo',
        'costo_coffee_break',
        'ingreso_total',
        'utilidad_grupo',
        'archivo_plan_estudios',
        'archivo_becas',
        'comentarios',
        'user_id',
        'autorizado_por',
        'fecha_autorizacion'
    ];

    public function ofertaEducativa()
    {
        return $this->belongsTo(OfertaEducativa::class);
    }

    public function campoFormacion()
    {
        return $this->belongsTo(CampoFormacion::class);
    }

    public function especialidadOcupacional()
    {
        return $this->belongsTo(EspecialidadOcupacional::class);
    }

    public function curso()
    {
        return $this->belongsTo(Curso::class);
    }

    public function cursoIcategro()
    {
        return $this->belongsTo(CursoIcategro::class);
    }

    public function calendarios()
    {
        return $this->hasMany(GrupoCalendario::class);
    }

    public function plantel()
    {
        return $this->belongsTo(Plantel::class);
    }

    public function convenios()
    {
        return $this->belongsToMany(Convenio::class);
    }

    public function instructores()
    {
        return $this->belongsToMany(Instructor::class, 'grupo_instructor')
            ->withPivot(['tipo', 'fecha_inicio', 'fecha_termino', 'duracion_dias', 'duracion_horas', 'horario', 'pago_instructor', 'fecha_pago', 'tipo_pago'])
            ->withTimestamps();
    }

    public function creador()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function autorizador()
    {
        return $this->belongsTo(User::class, 'autorizado_por');
    }

    public function revisiones()
    {
        return $this->hasMany(GrupoRevision::class);
    }

    public function listaAlumnos()
    {
        return $this->hasMany(ListaCursoAlumno::class, 'group_id');
    }

    public function getNombreCursoAttribute()
    {
        if ($this->tipo_servicio === 'CAE' && $this->curso) {
            return $this->curso->name;
        }

        if ($this->tipo_servicio === 'Extensión' && $this->cursoIcategro) {
            return $this->cursoIcategro->name;
        }

        return 'CURSO NO ASIGNADO';
    }

    public function getCursoIdEspecificoAttribute()
    {
        if ($this->tipo_servicio === 'CAE') {
            return $this->curso->id;
        }

        if ($this->tipo_servicio === 'Extensión') {
            return $this->cursoIcategro->id;
        }

        return null;
    }
}
