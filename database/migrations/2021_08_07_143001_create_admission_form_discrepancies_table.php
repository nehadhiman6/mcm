<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdmissionFormDiscrepanciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_yr')->create('admission_form_discrepancies', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('admission_id');
            $table->string('opt_name',100);
            $table->char('opt_value', 1)->default('N');
            $table->string('remarks',500)->nullable();
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
