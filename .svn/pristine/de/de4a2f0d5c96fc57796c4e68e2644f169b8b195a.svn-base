<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RevAlumniExperienceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasColumn('alumni_experience', 'category') == false) {
            Schema::table('alumni_experience', function (Blueprint $table) {
                $table->string('category')->after('alumni_stu_id')->nullable();
            });
        }

        if (Schema::hasColumn('alumni_experience', 'emp_type') == false) {
            Schema::table('alumni_experience', function (Blueprint $table) {
                $table->string('emp_type')->after('category')->nullable();  
            });
        }
        if (Schema::hasColumn('alumni_experience', 'designation') == false) {
            Schema::table('alumni_experience', function (Blueprint $table) {
                $table->string('designation')->after('org_address')->nullable();  
            });
        }
        if (Schema::hasColumn('alumni_experience', 'area_of_work') == false) {
            Schema::table('alumni_experience', function (Blueprint $table) {
                $table->string('area_of_work')->after('org_name')->nullable();  
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
