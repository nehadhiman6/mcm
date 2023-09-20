<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlacementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_yr')->create('placements', function (Blueprint $table) {
            $table->increments('id');
            $table->date('drive_date');
            $table->char('type', 1);
            $table->string('nature', 20);
            $table->integer('comp_id');
            $table->string('hr_personnel', 50);
            $table->string('contact_no', 50);
            $table->string('email', 100);
            $table->string('staff_id');
            $table->string('job_profile',50);
            $table->integer('stu_reg')->default(0);
            $table->integer('stu_appear')->default(0);
            $table->decimal('min_salary', 12, 2)->default(0);
            $table->decimal('max_salary', 12, 2)->default(0);
            $table->integer('round_no')->default(0);
            $table->integer('created_by');
            $table->integer('updated_by');
            $table->timestamps();
        });

        Schema::connection('mysql_yr')->create('placement_students', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('placement_id');
            $table->integer('std_id');
            $table->string('email', 100)->nullable();
            $table->string('job_profile',50)->nullable();
            $table->string('remarks', 200)->nullable();
            $table->string('status')->default('SL');
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
        Schema::dropIfExists('placements');
        Schema::dropIfExists('placement_students');
    }
}
