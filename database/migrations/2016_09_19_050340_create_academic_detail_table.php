<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAcademicDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_yr')->create('academic_detail', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('admission_id');
            $table->string('exam',50)->nullable();
            $table->string('institute',50)->nullable();
            $table->integer('board_id')->nullable();
            $table->string('rollno',10)->nullable();
            $table->integer('year')->default('0');
            $table->string('result',10)->nullable();
            $table->integer('marks')->nullable();
            $table->integer('marks_per')->nullable();
            $table->string('subjects',200)->nullable();
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
        Schema::connection('mysql_yr')->dropIfExists('academic_detail');
    }
}
