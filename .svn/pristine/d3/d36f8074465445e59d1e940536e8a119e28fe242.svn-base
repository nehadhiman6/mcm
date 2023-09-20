<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RevCoursesHonoursDetails extends Migration
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
            if (Schema::connection('mysql_yr')->hasColumn('courses', 'honours_link') == false) {
                $table->char('honours_link', 1)->default('N')->after('adm_close_date');
            }
        });
        Schema::connection('mysql_yr')->table('course_subject', function (Blueprint $table) {
            if (Schema::connection('mysql_yr')->hasColumn('course_subject', 'honours_sub_id') == false) {
                $table->integer('honours_sub_id')->default(0)->after('honours');
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
        //
    }
}
