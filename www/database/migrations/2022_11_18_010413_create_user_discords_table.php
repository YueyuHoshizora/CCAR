<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_discord', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->enum('socialite', ['discord', 'twitch', 'youtube']);
            $table->string('uid', 255);

            $table->string('name', 255);
            $table->string('email', 255)->nullable(true);
            $table->string('avatar', 255)->nullable(true);

            $table->string('token', 255);
            $table->timestamp('expires')->nullable(true);

            $table->softDeletes();
            $table->timestamps();

            $table->unique(['socialite', 'uid']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_discords');
    }
};
