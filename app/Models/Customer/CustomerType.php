<?php

namespace App\Models\Customer;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CustomerType extends Model
{
    use HasFactory;
      protected $table = 'types';  // <-- Use the same table

    protected $fillable = [
        'name',
        'description',
        'user_id',

    ];
   
    
}
