<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeSpnoserByIntoSponserById extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('activities', function (Blueprint $table) {
            if (Schema::hasColumn('activities', 'sponsor_by') == true) {
                $table->dropColumn('sponsor_by');
            }
        });

        Schema::table('activities', function (Blueprint $table) {
            if (Schema::hasColumn('activities', 'sponsor_by_id') == false) {
                $table->integer('sponsor_by_id')->nullable()->after('convener');
            }
        });

        Schema::table('activity_collaboration', function (Blueprint $table) {
            if (Schema::hasColumn('activity_collaboration', 'colloboration_with_id') == false) {
                $table->integer('colloboration_with_id')->nullable()->after('act_id');
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
