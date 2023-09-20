<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RevFieldsAdmForm extends Migration
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
            if (Schema::connection('mysql_yr')->hasColumn('admission_forms', 'boarder') == true) {
                $table->string('boarder', 10)->nullable()->change();
            }
            if (Schema::connection('mysql_yr')->hasColumn('admission_forms', 'veh_no') == true) {
                $table->string('veh_no', 15)->nullable()->change();
            }
            if (Schema::connection('mysql_yr')->hasColumn('admission_forms', 'epic_no') == true) {
                $table->string('epic_no', 15)->nullable()->change();
            }
            if (Schema::connection('mysql_yr')->hasColumn('admission_forms', 'sport_name') == true) {
                $table->string('sport_name', 25)->nullable()->change();
            }
            if (Schema::connection('mysql_yr')->hasColumn('admission_forms', 'migrate_from') == true) {
                $table->string('migrate_from', 25)->nullable()->change();
            }
            if (Schema::connection('mysql_yr')->hasColumn('admission_forms', 'migrate_from') == true) {
                $table->string('migrate_deficient_sub', 30)->nullable()->change();
            }
            if (Schema::connection('mysql_yr')->hasColumn('admission_forms', 'migrate_from') == true) {
                $table->string('remarks_diff_abled', 50)->nullable()->change();
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
