<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BecholorDegreeDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::connection('mysql_yr')->create('bechelor_degree_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('admission_id');
            $table->string('bechelor_degree');
            $table->string('subjects', 500)->nullable();
            $table->decimal('marks_obtained', 10,2)->nullable();
            $table->decimal('total_marks', 10,2)->nullable();
            $table->decimal('percentage', 10,2)->nullable();
            
            $table->string('honour_subject', 250)->nullable();
            $table->decimal('honour_marks', 10,2)->nullable();
            $table->decimal('honour_total_marks', 10,2)->nullable();
            $table->decimal('honour_percentage',10,2)->nullable();
            
            $table->string('elective_subject', 250)->nullable();
            $table->decimal('ele_obtained_marks',10,2)->nullable();
            $table->decimal('ele_total_marks', 10,2)->nullable();
            $table->decimal('ele_percentage', 10,2)->nullable();
            
            $table->string('pg_sem1_subject', 250)->nullable();
            $table->decimal('pg_sem1_obtained_marks', 10,2)->nullable();
            $table->decimal('pg_sem1_total_marks', 10,2)->nullable();
            $table->decimal('pg_sem1_percentage', 10,2)->nullable();
            
            $table->string('pg_sem2_subject', 250)->nullable();
            $table->decimal('pg_sem2_obtained_marks', 10,2)->nullable();
            $table->decimal('pg_sem2_total_marks', 10,2)->nullable();
            $table->decimal('pg_sem2_percentage', 10,2)->nullable();

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
