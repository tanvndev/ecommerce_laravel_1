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
        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->string('code')->nullable();
            $table->integer('quantity')->default(0);
            $table->float('price')->default(0);
            $table->text('album')->nullable();
            $table->string('sku')->nullable();
            $table->string('barcode')->nullable();
            $table->tinyInteger('publish')->default(1);
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('file_name')->nullable();;
            $table->string('file_url')->nullable();;
            $table->softDeletes();
            $table->timestamps();
        });
    }
    // -   id
    // -   product_id
    // -   code: (6,7), ...
    // -   sku
    // -   barcode
    // -   price
    // -   quantity
    // -   album
    // -   publish
    // -   user_id
    // -   file_name
    // -   file_url

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_variants');
    }
};
