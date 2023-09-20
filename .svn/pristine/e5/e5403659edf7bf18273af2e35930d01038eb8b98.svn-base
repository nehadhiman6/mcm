<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldInAdmissionFormsAndAcademicDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_yr')->table('admission_forms', function (Blueprint $table) {
            if (Schema::connection('mysql_yr')->hasColumn('admission_forms', 'vaccinated') == false) {
                $table->string('vaccinated', 15)->nullable()->after('terms_conditions');
            }
        });

        Schema::connection('mysql_yr')->table('academic_detail', function (Blueprint $table) {
            if (Schema::connection('mysql_yr')->hasColumn('academic_detail', 'cgpa') == false) {
                $table->char('cgpa', 1)->default('N')->after('division');
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
