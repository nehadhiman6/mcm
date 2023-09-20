<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsForRev26 extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    Schema::connection('mysql_yr')->table('fee_bills', function (Blueprint $table) {
      if (Schema::connection('mysql_yr')->hasColumn('fee_bills', 'fund_type') == false) {
        $table->char('fund_type', 1)->default('C')->after('install_id');
      }
    });
    Schema::connection('mysql_yr')->table('fee_rcpts', function (Blueprint $table) {
      if (Schema::connection('mysql_yr')->hasColumn('fee_rcpts', 'fund_type') == false) {
        $table->char('fund_type', 1)->default('C')->after('fee_type');
      }
      if (Schema::connection('mysql_yr')->hasColumn('fee_rcpts', 'rcpt_no') == false) {
        $table->integer('rcpt_no')->default(0)->after('adm_no');
      }
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
//    Schema::connection('mysql_yr')->table('fee_bills', function (Blueprint $table) {
//      if (Schema::connection('mysql_yr')->hasColumn('fee_bills', 'fund_type') == true) {
//        $table->dropColumn('fund_type');
//      }
//    });
//    Schema::connection('mysql_yr')->table('fee_rcpts', function (Blueprint $table) {
//      if (Schema::connection('mysql_yr')->hasColumn('fee_rcpts', 'fund_type') == true) {
//        $table->dropColumn('fund_type');
//      }
//    });
  }

}
