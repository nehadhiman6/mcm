<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHostelnightOutEntryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_yr')->create('hostel_night_out', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('roll_no',20);
            $table->string('destination_address',200)->nullable();
            $table->date('departure_date');
            $table->time('departure_time');
            $table->date('expected_return_date')->nullable();
            $table->date('actual_return_date')->nullable();
            $table->char('return_status',1)->default('P');
            $table->string('remarks',400)->nullable();
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
        Schema::connection('mysql_yr')->dropIfExists('hostel_night_out');        
    }
}
