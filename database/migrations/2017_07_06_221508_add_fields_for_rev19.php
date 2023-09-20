<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsForRev19 extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    Schema::connection('mysql_yr')->table('payments', function (Blueprint $table) {
      if (Schema::connection('mysql_yr')->hasColumn('payments', 'message') == FALSE) {
        $table->string('message')->after('mailsent')->default('');
      }
      if (Schema::connection('mysql_yr')->hasColumn('payments', 'sub_group_id') == true) {
        $table->dropColumn('sub_group_id');
      }
      if (Schema::connection('mysql_yr')->hasColumn('payments', 'subject_id') == true) {
        $table->dropColumn('subject_id');
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
