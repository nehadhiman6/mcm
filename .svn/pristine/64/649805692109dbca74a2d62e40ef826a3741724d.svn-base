<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCentre1Centre2FieldInRegionalCentres extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_yr')->table('regional_centres', function (Blueprint $table) {
            if (Schema::connection('mysql_yr')->hasColumn('regional_centres', 'regional_centre') == true) {
                $table->string('regional_centre', 20)->nullable()->change();
            }
        });
        Schema::connection('mysql_yr')->table('regional_centres', function (Blueprint $table) {
            if (Schema::connection('mysql_yr')->hasColumn('regional_centres', 'centre1') == false) {
                $table->string('centre1', 200)->nullable()->after('regional_centre');
            }
        });

        Schema::connection('mysql_yr')->table('regional_centres', function (Blueprint $table) {
            if (Schema::connection('mysql_yr')->hasColumn('regional_centres', 'centre2') == false) {
                $table->string('centre2', 200)->nullable()->after('centre1');
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
