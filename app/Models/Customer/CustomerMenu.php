<?php

namespace App\Models\Customer;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CustomerMenu extends Model
{
 use HasFactory;
      protected $table = 'menus';  // <-- Use the same table

    protected $fillable = [
        'name',
        'description',
        'user_id',

    ];
    
   
}
