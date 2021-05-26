<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Trabajo extends Model
{
    protected $fillable = [
        'tema', 
        'facultad_id', 
        'escuela_id', 
        'carrera_id', 
        'titulo', 
        'fecha_inicio',
        'fecha_fin',
        'recinto_id',
        'ubicacion_id',
        'tipo_trabajo',
        'nivel', 
        'key_id',
        'updated_at',
        'deleted_at'
    ];

    public function facultad()
    {
        return $this->belongsTo('App\Facultad');
    }

    public function escuela()
    {
        return $this->belongsTo('App\Escuela');
    }

    public function carrera()
    {
        return $this->belongsTo('App\Carrera');
    }

    public function recinto()
    {
        return $this->belongsTo('App\Recinto');
    }

    public function ubicacion()
    {
        return $this->belongsTo('App\Ubicacion');
    }
    public function sustentantes()
    {
        return $this->hasMany('App\TrabajoSustentante');
    }
    public function asesores()
    {
        return $this->hasMany('App\TrabajoAsesor');
    }
}
