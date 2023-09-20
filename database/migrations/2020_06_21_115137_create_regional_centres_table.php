<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRegionalCentresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_yr')->create('regional_centres', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('stu_id');
            $table->string('name',50);
            $table->string('father_name',50);
            $table->string('pupin_no',20);
            $table->string('roll_no',10);
            $table->string('app_no',20)->nullable();
            $table->integer('course_id');
            $table->integer('semester')->default(0);
            $table->string('mobile_no',10);
            $table->string('add',200);
            $table->string('email',50);
            $table->string('regional_centre',20);
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
        Schema::connection('mysql_yr')->dropIfExists('regional_centres');
    }
}
