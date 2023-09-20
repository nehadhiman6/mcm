<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsForRev25 extends Migration
{

  /**
   * Run the migrations.
   *
   * @return void
   */
    public function up()
    {
        Schema::connection('mysql_yr')->table('fee_bill_dets', function (Blueprint $table) {
            $table->index('fee_bill_id', 'fee_bill_dets_fee_bill_id_index');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        try {
            Schema::connection('mysql_yr')->table('fee_bill_dets', function (Blueprint $table) {
                $table->dropIndex('fee_bill_dets_fee_bill_id_index');
            });
        } catch (\Exception $ex) {
            echo 'Index not found!';
        }
    }
}
