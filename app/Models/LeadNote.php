<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeadNote extends Model
{
    protected $fillable = ['lead_id', 'note', 'reminder'];

    protected $casts = [
        'reminder' => 'datetime', 
    ];

    public function lead()
    {
        return $this->belongsTo(Lead::class);
    }
}
