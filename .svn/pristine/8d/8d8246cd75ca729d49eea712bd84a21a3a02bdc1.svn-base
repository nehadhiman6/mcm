<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RevAddFieldsIntoAdmissionform extends Migration
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
            if (Schema::connection('mysql_yr')->hasColumn('admission_forms', 'belongs_bpl') == false) {
                $table->char('belongs_bpl', 1)->default('N')->after('annual_income');
            }
            if (Schema::connection('mysql_yr')->hasColumn('admission_forms','equivalence_certificate') == false) {
                $table->char('equivalence_certificate', 1)->default('N')->after('res_validity');
            }
            if (Schema::connection('mysql_yr')->hasColumn('admission_forms', 'icssr_sponser') == false) {
                $table->char('icssr_sponser', 1)->default('N')->after('equivalence_certificate');
            }
            if (Schema::connection('mysql_yr')->hasColumn('admission_forms', 'father_address') == false) {
                $table->string('father_address', 200)->nullable()->after('father_mobile');
            }
            if (Schema::connection('mysql_yr')->hasColumn('admission_forms', 'mother_address') == false) {
                $table->string('mother_address', 200)->nullable()->after('mother_email');
            }
            if (Schema::connection('mysql_yr')->hasColumn('admission_forms', 'guardian_address') == false) {
                $table->string('guardian_address', 200)->nullable()->after('guardian_email');
            }
            if (Schema::connection('mysql_yr')->hasColumn('admission_forms', 'guardian_relationship') == false) {
                $table->string('guardian_relationship', 100)->nullable()->after('guardian_name');
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
