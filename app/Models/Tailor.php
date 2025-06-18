<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tailor extends Model
{
    protected $fillable = ['user_id', 'specialization', 'experience'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    public function services()
    {
        return $this->belongsToMany(Service::class, 'service_tailors', 'tailor_id', 'service_id');
    }
}
