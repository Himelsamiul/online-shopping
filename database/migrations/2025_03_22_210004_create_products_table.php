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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('category_id')->constrained()->onDelete('restrict'); // Prevent category deletion if products exist
            $table->foreignId('unit_id')->constrained()->onDelete('restrict'); // Prevent unit deletion if products exist
            $table->foreignId('size_id'); // Prevent size deletion if products exist
            $table->text('description');
            $table->string('image')->nullable(); // Path for image
            $table->decimal('price', 10, 2);
             $table->decimal('previous_price', 10, 2)->nullable();
            $table->integer('quantity');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
