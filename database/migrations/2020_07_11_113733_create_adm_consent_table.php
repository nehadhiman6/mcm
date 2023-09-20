<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdmConsentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_yr')->create('adm_consent', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('admission_id');
            $table->integer('preference_no')->default(0);
            $table->integer('honour_sub_id')->default(0);
            $table->char('ask_student', 1)->default('N'); //Y/N
            $table->char('student_answer', 1)->default('R'); //R/Y/N
            $table->char('upgrade_later', 1)->default('N'); //Y/N
            $table->integer('user_id');
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
        Schema::connection('mysql_yr')->dropIfExists('adm_consent');
    }
}
