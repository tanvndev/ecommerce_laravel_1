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
            $table->string('code');
            $table->string('fullname');
            $table->string('phone', 20);
            $table->string('email', 50);
            $table->string('province_id', 10)->nullable();
            $table->string('district_id', 10)->nullable();
            $table->string('ward_id', 10)->nullable();
            $table->string('address');
            $table->string('payment_method');
            $table->string('description')->nullable();
            $table->json('promotion')->nullable();
            $table->json('cart')->nullable();
            $table->unsignedBigInteger('customer_id');
            $table->string('guest_cookie')->nullable();
            $table->string('confirm', 20);
            $table->string('payment', 20);
            $table->string('delevery', 20);
            $table->double('shipping')->default(0);
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
