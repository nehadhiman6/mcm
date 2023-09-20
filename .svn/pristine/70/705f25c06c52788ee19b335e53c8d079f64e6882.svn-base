<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsForRev31 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_yr')->table('payments', function (Blueprint $table) {
            if (Schema::connection('mysql_yr')->hasColumn('payments', 'std_id') == false) {
                $table->integer('std_id')->default(0)->after('std_user_id');
            }
            if (Schema::connection('mysql_yr')->hasColumn('payments', 'std_id') == false) {
                $table->integer('last_fee_bill_id')->default(0)->after('std_id');
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
    }
}
