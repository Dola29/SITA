<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ubicacion extends Model
{
    protected $table = 'ubicaciones';

    protected $fillable = [
        'nombre', 
        'descripcion', 
        'activo', 
        'key_id',
        'updated_at',
        'deleted_at'
    ];
}
