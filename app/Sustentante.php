<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sustentante extends Model
{
    protected $fillable = [
        'nombre', 
        'matricula', 
        'telefono',
        'correo',
        'activo', 
        'key_id',
        'updated_at',
        'deleted_at'
    ];
}
