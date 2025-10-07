<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Worker extends Model
{
    use SoftDeletes;

    protected $table = 'workers';

    protected $fillable = [
        'name',
        'surname',
        'dni',
        'telefono',
        'email',
        'seguridad_social',
        'observaciones',
        'cuenta_bancaria'
    ];

    protected $casts =[
        'cuenta_bancaria' => 'encrypted:string',
    ];

    /*
    public function direccion()
    {
        return $this->hasOne(Direccion::class);
    }*/
}
