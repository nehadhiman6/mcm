<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToAdmissionEntriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_yr')->table('admission_entries', function (Blueprint $table) {
            // if (Schema::connection('mysql_yr')->hasColumn('admission_entries', 'roll_no') == false) {
            //     $table->string('roll_no', 25)->default('')->after('admission_id');
            // }
            if (Schema::connection('mysql_yr')->hasColumn('admission_entries', 'addon_course_id') == false) {
                $table->integer('addon_course_id')->default(0)->after('admission_id');
            }
            if (Schema::connection('mysql_yr')->hasColumn('admission_entries', 'honour_sub_id') == false) {
                $table->integer('honour_sub_id')->default(0)->after('addon_course_id');
            }
            // if (Schema::connection('mysql_yr')->hasColumn('admission_entries', 'conveyance') == false) {
            //     $table->char('conveyance', 1)->default('N')->after('honour_sub_id');
            // }
            // if (Schema::connection('mysql_yr')->hasColumn('admission_entries', 'veh_no') == false) {
            //     $table->string('veh_no', 15)->default('')->after('conveyance');
            // }
            // if (Schema::connection('mysql_yr')->hasColumn('admission_entries', 'selected_ele_id') == false) {
            //     $table->integer('selected_ele_id')->default(0)->after('addon_course_id');
            // }
        });

        Schema::connection('mysql_yr')->table('student_subs', function (Blueprint $table) {
            if (Schema::connection('mysql_yr')->hasColumn('student_subs', 'ele_group_id') == false) {
                $table->integer('ele_group_id')->default(0)->after('sub_group_id');
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
        // Schema::connection('mysql_yr')->table('admission_entries', function (Blueprint $table) {
        //     $table->dropColumn('roll_no');
        //     $table->dropColumn('addon_course_id');
        //     $table->dropColumn('honour_sub_id');
        //     $table->dropColumn('conveyance');
        //     $table->dropColumn('veh_no');
        // });
    }
}
