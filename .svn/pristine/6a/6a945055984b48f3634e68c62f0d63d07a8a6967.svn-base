<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_yr')->create('courses', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('class_code',50);
            $table->integer('sno');
            $table->string('course_id',10);
            $table->string('course_name',50)->nullable();
            $table->integer('course_year')->nullable();
            $table->string('st_rollno',20)->nullable();
            $table->string('end_rollno',20)->nullable();
            $table->string('status',10)->nullable();
            $table->char('sub_combination',1)->default('N');
            $table->string('sub_no',10)->nullable();
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
        Schema::connection('mysql_yr')->dropIfExists('courses');
    }
}
