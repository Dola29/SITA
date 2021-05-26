<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TrabajoAsesor extends Model
{
    protected $table = 'trabajo_asesores';

    protected $fillable = [
        'trabajo_id',
        'asesor_id',
        'key_id',
        'updated_at',
        'deleted_at'
    ];

    public function asesor()
    {
        return $this->belongsTo('App\Asesor');
    }
    public function trabajo()
    {
        return $this->belongsTo('App\Trabajo');
    }
}
