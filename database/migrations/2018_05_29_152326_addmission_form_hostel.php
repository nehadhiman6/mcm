<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddmissionFormHostel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::connection('mysql_yr')->dropIfExists('admission_form_hostel');
        Schema::connection('mysql_yr')->create('admission_form_hostel', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('admission_id');
            $table->string('serious_ailment', 100)->nullable();
            $table->string('prv_hostel_block',30)->nullable();
            $table->string('prv_room_no', 30)->nullable();
            $table->string('prv_class', 30)->nullable();
            $table->string('prv_roll_no', 30)->nullable();
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
        Schema::connection('mysql_yr')->dropIfExists('admission_form_hostel');
       
    }
}
