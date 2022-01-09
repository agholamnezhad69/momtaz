<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatMediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('media', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned();
            $table->enum('type', ['image', 'video', 'audio', 'zip', 'doc']);
            $table->json('files')->nullable();
            $table->string('filename', 255);
            $table->timestamps();
            /* $table->foreign('user_id')->references('id')->on('users')->onDelete("SET NULL");*/


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('media');
    }
}
