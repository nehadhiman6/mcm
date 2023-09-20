<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateElectives extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_yr')->create('electives', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',500);
            $table->integer('course_id');
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->timestamps();
        });

        Schema::connection('mysql_yr')->create('elective_subject', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('ele_id');
            $table->integer('course_id');
            $table->integer('subject_id');
            $table->integer('course_sub_id');
            $table->string('sub_type',1);
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->timestamps();
        });

        Schema::connection('mysql_yr')->create('elective_group', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('ele_id');
            $table->integer('course_id');
            $table->integer('s_no');
            $table->string('group_name',200);
            $table->string('type',1);
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->timestamps();
        });

        Schema::connection('mysql_yr')->create('elective_group_det', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('ele_group_id');
            $table->integer('subject_id');
            $table->integer('course_sub_id');
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
        Schema::connection('mysql_yr')->dropIfExists('electives');
        Schema::connection('mysql_yr')->dropIfExists('elective_subject');
        Schema::connection('mysql_yr')->dropIfExists('elective_group');
        Schema::connection('mysql_yr')->dropIfExists('elective_group_det');
    }
}
