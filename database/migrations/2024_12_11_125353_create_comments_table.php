<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id()->comment('comment id');
            $table->mediumText('content')->comment('comment content');
            $table->unsignedTinyInteger('type')->default(1)->comment('1: comment, 2: reply');
            $table->unsignedTinyInteger('replyable')->default(1)->comment('0: not replyable, 1: replyable');
            $table->bigInteger('parent')->nullable()->comment('parent comment id');
            $table->unsignedInteger('likes')->default(0)->comment('number of likes');
            $table->unsignedInteger('dislikes')->default(0)->comment('number of dislikes');

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('comment_post', function (Blueprint $table) {
            $table->foreignId('comment_id')
            ->constrained('comments', 'id', 'comments_post_id')
            ->onUpdate('cascade')
            ->onDelete('cascade');

            $table->foreignId('post_id')
            ->constrained('posts', 'id', 'comment_posts_id')
            ->onUpdate('cascade')
            ->onDelete('cascade');

            $table->timestamps();
            $table->primary(['comment_id', 'post_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comment_post');
        Schema::dropIfExists('comments');
    }
};
