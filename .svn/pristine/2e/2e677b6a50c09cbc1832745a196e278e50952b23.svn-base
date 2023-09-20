<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFeildsInti extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::connection('mysql_yr')->hasColumn('sub_sec_students', 'course_id') == false) {
            Schema::connection('mysql_yr')->table('sub_sec_students', function (Blueprint $table) {
                $table->integer('course_id')->after('std_id')->nullable();  
            });
        }

        if (Schema::connection('mysql_yr')->hasColumn('sub_sec_students', 'subject_id') == false) {
            Schema::connection('mysql_yr')->table('sub_sec_students', function (Blueprint $table) {
                $table->integer('subject_id')->after('course_id')->nullable();  
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
