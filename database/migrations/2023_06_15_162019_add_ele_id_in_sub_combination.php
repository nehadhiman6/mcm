<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEleIdInSubCombination extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_yr')->table('sub_combination', function (Blueprint $table) {
            if (Schema::connection('mysql_yr')->hasColumn('sub_combination', 'ele_id') == false) {
                $table->integer('ele_id')->nullable()->after('code');
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
