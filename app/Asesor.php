<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Asesor extends Model
{
    protected $table = 'asesores';

    protected $fillable = [
        'nombre', 
        'telefono', 
        'correo', 
        'activo', 
        'key_id',
        'updated_at',
        'deleted_at'
    ];
}
