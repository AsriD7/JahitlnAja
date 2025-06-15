<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    protected $fillable = ['customer_id', 'tailor_id', 'service_id', 'measurement','reference_image', 'total_price', 'status', 'payment_proof'];

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function tailor()
    {
        return $this->belongsTo(Tailor::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
