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
        Schema::table('users', function (Blueprint $table) {
            $table->string('reset_password_token')
                ->nullable()
                ->default(null)
                ->comment('User reset password token');

            $table->string('email_validate_token')
                ->nullable()
                ->default(null)
                ->comment('User email validate token');

            $table->integer('register_type')
                ->unsigned()
                ->default(0)
                ->comment('register type, 0: normal(default), 1: google, 2: facebook');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('register_type');
            $table->dropColumn('email_validate_token');
            $table->dropColumn('reset_password_token');
        });
    }
};
