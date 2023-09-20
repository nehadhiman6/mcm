<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableStudentTimetable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_yr')->create('students_timetable', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('roll_no')->dafault(0);
            $table->integer('std_id')->dafault(0);
            $table->string('subjects',1000)->nullable();
            $table->string('honours',500)->nullable();
            $table->string('add_on',500)->nullable();
            $table->string('period_0',200)->nullable();
            $table->string('period_1',200)->nullable();
            $table->string('period_2',200)->nullable();
            $table->string('period_3',200)->nullable();
            $table->string('period_4',200)->nullable();
            $table->string('period_5',200)->nullable();
            $table->string('period_6',200)->nullable();
            $table->string('period_7',200)->nullable();
            $table->string('period_8',200)->nullable();
            $table->string('period_9',200)->nullable();
            $table->string('period_10',200)->nullable();
            $table->string('location',100)->nullable();
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
        Schema::connection('mysql_yr')->dropIfExists('students_timetable');
    }
}
