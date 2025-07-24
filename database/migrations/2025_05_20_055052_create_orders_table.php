<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   // database/migrations/xxxx_create_orders_table.php
public function up()
{
    Schema::create('orders', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained('users'); // customer
        $table->decimal('total_amount', 10, 2);
        $table->enum('status', ['pending', 'accepted', 'preparing', 'on_the_way', 'delivered', 'cancelled'])->default('pending');
        $table->enum('delivery_type', ['pickup', 'delivery'])->default('delivery');
        $table->string('delivery_address')->nullable();
        $table->enum('payment_status', ['pending', 'paid'])->default('pending');
        $table->text('notes')->nullable();
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
