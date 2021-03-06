<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class GraduatedStudents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('graduated_students', function (Blueprint $table) {
            $table->increments('id');
            $table->string('regno')->unique();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('gender');
            $table->string('contact');
            $table->string('address')->nullable();
            $table->date('dob');
            $table->string('semester');
            $table->string('section');
            $table->string('course');
            $table->string('p_contact');
            $table->string('p_email')->nullable();
            $table->text('avatar')->nullable();
            $table->string('proctor');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('graduated_students');
    }
}
