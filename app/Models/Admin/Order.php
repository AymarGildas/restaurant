<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'total_amount',
        'status',
        'delivery_type',
        'delivery_address',
        'payment_status',
        'notes',
    ];

    // Customer relation
    public function customer()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

   
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

}
