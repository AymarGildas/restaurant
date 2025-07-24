<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SiteSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'site_name',
        'primary_color',
        'secondary_color',
        'contact_email',
        'phone_number',
        'payment_info',
        'footer_address',
        'footer_about_text',
        'social_facebook_url',
        'social_instagram_url',
        'social_twitter_url',
    ];
}
