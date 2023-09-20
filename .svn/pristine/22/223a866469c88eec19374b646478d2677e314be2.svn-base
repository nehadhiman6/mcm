<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsInAdmFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_yr')->table('admission_forms', function (Blueprint $table) {
            if (Schema::connection('mysql_yr')->hasColumn('admission_forms', 'boarder') == false) {
                $table->string('boarder', 10)->default('')->after('gender');
            }
            if (Schema::connection('mysql_yr')->hasColumn('admission_forms', 'conv_mode') == false) {
                $table->string('conv_mode', 20)->default('')->after('pincode');
            }
            if (Schema::connection('mysql_yr')->hasColumn('admission_forms', 'veh_no') == false) {
                $table->string('veh_no', 15)->default('')->after('conv_mode');
            }
            if (Schema::connection('mysql_yr')->hasColumn('admission_forms', 'epic_no') == false) {
                $table->string('epic_no', 15)->default('')->after('aadhar_no');
            }
            if (Schema::connection('mysql_yr')->hasColumn('admission_forms', 'sports_seat') == false) {
                $table->char('sports_seat', 1)->default('N')->after('academic_id');
            }
            if (Schema::connection('mysql_yr')->hasColumn('admission_forms', 'sport_name') == false) {
                $table->string('sport_name', 25)->default('')->after('sports_seat');
            }
            if (Schema::connection('mysql_yr')->hasColumn('admission_forms', 'medium') == false) {
                $table->string('medium', 25)->default('English')->after('course_code');
            }
            if (Schema::connection('mysql_yr')->hasColumn('admission_forms', 'passport_validity') == false) {
                $table->date('passport_validity')->nullable()->after('passportno');
            }
            if (Schema::connection('mysql_yr')->hasColumn('admission_forms', 'visa_validity') == false) {
                $table->date('visa_validity')->nullable()->after('visa');
            }
            if (Schema::connection('mysql_yr')->hasColumn('admission_forms', 'res_validity') == false) {
                $table->date('res_validity')->nullable()->after('res_permit');
            }
        });

        Schema::connection('mysql_yr')->table('course_subject', function (Blueprint $table) {
            if (Schema::connection('mysql_yr')->hasColumn('course_subject', 'add_on_course') == false) {
                $table->char('add_on_course', 1)->default('N')->after('honours');
            }
        });

        Schema::connection('mysql_yr')->table('subject_group_det', function (Blueprint $table) {
            if (Schema::connection('mysql_yr')->hasColumn('subject_group_det', 'course_sub_id') == false) {
                $table->integer('course_sub_id')->default('0')->after('subject_id');
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
    }
}
