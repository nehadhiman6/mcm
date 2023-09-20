<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeedbackSectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_yr')->create('feedback_sections', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 500)->unique();
            $table->integer('under_section_id')->default(0);
            $table->integer('sno');
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
        Schema::connection('mysql_yr')->dropIfExists('feedback_sections');
    }
}
