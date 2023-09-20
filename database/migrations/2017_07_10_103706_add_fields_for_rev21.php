<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsForRev21 extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    Schema::connection('mysql_yr')->table('payments', function(Blueprint $table) {
      if (Schema::connection('mysql_yr')->hasColumn('payments', 'billid'))
        $table->renameColumn('billid', 'fee_rcpt_id')->change();
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
