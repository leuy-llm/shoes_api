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
            $table->string('title');
            $table->string('img'); // URL of image
            $table->decimal('prev_price', 10, 2)->nullable();
            $table->decimal('new_price', 10, 2);
            $table->integer('rating')->default(0);
            $table->string('reviews')->nullable();
            $table->string('company')->nullable();
            $table->string('brand')->nullable();
            $table->string('color')->nullable();
            $table->string('category')->nullable();
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
