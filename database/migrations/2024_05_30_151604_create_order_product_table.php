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
        Schema::create('order_product', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->string('uuid')->nullable();
            $table->string('name');
            $table->integer('quantity');
            $table->double('price');
            $table->double('price_sale')->nullable();
            $table->json('promotion')->nullable();
            $table->json('option')->nullable();
            $table->timestamps();
        });
    }

    // - uuid null
    // - name
    // - quantity
    // - price
    // - price_sale
    // - promotion
    // - option

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_product');
    }
};
