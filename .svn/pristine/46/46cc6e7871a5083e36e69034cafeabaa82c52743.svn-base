<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablesForMarksIntoSubPapers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::connection('mysql_yr')->hasTable('exam_subject_sub') == false) {
            Schema::connection('mysql_yr')->create('exam_subject_sub', function (Blueprint $table) {
                $table->engine = 'InnoDB';
                $table->increments('id');
                $table->integer('exam_det_id');
                $table->string('paper_type');
                $table->string('paper_code');
                $table->integer('min_marks');
                $table->integer('max_marks');
                $table->integer('created_by')->nullable();
                $table->integer('updated_by')->nullable();
                $table->timestamps();
            });
        }

        if (Schema::connection('mysql_yr')->hasTable('marks_subject_sub') == false) {
            Schema::connection('mysql_yr')->create('marks_subject_sub', function (Blueprint $table) {
                $table->engine = 'InnoDB';
                $table->increments('id');
                $table->integer('marks_id');
                $table->string('exam_sub_id');
                $table->string('std_id');
                $table->integer('marks');
                $table->integer('created_by')->nullable();
                $table->integer('updated_by')->nullable();
                $table->timestamps();
            });
        }
          
        Schema::connection('mysql_yr')->table('exam_details', function (Blueprint $table) {
            if (Schema::connection('mysql_yr')->hasColumn('exam_details', 'paper_code') == false) {
                $table->string('paper_code')->after('subject_id')->nullable();
            }
            if (Schema::connection('mysql_yr')->hasColumn('exam_details', 'have_sub_papers') == false) {
                $table->char('have_sub_papers', 1)->after('paper_code')->default('N')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::connection('mysql_yr')->dropIfExists('exam_subject_sub');
        Schema::connection('mysql_yr')->dropIfExists('marks_subject_sub');
        Schema::connection('mysql_yr')->table('exam_details', function($table)
        {
            $table->dropColumn(['paper_code', 'have_sub_papers']);
        });
    }
}
