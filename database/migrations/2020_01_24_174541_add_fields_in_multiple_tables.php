<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsInMultipleTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('purchases', function (Blueprint $table) {
            if (Schema::hasColumn('purchases', 'store_id') == false) {
                $table->integer('store_id')->default(0)->after('id');
            }
        });

        Schema::table('pur_return', function (Blueprint $table) {
            if (Schema::hasColumn('pur_return', 'store_id') == false) {
                $table->integer('store_id')->default(0)->after('id');
            }
        });
        
        Schema::table('returns', function (Blueprint $table) {
            if (Schema::hasColumn('returns', 'store_id') == false) {
                $table->integer('store_id')->default(0)->after('trans_dt');
            }
        });
        
        Schema::table('issues', function (Blueprint $table) {
            if (Schema::hasColumn('issues', 'store_id') == false) {
                $table->integer('store_id')->default(0)->after('issue_dt');
            }
        });
        
        Schema::table('stock_ledger', function (Blueprint $table) {
            if (Schema::hasColumn('stock_ledger', 'store_id') == false) {
                $table->integer('store_id')->default(0)->after('trans_type');
            }
        });
        
        Schema::table('damages', function (Blueprint $table) {
            if (Schema::hasColumn('damages', 'store_id') == false) {
                $table->integer('store_id')->default(0)->after('trans_dt');
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
        Schema::dropIfExists('purchases');
        Schema::dropIfExists('pur_return');
        Schema::dropIfExists('returns');
        Schema::dropIfExists('issues');
        Schema::dropIfExists('stock_ledger');
        Schema::dropIfExists('damages');
    }
}
