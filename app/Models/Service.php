<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = ['name', 'category_id', 'description', 'price'];

    /**
     * Get the category that owns the service.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    /**
     * Get the user that owns the service.
     */
    public function order()
    {
        return $this->hasMany(Order::class);
    }
}
