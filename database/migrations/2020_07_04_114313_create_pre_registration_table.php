<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePreRegistrationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::connection('mysql_yr')->create('pre_registration', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name',50);
            $table->string('father_name',50);
            $table->string('mobile_no',10);
            $table->string('add',200)->nullable();
            $table->string('email',50);
            $table->integer('course_id');
            $table->string('city',50);
            $table->integer('state_id');
            $table->char('hostel', 1)->default('N');
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
        Schema::connection('mysql_yr')->dropIfExists('pre_registration');
    }
}
