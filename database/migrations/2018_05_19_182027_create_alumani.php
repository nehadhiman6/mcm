<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlumani extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_yr')->create('alumani', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('passing_year', 10)->nullable();
            $table->string('occupation', 25)->nullable()->default('');
            $table->string('designation', 25)->nullable()->default('');
            $table->string('contact', 25)->nullable()->default('');
            $table->string('email', 30)->nullable()->default('');
            $table->string('other', 100)->nullable()->default('');
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
        Schema::connection('mysql_yr')->dropIfExists('alumani');
    }
}
