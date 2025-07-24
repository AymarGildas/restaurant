<?php

namespace App\Models\Customer;

use App\Models\Admin\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Customer\CustomerOrderItem;

class CustomerOrder extends Model
{
    use HasFactory;
    protected $table = 'orders'; 

    protected $fillable = [
        'user_id',
        'total_amount',
        'status',
        'delivery_type',
        'delivery_address',
        'payment_status',
        'notes',
    ];

    // Relationship to customer user
    public function customer()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

   

    // Relationship to order items
    public function orderItems()
    {
        return $this->hasMany(CustomerOrderItem::class, 'order_id');
    }
}
