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
        Schema::create('posts', function (Blueprint $table) {
            $table->id()->comment('post id');
            $table->string('title')->unique()->comment('post title');
            $table->string('slug')->unique()->comment('post slug');
            $table->mediumText('content')->comment('post content');
            $table->unsignedTinyInteger('publish_status')->default(1)->comment('0: trashed, 1: draft, 2: published');
            $table->foreignId('author')
            ->constrained('users', 'id', 'posts_user_id')
            ->onUpdate('cascade')
            ->onDelete('cascade')
            ->commented('post author reference to user id');

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('categories', function (Blueprint $table) {
            $table->id()->comment('category id');
            $table->string('name')->Unique()->comment('category name');
            $table->string('slug')->unique()->comment('category slug');
            $table->string('description')->nullable()->comment('category description');
            $table->bigInteger('parent')->nullable()->comment('parent category id');

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('tags', function (Blueprint $table) {
            $table->id()->comment('tag id');
            $table->string('name')->Unique()->comment('tag name');
            $table->string('description')->nullable()->comment('tag description');

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('category_post', function (Blueprint $table) {
            $table->foreignId('category_id')
            ->constrained('categories', 'id', 'categories_post_id')
            ->onUpdate('cascade')
            ->onDelete('cascade');

            $table->foreignId('post_id')
            ->constrained('posts', 'id', 'posts_category_id')
            ->onUpdate('cascade')
            ->onDelete('cascade');

            $table->timestamps();
            $table->primary(['category_id','post_id']);
        });

        Schema::create('post_tag', function (Blueprint $table) {
            $table->foreignId('post_id')
            ->constrained('posts', 'id', 'posts_tag_id')
            ->onUpdate('cascade')
            ->onDelete('cascade');

            $table->foreignId('tag_id')
            ->constrained('tags', 'id', 'tags_post_id')
            ->onUpdate('cascade')
            ->onDelete('cascade');

            $table->timestamps();
            $table->primary(['post_id','tag_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('post_tag');
        Schema::dropIfExists('category_post');
        Schema::dropIfExists('tags');
        Schema::dropIfExists('categories');
        Schema::dropIfExists('posts');
    }
};
