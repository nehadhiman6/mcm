<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFeeDepositeDateFieldInStudentRefundRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_yr')->table('student_refund_requests', function (Blueprint $table) {
            if (Schema::hasColumn('student_refund_requests', 'fee_deposite_date') == false) {
                $table->date('fee_deposite_date')->nullable()->after('request_date');
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
