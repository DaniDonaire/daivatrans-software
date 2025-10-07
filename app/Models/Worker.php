<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Worker extends Model
{
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
