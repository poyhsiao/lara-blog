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
        Schema::create('emotions', function (Blueprint $table) {
            $table->id()->comment('emotion id');
            $table->string('name')->unique()->comment('emotion name');
            $table->string('description')->nullable()->comment('emotion description');
            $table->string('avatar')->nullable()->comment('emotion avatar');

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('emotionables', function (Blueprint $table) {
            $table->id()->comment('emotion user id');

            $table->foreignId('emotion_id')
                ->nullable()
                ->constrained('emotions', 'id', 'emotions_users_emotion_id')
                ->onUpdate('cascade')
                ->onDelete('set null');

            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users', 'id', 'emotions_users_user_id')
                ->onUpdate('cascade')
                ->onDelete('set null');

            $table->morphs('emotionable');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emotionables');
        Schema::dropIfExists('emotions');
    }
};
