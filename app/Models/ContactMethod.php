<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactMethod extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    /**
     * Get the leads associated with the contact method.
     */
    public function leads()
    {
        return $this->hasMany(Lead::class);
    }
}
