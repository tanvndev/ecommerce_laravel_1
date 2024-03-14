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
        Schema::create('post_language', function (Blueprint $table) {
            $table->foreignId('post_id')->constrained('posts')->onDelete('cascade');
            $table->foreignId('language_id')->constrained('languages')->onDelete('cascade');
            $table->integer('viewed');
            $table->string('name');
            $table->text('description');
            $table->text('content');
            $table->string('canonical')->unique();
            $table->string('meta_title');
            $table->string('meta_keyword');
            $table->text('meta_description');
        });

        // + post_id
        // + language_id
        // + viewed
        // + name (tên bài viết)
        // + description (mô tả ngắn)
        // + canonical (đường dẫn truy cập danh mục)
        // + content (nội dung bài viết)
        // + meta_title (tiêu đề SEO)
        // + meta_description (mô tả SEO)
        // + meta_keyword (từ khoá SEO)
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('post_language');
    }
};
