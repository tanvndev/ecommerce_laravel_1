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
        Schema::create('post_catalogues', function (Blueprint $table) {
            $table->id();
            $table->integer('parent_id')->default(0);
            $table->integer('left')->default(0);
            $table->integer('right')->default(0);
            $table->integer('level')->default(0);
            $table->string('image')->nullable();
            $table->string('icon')->nullable();
            $table->text('album')->nullable();
            $table->tinyInteger('publish')->default(1);
            $table->integer('order')->default(0);
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->softDeletes();
            $table->timestamps();
        });
        // + id
        // + parent_id (lưu mã danh mục cha)
        // + left (giá trị bên trái của node)
        // + right (giá trị bên trái của node)
        // + level (cấp của node đó)
        // + image (ảnh đại diện)
        // + icon (ảnh nhỏ)
        // + album (danh sách ảnh)
        // + publish (trạng thái)
        // + order (sắp xếp các danh mục)
        // + user_id (người tạo ra danh mục)
        // + deleted_at 
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('post_catalogues');
    }
};
