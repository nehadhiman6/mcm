<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAbcIdIntoAdmissionForms extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_yr')->table('admission_forms', function (Blueprint $table) {
            if (Schema::connection('mysql_yr')->hasColumn('admission_forms', 'abc_id') == false) {
                $table->string('abc_id', 20)->nullable()->after('terms_conditions');
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
