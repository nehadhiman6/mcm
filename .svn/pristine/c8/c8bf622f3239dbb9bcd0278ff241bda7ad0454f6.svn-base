<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsForRev36 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasColumn('staff', 'first_name') == true) {
            Schema::table('staff', function (Blueprint $table) {
                $table->renameColumn('first_name', 'name');
            });
        }

        if (Schema::hasColumn('staff', 'last_name') == true) {
            Schema::table('staff', function (Blueprint $table) {
                $table->dropColumn('last_name');
            });
        }

        if (Schema::hasColumn('staff', 'subject_id') == false) {
            Schema::table('staff', function (Blueprint $table) {
                $table->integer('subject_id')->default(0)->after('dept_id');
            });
        }

        if (Schema::connection('mysql_yr')->hasColumn('payments', 'resp_code') == false) {
            Schema::connection('mysql_yr')->table('payments', function (Blueprint $table) {
                $table->string('resp_code', 25)->default('')->after('mailsent');
            });
        }
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
