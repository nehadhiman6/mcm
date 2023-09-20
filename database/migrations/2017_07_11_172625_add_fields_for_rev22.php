<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsForRev22 extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    Schema::connection('mysql_yr')->table('fee_heads', function(Blueprint $table) {
      if (Schema::connection('mysql_yr')->hasColumn('fee_heads', 'concession') == false)
        $table->char('concession', 1)->default('Y')->after('fund');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
    Schema::connection('mysql_yr')->table('fee_heads', function(Blueprint $table) {
      if (Schema::connection('mysql_yr')->hasColumn('fee_heads', 'concession') == true)
        $table->dropColumn('concession');
    });
  }

}
