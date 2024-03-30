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
        Schema::create('attributes', function (Blueprint $table) {
        $table->id();
$table->integer('attribute_catalogue_id')->default(0);
$table->string('image')->nullable();
$table->string('album')->nullable();
$table->string('icon')->nullable();
$table->integer('order')->default(0);
$table->tinyInteger('publish')->default(0);
$table->tinyInteger('follow')->default(0);
$table->foreignId('user_id')->constrained()->onDelete('cascade');
$table->softDeletes();
$table->timestamps();;
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attributes');
    }
};