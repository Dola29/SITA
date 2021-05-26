<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Carrera extends Model
{
    protected $fillable = [
        'nombre', 
        'facultad_id', 
        'escuela_id', 
        'titulo',
        'activo', 
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
}
