<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePuExamMastersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_yr')->create('pu_exams', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('course_id');
            $table->string('exam_name');
            $table->integer('semester')->nullable();
            $table->integer('created_by');
            $table->integer('updated_by');
            $table->timestamps();
        });

        Schema::connection('mysql_yr')->create('pu_exam_dets', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('pu_exam_id');
            $table->integer('subject_id');
            $table->decimal('min_marks', 10, 2);
            $table->decimal('max_marks', 10, 2);
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
        //
    }
}
