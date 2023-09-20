<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSections extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_yr')->create('sections', function (Blueprint $table) {
            $table->increments('id');
            $table->string('section', 25);
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->timestamps();
        });
        Schema::connection('mysql_yr')->create('subject_sections', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('course_id');
            $table->integer('subject_id');
            $table->integer('section_id');
            $table->integer('teacher_id');
            $table->integer('students');
            $table->string('scheme', 15)->default('all');
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->timestamps();
        });
        Schema::connection('mysql_yr')->create('sub_sec_dets', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sub_sec_id');
            $table->integer('std_id');
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
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
        Schema::connection('mysql_yr')->dropIfExists('sections');
        Schema::connection('mysql_yr')->dropIfExists('subject_sections');
        Schema::connection('mysql_yr')->dropIfExists('sub_sec_dets');
    }
}
