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
            $table->unsignedTinyInteger('replyable')->default(1)->comment('0: not replyable, 1: replyable');
            $table->foreignId('user_id')
            ->nullable()
            ->constrained('users', 'id', 'comments_user_id')
            ->onUpdate('cascade')
            ->onDelete('set null');

            $table->foreignId('post_id')
            ->nullable()
            ->constrained('posts', 'id', 'comments_post_id')
            ->onUpdate('cascade')
            ->onDelete('set null');

            $table->foreignId('parent_id')
            ->nullable()
            ->constrained('comments', 'id', 'comments_parent_id')
            ->onUpdate('cascade')
            ->onDelete('set null');

            $table->unsignedInteger('likes')->default(0)->comment('number of likes');
            $table->unsignedInteger('dislikes')->default(0)->comment('number of dislikes');

            $table->timestamps();
            $table->softDeletes();
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
