<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsIntoAlumani extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::connection('mysql_yr')->table('alumani', function (Blueprint $table) {
            if (Schema::connection('mysql_yr')->hasColumn('alumani', 'admission_id') == false) {
                $table->integer('admission_id')->after('id');
            }
        });
        
        Schema::connection('mysql_yr')->table('admission_forms', function (Blueprint $table) {
            if (Schema::connection('mysql_yr')->hasColumn('admission_forms', 'alumani_id') == true) {
                $table->dropColumn('alumani_id');
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
