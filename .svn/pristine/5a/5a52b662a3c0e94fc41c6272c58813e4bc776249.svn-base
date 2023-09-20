<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExams extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_yr')->create('attendance', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sub_sec_id');
            $table->integer('monthno');
            $table->integer('year');
            $table->integer('teacher_id');
            $table->integer('lectures');
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->timestamps();
        });
        Schema::connection('mysql_yr')->create('attendance_det', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('attendance_id');
            $table->integer('std_id');
            $table->integer('section_id');
            $table->integer('attended');
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->timestamps();
        });
        Schema::connection('mysql_yr')->create('exams', function (Blueprint $table) {
            $table->increments('id');
            $table->string('exam_name', 50);
            $table->integer('semester');
            $table->string('exam_type', 15);
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->timestamps();
        });
        Schema::connection('mysql_yr')->create('exam_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('exam_id');
            $table->integer('course_id');
            $table->integer('subject_id');
            $table->integer('min_marks');
            $table->integer('max_marks');
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->timestamps();
        });
        Schema::connection('mysql_yr')->create('marks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('exam_det_id');
            $table->integer('std_id');
            $table->integer('sub_sec_id');
            $table->decimal('marks', 10, 2);
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->timestamps();
            $table->unique(['exam_det_id', 'std_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql_yr')->dropIfExists('attendance');
        Schema::connection('mysql_yr')->dropIfExists('attendance_det');
        Schema::connection('mysql_yr')->dropIfExists('exams');
        Schema::connection('mysql_yr')->dropIfExists('exam_details');
        Schema::connection('mysql_yr')->dropIfExists('marks');
    }
}
