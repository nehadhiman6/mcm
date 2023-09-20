<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlumaniRevIntiFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('alumni_users', function (Blueprint $table) {
            if (Schema::hasColumn('alumni_users', 'mobile') == false) {
                $table->string('mobile', 15)->after('email')->nullable();
            }
            if (Schema::hasColumn('alumni_users', 'confirmed') == false) {
                $table->boolean('confirmed')->default(0)->after('mobile');
            }
            if (Schema::hasColumn('alumni_users', 'confirmation_code') == false) {
                $table->string('confirmation_code',30)->after('confirmed')->nullable();
            }
        });

        Schema::table('alumni_stu_qual', function (Blueprint $table) {
            if (Schema::hasColumn('alumni_stu_qual', 'subject') == false) {
                $table->string('subject', 1000)->after('course_id')->nullable();
            }
            if (Schema::hasColumn('alumni_stu_qual', 'other_course') == false) {
                $table->string('other_course', 1000)->after('other_institute')->nullable();
            }
            if (Schema::hasColumn('alumni_stu_qual', 'passing_year') == false) {
                $table->string('passing_year')->after('degree_type')->nullable();
            }
            if (Schema::hasColumn('alumni_stu_qual', 'research_area') == false) {
                $table->string('research_area',1000)->after('passing_year')->nullable();
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
