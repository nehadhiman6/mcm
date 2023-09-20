<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsForRev28 extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    Schema::connection('mysql_yr')->table('students', function (Blueprint $table) {
      if (Schema::connection('mysql_yr')->hasColumn('students', 'card_no') == false) {
        $table->integer('card_no')->default(0)->after('card_print');
      }
      if (Schema::connection('mysql_yr')->hasColumn('students', 'removed') == false) {
        $table->char('removed',1)->default('N')->after('card_no');
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
