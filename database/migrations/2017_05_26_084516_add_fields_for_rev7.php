<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsForRev7 extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    Schema::connection('mysql_yr')->table('admission_forms', function (Blueprint $table) {
      if (Schema::connection('mysql_yr')->hasColumn('admission_forms', 'migrated') == FALSE) {
        $table->char('migrated', 1)->after('migrate_detail')->default('N');
      }
      if (Schema::connection('mysql_yr')->hasColumn('admission_forms', 'disqualified') == FALSE) {
        $table->char('disqualified', 1)->after('disqualify_detail')->default('N');
      }
      if (Schema::connection('mysql_yr')->hasColumn('admission_forms', 'foreign_national') == FALSE) {
        $table->char('foreign_national', 1)->after('disqualified')->default('N');
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
