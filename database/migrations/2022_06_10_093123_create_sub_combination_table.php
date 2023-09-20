<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubCombinationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_yr')->create('sub_combination', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('course_id');
            $table->string('combination', 500);
            $table->string('code', 10)->nullable();
            $table->integer('created_by');
            $table->integer('updated_by');
            $table->timestamps();
        });

        Schema::connection('mysql_yr')->create('sub_combination_dets', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sub_combination_id');
            $table->integer('subject_id');
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
