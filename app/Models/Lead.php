<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'contact_date',
        'description',
        'status_id',
        'user_id',
        'service_id',
        'contact_method_id',
        'tipo_operacion',
    ];

    /**
     * Get the status associated with the lead.
     */
    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    /**
     * Get the user associated with the lead.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    /**
     * Get the contact method associated with the lead.
     */
    public function contactMethod()
    {
        return $this->belongsTo(ContactMethod::class);
    }

    public function notes()
    {
        return $this->hasMany(LeadNote::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
