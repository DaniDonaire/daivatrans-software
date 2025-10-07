<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;
    protected $table = 'status';

    protected $fillable = [
        'name',
        'color',
        'text_color',
    ];

    /**
     * Get the leads associated with this status.
     */
    public function leads()
    {
        return $this->hasMany(Lead::class);
    }
}
