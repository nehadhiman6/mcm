<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RevIntoSubjectSectionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::connection('mysql_yr')->hasColumn('subject_sections', 'has_sub_subjects') == false) {
            Schema::connection('mysql_yr')->table('subject_sections', function (Blueprint $table) {
                $table->char('has_sub_subjects')->after('teacher_id')->default('N');  
            });
        }
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
