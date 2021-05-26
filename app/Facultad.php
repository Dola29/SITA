<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Facultad extends Model
{
    protected $table = 'facultades';

    protected $fillable = [
        'nombre', 
        'activo', 
        'key_id',
        'updated_at',
        'deleted_at'
    ];
}
