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
        Schema::create('attribute_catalogue_language', function (Blueprint $table) {
            $table->foreignId('attribute_catalogue_id')->constrained('attribute_catalogues')->onDelete('cascade');
    $table->foreignId('language_id')->constrained('languages')->onDelete('cascade');
    $table->string('name');
    $table->text('description')->nullable();
    $table->text('content')->nullable();
    $table->string('canonical');
    $table->string('meta_title')->nullable();
    $table->string('meta_keyword')->nullable();
    $table->text('meta_description')->nullable();
    $table->softDeletes();
    $table->timestamps();;
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attribute_catalogue_language');
    }
};