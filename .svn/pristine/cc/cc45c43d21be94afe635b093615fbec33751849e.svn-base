<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsForRev5 extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    Schema::connection('mysql_yr')->table('fee_rcpt_dets', function (Blueprint $table) {
      if (Schema::connection('mysql_yr')->hasColumn('fee_rcpt_dets', 'fee_bill_dets_id') == FALSE) {
        $table->integer('fee_bill_dets_id')->after('fee_rcpt_id')->nullable();
      }
      if (Schema::connection('mysql_yr')->hasColumn('fee_rcpt_dets', 'index_no') == FALSE) {
        $table->integer('index_no')->after('concession')->nullable();
      }
    });
    Schema::connection('mysql_yr')->table('fee_bill_dets', function (Blueprint $table) {
      if (Schema::connection('mysql_yr')->hasColumn('fee_bill_dets', 'index_no') == FALSE) {
        $table->integer('index_no')->after('concession')->nullable();
      }
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
    //
  }

}
