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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained();
            $table->string('name');
            $table->string('email');
            $table->text('address');
            $table->decimal('total_amount', 10, 2);
            $table->json('cart_data')->nullable();
            
            // New fields
            $table->string('transaction_id')->nullable();
            $table->string('payment_method')->default('cash_on_delivery'); // default cash
           $table->enum('payment_status', ['unpaid', 'paid'])->default('unpaid');
 // default pending
 $table->decimal('collected_amount', 10, 2)->nullable();

        
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
