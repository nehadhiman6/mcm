<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPaymentIdInFeeRcptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_yr')->table('fee_rcpts', function (Blueprint $table) {
            if (Schema::connection('mysql_yr')->hasColumn('fee_rcpts', 'payment_id') == false) {
                $table->integer('payment_id')->after('fee_bill_id')->default(0);
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
