<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStaff extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('desigs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 50);
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->timestamps();
        });
        Schema::create('departments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 50);
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->timestamps();
        });
        Schema::create('staff', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type', 25);
            $table->string('source', 50);
            $table->string('first_name', 50);
            $table->string('last_name', 50);
            $table->integer('desig_id');
            $table->integer('dept_id');
            $table->string('mobile', 10)->nullable();
            $table->string('email', 255)->nullable();
            $table->string('address', 100)->nullable();
            $table->string('remarks', 100)->nullable();
            $table->string('gender', 1)->default('M');
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->timestamps();
        });
        Schema::connection('mysql_yr')->create('attendance', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sub_sec_id');
            $table->string('month', 3);
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
            $table->integer('attended');
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
        Schema::dropIfExists('desigs');
        Schema::dropIfExists('departments');
        Schema::dropIfExists('staff');
        Schema::connection('mysql_yr')->dropIfExists('attendance');
        Schema::connection('mysql_yr')->dropIfExists('attendance_det');
    }
}
