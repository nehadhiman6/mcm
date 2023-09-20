<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SeatingPlan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_yr')->create('seating_plans', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('date_sheet_id');
            $table->integer('exam_loc_id');
            $table->integer('sub_sec_id');
            $table->integer('total_seats');
            $table->integer('occupied_seats');
            $table->integer('gap_seats');
            $table->date('date')->nullable();
            $table->string('session',50);
            $table->integer('created_by');
            $table->integer('updated_by');
            $table->timestamps();
        });

        Schema::connection('mysql_yr')->create('seating_plan_dets', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('seating_plan_id');
            $table->integer('std_id');
            $table->integer('seat_no');
            $table->integer('row_no');
            $table->integer('created_by');
            $table->integer('updated_by');
            $table->timestamps();
        });

        Schema::connection('mysql_yr')->create('seating_plan_staff', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('date_sheet_id');
            $table->integer('seating_plan_id');
            $table->date('date')->nullable();
            $table->string('session',50);
            $table->string('exam_name');
            $table->integer('staff_id');
            $table->integer('exam_loc_id');
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
