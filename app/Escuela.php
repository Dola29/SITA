<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Escuela extends Model
{
    protected $fillable = [
        'nombre', 
        'facultad_id', 
        'activo', 
        'key_id',
        'updated_at',
        'deleted_at'
    ];

    public function facultad()
    {
        return $this->belongsTo('App\Facultad');
    }
}
