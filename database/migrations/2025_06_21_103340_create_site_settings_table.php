<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();
            $table->string('site_name')->nullable();
            $table->string('primary_color')->default('#4F46E5'); // Indigo 600 (Modern primary)
            $table->string('secondary_color')->default('#FBBF24'); // Amber 400 (Accent highlight)
            $table->string('contact_email')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('footer_address')->nullable(); // For the physical address

            // Footer: About & Social Links
            $table->text('footer_about_text')->nullable(); // For the "About FoodExpress" paragraph
            $table->string('social_facebook_url')->nullable();
            $table->string('social_instagram_url')->nullable();
            $table->string('social_twitter_url')->nullable();
            $table->text('payment_info')->nullable();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('site_settings');
    }
};
