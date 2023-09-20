<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStaffIdFieldInIssueAndStockLedger extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('issues', function (Blueprint $table) {
            if (Schema::hasColumn('issues', 'staff_id') == false) {
                $table->integer('staff_id')->default(0)->after('person');
            }
        });

        Schema::table('stock_ledger', function (Blueprint $table) {
            if (Schema::hasColumn('stock_ledger', 'staff_id') == false) {
                $table->integer('staff_id')->default(0)->after('loc_id');
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
