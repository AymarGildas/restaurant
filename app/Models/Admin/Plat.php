<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Plat extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'image',
        'menu_id',
        'type_id',
        'is_active',
    ];

    // Relationship to Menu
    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }
     public function type()
    {
        return $this->belongsTo(Type::class);
    }
}
