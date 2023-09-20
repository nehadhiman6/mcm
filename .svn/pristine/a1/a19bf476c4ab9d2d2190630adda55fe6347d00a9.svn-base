<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RevFieldAdmForm extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::connection('mysql_yr')->table('admission_forms', function (Blueprint $table) {
            if (Schema::connection('mysql_yr')->hasColumn('admission_forms', 'minority') == false) {
                $table->char('minority',1)->default('N')->after('resvcat_id');
            }
        });

        Schema::connection('mysql_yr')->table('admission_forms', function (Blueprint $table) {
            if (Schema::connection('mysql_yr')->hasColumn('admission_forms', 'conv_mode') == true) {
                $table->renameColumn('conv_mode', 'conveyance')->char()->default('N')->change();
            }
        });
        Schema::connection('mysql_yr')->table('admission_forms', function (Blueprint $table) {
            if (Schema::connection('mysql_yr')->hasColumn('admission_forms', 'differently_abled') == false) {
                $table->char('differently_abled',1)->default('N')->after('blind');
            }
        });
        Schema::connection('mysql_yr')->table('admission_forms', function (Blueprint $table) {
            if (Schema::connection('mysql_yr')->hasColumn('admission_forms', 'remarks_diff_abled') == false) {
                $table->string('remarks_diff_abled',35)->default('')->after('differently_abled');
            }
        });
        Schema::connection('mysql_yr')->table('admission_forms', function (Blueprint $table) {
            if (Schema::connection('mysql_yr')->hasColumn('admission_forms', 'annual_income') == true) {
                $table->string('annual_income',30)->nullable()->change();
            }
        });
        Schema::connection('mysql_yr')->table('admission_forms', function (Blueprint $table) {
            if (Schema::connection('mysql_yr')->hasColumn('admission_forms', 'other_religion') == false) {
                $table->string('other_religion',30)->after('religion')->nullable();
            }
        });
        Schema::connection('mysql_yr')->table('admission_forms', function (Blueprint $table) {
            if (Schema::connection('mysql_yr')->hasColumn('admission_forms', 'blind') == true) {
                $table->dropColumn('blind');
            }
        });
        Schema::connection('mysql_yr')->table('admission_forms', function (Blueprint $table) {
            if (Schema::connection('mysql_yr')->hasColumn('admission_forms', 'adhar_card') == false) {
                $table->char('adhar_card',1)->default('Y')->after('aadhar_no');
            }
        });
        Schema::connection('mysql_yr')->table('admission_forms', function (Blueprint $table) {
            if (Schema::connection('mysql_yr')->hasColumn('admission_forms', 'epic_card') == false) {
                $table->char('epic_card',1)->default('Y')->after('epic_no');
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
