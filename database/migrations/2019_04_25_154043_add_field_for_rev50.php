<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldForRev50 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasColumn('returns', 'department_id') == true) {
            Schema::table('returns', function (Blueprint $table) {
                $table->renameColumn('department_id', 'loc_id');
            });
        }

        if (Schema::hasColumn('stock_ledger', 'trans_date') == false) {
            Schema::table('stock_ledger', function (Blueprint $table) {
                $table->date('trans_date')->after('id');
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
