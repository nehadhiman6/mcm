<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldForRev45 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasColumn('vendors', 'deals_in_type_goods') == false) {
            Schema::table('vendors', function (Blueprint $table) {
                $table->string('deals_in_type_goods', 200)->after('code')->nullable();
            });
        }
        if (Schema::hasColumn('purchases', 'total_amount') == false) {
            Schema::table('purchases', function (Blueprint $table) {
                $table->integer('total_amount')->after('trans_id')->nullable();
            });
        }
        if (Schema::hasColumn('purchase_dets', 'rate') == false) {
            Schema::table('purchase_dets', function (Blueprint $table) {
                $table->integer('rate')->after('item_id')->nullable();
            });
        }
        if (Schema::hasColumn('purchase_dets', 'item_desc') == false) {
            Schema::table('purchase_dets', function (Blueprint $table) {
                $table->string('item_desc', 200)->after('rate')->nullable();
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
