<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldInStaffCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('staff_courses', function (Blueprint $table) {
            if (Schema::hasColumn('staff_courses', 'other_course') == false) {
                $table->string('other_course', 50)->nullable()->after('courses');
            }
            if (Schema::hasColumn('staff_courses', 'level') == false) {
                $table->string('level', 20)->after('other_university');
            }
            if (Schema::hasColumn('staff_courses', 'duration_days') == false) {
                $table->integer('duration_days')->after('level');
            }
            if (Schema::hasColumn('staff_courses', 'org_by') == false) {
                $table->string('org_by', 100)->after('duration_days');
            }
            if (Schema::hasColumn('staff_courses', 'sponsored_by') == false) {
                $table->string('sponsored_by', 20)->nullable()->after('org_by');
            }
            if (Schema::hasColumn('staff_courses', 'other_sponsor') == false) {
                $table->string('other_sponsor', 50)->nullable()->after('sponsored_by');
            }
            if (Schema::hasColumn('staff_courses', 'collaboration_with') == false) {
                $table->string('collaboration_with', 50)->nullable()->after('other_sponsor');
            }
            if (Schema::hasColumn('staff_courses', 'aegis_of') == false) {
                $table->string('aegis_of', 50)->nullable()->after('collaboration_with');
            }
            if (Schema::hasColumn('staff_courses', 'participate_as') == false) {
                $table->string('participate_as', 30)->nullable()->after('aegis_of');
            }
            if (Schema::hasColumn('staff_courses', 'affi_inst') == false) {
                $table->string('affi_inst', 50)->nullable()->after('participate_as');
            }
            if (Schema::hasColumn('staff_courses', 'mode') == false) {
                $table->string('mode', 20)->nullable()->after('affi_inst');
            }
            if (Schema::hasColumn('staff_courses', 'certificate') == false) {
                $table->string('certificate', 100)->nullable()->after('mode');
            }
            if (Schema::hasColumn('staff_courses', 'remarks') == false) {
                $table->string('remarks', 50)->nullable()->after('certificate');
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
