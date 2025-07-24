<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Type extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'user_id',

    ];
       /**
     * Get the user that owns the menu.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
}
