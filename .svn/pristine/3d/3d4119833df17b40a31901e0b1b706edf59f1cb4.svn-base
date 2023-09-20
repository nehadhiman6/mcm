<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableSubjectSectionDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::connection('mysql_yr')->create('sub_section_dets', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('sub_sec_id');
            $table->integer('teacher_id');
            $table->string('sub_subject_name');
            $table->string('is_practical');
            $table->timestamps();
        });
      }
    
      /**
       * Reverse the migrations.
       *
       * @return void
       */
      public function down() {
        Schema::connection('mysql_yr')->dropIfExists('sub_section_dets');
      }
}
