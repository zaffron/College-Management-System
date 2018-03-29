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
        Schema::create('students', function (Blueprint $table) {
            $table->increments('id');
            $table->string('regno')->unique();
	        $table->string('name');
	        $table->string('email')->unique();
	        $table->string('gender');
	        $table->string('contact');
            $table->string('address')->nullable();
	        $table->date('dob');
            $table->string('semester')->default('1');
            $table->string('parent_contact')->nullable();
	        $table->string('course');
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
        Schema::dropIfExists('"students"');
    }
}
