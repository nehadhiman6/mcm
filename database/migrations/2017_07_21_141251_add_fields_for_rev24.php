<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsForRev24 extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    Schema::connection('mysql_yr')->table('admission_forms', function (Blueprint $table) {
      if (Schema::connection('mysql_yr')->hasColumn('admission_forms', 'submission_time') == FALSE) {
        $table->datetime('submission_time')->nullable()->after('final_submission');
      }
    });
    Schema::connection('mysql_yr')->table('fee_rcpt_dets', function (Blueprint $table) {
      $table->index('fee_rcpt_id', 'fee_rcpt_dets_fee_rcpt_id_index');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
    try {
      Schema::connection('mysql_yr')->table('fee_rcpt_dets', function (Blueprint $table) {
        $table->dropIndex('fee_rcpt_dets_fee_rcpt_id_index');
      });
    } catch (Exception $ex) {
      echo 'Index not found!';
    }
  }

}
