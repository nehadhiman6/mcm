<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsForRev10 extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    Schema::connection('mysql_yr')->table('admission_forms', function (Blueprint $table) {
      if (Schema::connection('mysql_yr')->hasColumn('admission_forms', 'manual_formno') == FALSE) {
        $table->string('manual_formno', 50)->nullable()->after('id');
      }
      if (Schema::connection('mysql_yr')->hasColumn('admission_forms', 'final_submission') == FALSE) {
        $table->char('final_submission', 1)->default('N')->after('manual_formno');
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
