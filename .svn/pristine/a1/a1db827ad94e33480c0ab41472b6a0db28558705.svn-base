<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsForRev1 extends Migration
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
            if (Schema::connection('mysql_yr')->hasColumn('admission_forms', 'sports') == FALSE) {
                $table->integer('sports')->nullable()->after('spl_achieve');
            }
            if (Schema::connection('mysql_yr')->hasColumn('admission_forms', 'cultural') == FALSE) {
                $table->integer('cultural')->nullable()->after('sports');
            }
            if (Schema::connection('mysql_yr')->hasColumn('admission_forms', 'academic') == FALSE) {
                $table->integer('academic')->nullable()->after('cultural');
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
