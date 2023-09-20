<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsForRev9 extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    Schema::connection('mysql_yr')->table('admission_forms', function (Blueprint $table) {
      if (Schema::connection('mysql_yr')->hasColumn('admission_forms', 'sports') == FALSE) {
        $table->char('sports', 1)->default('N')->after('spl_achieve');
      }
      if (Schema::connection('mysql_yr')->hasColumn('admission_forms', 'cultural') == FALSE) {
        $table->char('cultural', 1)->default('N')->after('sports');
      }
      if (Schema::connection('mysql_yr')->hasColumn('admission_forms', 'academic') == FALSE) {
        $table->char('academic', 1)->default('N')->after('cultural');
      }
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
    Schema::connection('mysql_yr')->table('admission_forms', function (Blueprint $table) {
      if (Schema::connection('mysql_yr')->hasColumn('admission_forms', 'sports') == true) {
        $table->dropColumn('sports');
      }
      if (Schema::connection('mysql_yr')->hasColumn('admission_forms', 'cultural') == true) {
        $table->dropColumn('cultural');
      }
      if (Schema::connection('mysql_yr')->hasColumn('admission_forms', 'academic') == true) {
        $table->dropColumn('academic');
      }
    });
  }

}
