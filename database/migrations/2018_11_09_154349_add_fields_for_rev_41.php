<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsForRev41 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::connection('mysql_yr')->hasColumn('payments', 'alumni_user_id') == false) {
            Schema::connection('mysql_yr')->table('payments', function (Blueprint $table) {
                $table->integer('alumni_user_id')->default(0)->after('std_user_id');
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
