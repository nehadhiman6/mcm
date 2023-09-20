<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDateSheetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_yr')->create('date_sheets', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('course_subject_id');
            $table->integer('subject_id');
            $table->integer('course_id');
            $table->date('date');
            $table->string('session',50);
            $table->string('exam_name',50);
            $table->integer('created_by');
            $table->integer('updated_by');
            $table->timestamps();
        });

        Schema::connection('mysql_yr')->create('exam_locations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('loc_id');
            $table->integer('seating_capacity');
            $table->integer('no_of_rows');
            $table->string('center',50);
            $table->integer('created_by');
            $table->integer('updated_by');
            $table->timestamps();
        });

        Schema::connection('mysql_yr')->create('exam_locations_dets', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('exam_location_id');
            $table->integer('row_no');
            $table->integer('seats_in_row');
            $table->integer('created_by');
            $table->integer('updated_by');
            $table->timestamps();
        });
// 
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
