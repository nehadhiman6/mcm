<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStaffCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('staff_courses', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('staff_id');
            $table->string('courses',50)->nullable();
            $table->string('topic',200)->nullable();
            $table->date('begin_date')->nullable();
            $table->date('end_date')->nullable();
            $table->integer('university_id')->nullable();
            $table->string('other_university', 250)->nullable();
            $table->integer('created_by');
            $table->integer('updated_by');
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
        Schema::dropIfExists('staff_courses');
    }
}
