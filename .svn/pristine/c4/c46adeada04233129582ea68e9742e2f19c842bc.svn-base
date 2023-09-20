<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsIntoCourseAndMarksentry extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::connection('mysql_yr')->table('courses', function (Blueprint $table) {
            $table->integer('parent_course_id')->default(0)->after('course_id');
        });
        Schema::connection('mysql_yr')->table('marks', function (Blueprint $table) {
            $table->char('status',1)->default('P')->after('marks');
        });
        Schema::connection('mysql_yr')->table('marks_subject_sub', function (Blueprint $table) {
            $table->char('status',1)->default('P')->after('marks');
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql_yr')->table('courses', function (Blueprint $table) {
            $table->dropColumn(['parent_course_id']);
        });
        Schema::connection('mysql_yr')->table('marks', function (Blueprint $table) {
            $table->dropColumn(['status']);
        });
        Schema::connection('mysql_yr')->table('marks_subject_sub', function (Blueprint $table) {
            $table->dropColumn(['status']);
        });
    }
}
