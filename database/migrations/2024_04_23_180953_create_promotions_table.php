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
        Schema::create('promotions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('method');
            $table->string('code', 20);
            $table->json('discount_infomation')->nullable();
            $table->tinyInteger('publish')->default(0);
            $table->timestamp('start_at');
            $table->timestamp('end_at')->nullable();;
            $table->string('never_end', 20)->nullable();
            $table->integer('order')->default(0);
            $table->text('description')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promotions');
    }
};
