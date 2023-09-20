<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePuExamStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_yr')->create('pu_exam_students', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('pu_exam_id');
            $table->integer('std_id');
            $table->char('fail', 1)->default('N');
            $table->string('uni_agregate',10);
            $table->string('remarks',500)->nullable();
            $table->integer('created_by');
            $table->integer('updated_by');
            $table->timestamps();
        });

        Schema::connection('mysql_yr')->create('pu_marks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('pu_exam_det_id');
            $table->integer('std_id');
            $table->decimal('marks', 10, 2);
            $table->char('compartment', 1)->default('N');
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
