<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResearchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('researches', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('staff_id');
            $table->string('type')->nullable();
            $table->string('title1',500)->nullable();
            $table->string('title2',500)->nullable();
            $table->string('title3',500)->nullable();
            $table->string('paper_status',20)->nullable();
            $table->string('level',20)->nullable();
            $table->string('publisher',20)->nullable();
            $table->date('pub_date')->nullable();
            $table->string('pub_mode',15)->nullable();
            $table->string('isbn',20)->nullable();
            $table->string('authorship',20)->nullable();
            $table->string('institute',200)->nullable();
            $table->string('ugc_approved')->nullable();
            $table->string('indexing')->nullable();
            $table->string('indexing_other',100)->nullable();
            $table->string('doi_no',50)->nullable();
            $table->decimal('impact_factor',12,2)->nullable();
            $table->decimal('citations',12,2)->nullable();
            $table->decimal('h_index',12,2)->nullable();
            $table->decimal('i10_index',12,2)->nullable();
            $table->string('relevant_link',200)->nullable();
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
        Schema::dropIfExists('researches');
    }
}
