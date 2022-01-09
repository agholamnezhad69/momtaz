<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use ali\Course\Models\Course;

class CreateCoursesTable extends Migration
{
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('teacher_id')->unsigned();
            $table->bigInteger('category_id')->unsigned()->nullable();
            $table->unsignedBigInteger('banner_id')->nullable();
            $table->string('title');
            $table->string('slug');
            $table->float('priority')->nullable();
            $table->string('price', 10);
            $table->string('percent', 5);
            $table->enum('type', Course::$types);
            $table->enum('statues', Course::$statuses);
            $table->enum('confirmation_status', Course::$confirmation_statuses);
            $table->longText('body')->nullable();
            $table->timestamps();
            $table->foreign('category_id')->references('id')->on('categories')->onDelete("SET NULL");
            $table->foreign('teacher_id')->references('id')->on('users')->onDelete("CASCADE");
            $table->foreign('banner_id')->references('id')->on('media')->onDelete("SET NULL");


        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('courses');
    }
}
