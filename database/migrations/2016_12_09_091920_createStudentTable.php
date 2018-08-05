<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student', function (Blueprint $table) {
            $table->increments('id', true);
            $table->text('firstname');
            $table->text('surname');
            $table->text('email');
            $table->text('nationality');
            $table->integer('address_id')->unsigned();
            $table->integer('course_id')->unsigned();
            $table->timestamps();
        });

        Schema::table('student', function( Blueprint $table) {
            $table->foreign('address_id')->references('id')->on('student_address');
            $table->foreign('course_id')->references('id')->on('course');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop("student");
    }
}
