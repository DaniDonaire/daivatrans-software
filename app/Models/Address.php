<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $table = 'addresses';

    protected $fillable = [
        'worker_id',
        'street',
        'city',
        'province',
        'postal_code',
        'country',
    ];

    public function worker()
    {
        return $this->belongsTo(Worker::class);
    }
}
