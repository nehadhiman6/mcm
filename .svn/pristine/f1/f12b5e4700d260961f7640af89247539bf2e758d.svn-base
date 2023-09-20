<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLatterTypeFieldInPlacementStudents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_yr')->table('placement_students', function (Blueprint $table) {
            if (Schema::connection('mysql_yr')->hasColumn('placement_students', 'letter_type') == false) {
                $table->string('letter_type',1)->nullable()->after('job_profile');
            }
        });
        
        Schema::connection('mysql_yr')->table('placement_students', function (Blueprint $table) {
            if (Schema::connection('mysql_yr')->hasColumn('placement_students', 'session') == false) {
                $table->string('session',8)->after('placement_id');
            }
        });

        Schema::connection('mysql_yr')->table('placement_students', function (Blueprint $table) {
            if (Schema::connection('mysql_yr')->hasColumn('placement_students', 'roll_no') == false) {
                $table->string('roll_no',50)->after('std_id');
            }
        });

        Schema::connection('mysql_yr')->table('placement_students', function (Blueprint $table) {
            if (Schema::connection('mysql_yr')->hasColumn('placement_students', 'name') == false) {
                $table->string('name',50)->after('roll_no');
            }
        });

        Schema::connection('mysql_yr')->table('placement_students', function (Blueprint $table) {
            if (Schema::connection('mysql_yr')->hasColumn('placement_students', 'father_name') == false) {
                $table->string('father_name',50)->after('name');
            }
        });

        Schema::connection('mysql_yr')->table('placement_students', function (Blueprint $table) {
            if (Schema::connection('mysql_yr')->hasColumn('placement_students', 'mother_name') == false) {
                $table->string('mother_name',50)->after('father_name');
            }
        });

        Schema::connection('mysql_yr')->table('placement_students', function (Blueprint $table) {
            if (Schema::connection('mysql_yr')->hasColumn('placement_students', 'course_id') == false) {
                $table->integer('course_id')->after('mother_name');
            }
        });

        Schema::connection('mysql_yr')->table('placement_students', function (Blueprint $table) {
            if (Schema::connection('mysql_yr')->hasColumn('placement_students', 'cat_id') == false) {
                $table->integer('cat_id')->after('course_id');
            }
        });

        Schema::connection('mysql_yr')->table('placement_students', function (Blueprint $table) {
            if (Schema::connection('mysql_yr')->hasColumn('placement_students', 'phone') == false) {
                $table->string('phone',20)->after('cat_id');
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
