<?php

namespace App\Models\Customer;
use App\Models\Customer\CustomerMenu; 
use App\Models\Customer\CustomerType; 
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CustomerPlat extends Model
{
    use HasFactory;
      protected $table = 'plats';  // <-- Use the same table

    protected $fillable = [
        'name',
        'description',
        'price',
        'image',
        'menu_id',
        'is_active',
    ];

    /**
     * Get the menu that the plat belongs to.
     */
    public function menu()
    {
        // A plat belongs to one Menu
        return $this->belongsTo(CustomerMenu::class, 'menu_id');
    }

    /**
     * Get the type that the plat belongs to.
     */
    public function type()
    {
        // A plat belongs to one Type
        return $this->belongsTo(CustomerType::class, 'type_id');
    }
}
