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
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->integer('commentable_id');
            $table->string('commentable_type');
            $table->integer('parent_id')->default(0);
            $table->integer('left')->default(0);
            $table->integer('right')->default(0);
            $table->integer('level')->default(0);
            $table->integer('rate');
            $table->string('fullname');
            $table->string('email');
            $table->string('phone', 20);
            $table->text('description');
            $table->tinyInteger('publish')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
