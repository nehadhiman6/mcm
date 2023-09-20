<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStaffQualificationAndExperinecesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('staff_qualification', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('staff_id');
            $table->string('exam',250);
            $table->string('other_exam', 50)->nullable();
            $table->integer('institute_id')->nullable();
            $table->string('other_institute', 250)->nullable();
            $table->string('year', 10)->nullable();
            $table->decimal('percentage',4,2)->nullable();
            $table->string('division',50)->nullable();
            $table->string('distinction', 500)->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->timestamps();
        });

        Schema::create('staff_experiences', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('staff_id');
            $table->string('area_of_experience', 50)->nullable();
            $table->string('days', 10)->nullable();
            $table->string('months', 12)->nullable();
            $table->string('years', 50)->nullable();
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
        //
    }
}
