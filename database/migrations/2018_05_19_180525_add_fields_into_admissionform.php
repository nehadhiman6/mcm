<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsIntoAdmissionform extends Migration
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
            if (Schema::connection('mysql_yr')->hasColumn('admission_forms','migration_certificate') == false) {
                $table->char('migration_certificate', 1)->default('W')->after('migration');
            }
            if (Schema::connection('mysql_yr')->hasColumn('admission_forms','migrate_from') == false) {
                $table->string('migrate_from', 30)->default('')->after('migration_certificate');
            }
            if (Schema::connection('mysql_yr')->hasColumn('admission_forms','migrate_deficient_sub') == false) {
                $table->string('migrate_deficient_sub', 30)->default('')->after('migrate_from');
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
