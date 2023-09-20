<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCompTypeAndCompNatureFieldInPlacementCompanies extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('placement_companies', function (Blueprint $table) {
            if (Schema::hasColumn('placement_companies', 'comp_type') == false) {
                $table->string('comp_type', 20)->nullable()->after('state_id');
            }
        });

        Schema::table('placement_companies', function (Blueprint $table) {
            if (Schema::hasColumn('placement_companies', 'comp_nature') == false) {
                $table->string('comp_nature', 20)->nullable()->after('comp_type');
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
