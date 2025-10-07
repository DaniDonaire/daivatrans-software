<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    // Relación con leads
    public function leads()
    {
        return $this->hasMany(Lead::class);
    }
    
}
