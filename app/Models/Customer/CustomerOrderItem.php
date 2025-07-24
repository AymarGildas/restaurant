<?php

namespace App\Models\Customer;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Admin\Plat;

class CustomerOrderItem extends Model
{
    use HasFactory;
    protected $table = 'order_items';  

    protected $fillable = [
        'order_id',
        'plat_id',
        'quantity',
        'unit_price',
    ];

    // Relationship to the order
    public function order()
    {
        return $this->belongsTo(CustomerOrder::class, 'order_id');
    }

    // Relationship to the plat
    public function plat()
    {
        return $this->belongsTo(Plat::class, 'plat_id');
    }
}
