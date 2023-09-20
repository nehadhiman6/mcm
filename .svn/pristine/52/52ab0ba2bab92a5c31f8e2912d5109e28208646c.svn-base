<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentRefundRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_yr')->create('student_refund_requests', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('std_id');
            $table->date('request_date');
            $table->char('fund_type',1); 
            $table->string('bank_name', 100); 
            $table->string('ifsc_code', 20);
            $table->string('bank_ac_no', 100);
            $table->string('account_holder_name', 100);
            $table->decimal('amount', 12, 2)->default(0);
            $table->string('reason_of_refund', 200)->nullable();
            $table->string('approval', 10)->default('pending'); //A/C/P
            $table->string('approval_remarks', 200)->nullable();
            $table->integer('approved_by')->default(0);
            $table->date('approval_date')->nullable();
            $table->integer('created_by');
            $table->integer('updated_by');
            $table->timestamps();
        });

        Schema::connection('mysql_yr')->create('student_refunds', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('std_id');
            $table->integer('std_ref_req_id');
            $table->date('release_date');
            $table->string('release_remarks', 200)->nullable();
            $table->decimal('release_amt', 12, 2)->default(0);
            $table->integer('released_by')->default(0);
            $table->integer('created_by');
            $table->integer('updated_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql_yr')->dropIfExists('student_refund_requests');
        Schema::connection('mysql_yr')->dropIfExists('student_refunds');
    }
}
