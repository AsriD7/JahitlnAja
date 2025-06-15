<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name'];

    /**
     * Get the products associated with the category.
     */
    public function services()
    {
        return $this->hasMany(Service::class);
    }
}
