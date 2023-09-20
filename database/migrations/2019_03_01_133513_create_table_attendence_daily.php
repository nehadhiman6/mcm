<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableAttendenceDaily extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_yr')->create('attendance_daily', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->date('attendance_date')->nullable();
            $table->integer('course_id')->nullable();
            $table->integer('subject_id')->nullable();
            $table->integer('teacher_id')->nullable();
            $table->integer('sub_sec_id')->nullable();
            $table->integer('sub_subject_sec_id')->nullable();
            $table->integer('period_no')->nullable();
            $table->string('remarks',500)->nullable();
            $table->string('created_by');
            $table->string('updated_by');
            $table->timestamps();
        });
        Schema::connection('mysql_yr')->create('attendance_daily_dets', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('daily_attendance_id')->nullable();
            $table->integer('std_id')->nullable();
            $table->string('attendance_status',3)->nullable();
            $table->string('remarks',500)->nullable();
            $table->string('created_by');
            $table->string('updated_by');
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
        Schema::connection('mysql_yr')->dropIfExists('attendance_daily');
        Schema::connection('mysql_yr')->dropIfExists('attendance_daily_dets');
    }
}
