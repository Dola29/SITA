<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TrabajoSustentante extends Model
{
    protected $fillable = [
        'trabajo_id',
        'sustentante_id',
        'key_id',
        'updated_at',
        'deleted_at'
    ];

    public function sustentante()
    {
        return $this->belongsTo('App\Sustentante');
    }

    public function trabajo()
    {
        return $this->belongsTo('App\Trabajo');
    }
}
