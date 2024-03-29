<?php

use ali\User\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('username', 50)->unique()->nullable();
            $table->string('headline')->nullable();
            $table->string('mobile', 15)->unique()->nullable();
            $table->text('bio')->nullable();
            $table->string('website')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('facebook')->nullable();
            $table->string('youtube')->nullable();
            $table->string('twitter')->nullable();
            $table->string('instagram')->nullable();
            $table->string('telegram')->nullable();
            $table->string('ip')->nullable();
            $table->bigInteger('image_id')->unsigned()->nullable();

            $table->string('card_number', 16)->nullable();
            $table->string('shaba', 24)->nullable();

            $table->bigInteger('balance')->default(0);

            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->enum('status', User::$statuses)->default("active");
            $table->rememberToken();
            $table->timestamps();
            $table->foreign('image_id')->references('id')->on('media')->onDelete("SET NULL");


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
