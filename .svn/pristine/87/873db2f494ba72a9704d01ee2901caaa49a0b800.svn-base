<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RevAndAddFeildInActivitiesEvents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('activities', function (Blueprint $table) {
            if (Schema::hasColumn('activities', 'other_remarks') == false) {
                $table->string('other_remarks', 500)->nullable()->after('remarks');
            }
        });
        Schema::table('activities', function (Blueprint $table) {
            if (Schema::hasColumn('activities', 'convener') == false) {
                $table->string('convener', 100)->nullable()->after('topic');
            }
        });

        // Schema::table('activities', function ($table) {
        //     $table->dropColumn('sponsor_by_id');
        // });

        // Schema::table('activities', function (Blueprint $table) {
        //     if (Schema::hasColumn('activities', 'sponsor_by_id') == false) {
        //         $table->integer('sponsor_by_id')->nullable()->after('convener');
        //     }
        // });

        Schema::table('activity_collaboration', function (Blueprint $table) {
            if (Schema::hasColumn('activity_collaboration', 'agency_id') == true) {
                $table->integer('agency_id')->nullable()->change();
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
