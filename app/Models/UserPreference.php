<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserPreference extends Model
{
    protected $fillable = ['user_id','dark_mode','sidebar_pinned'];
    protected $casts = ['dark_mode'=>'bool','sidebar_pinned'=>'bool'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

