<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsForRev18 extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    Schema::connection('mysql_yr')->table('admission_entries', function (Blueprint $table) {
      if (Schema::connection('mysql_yr')->hasColumn('admission_entries', 'std_type_id') == FALSE) {
        $table->integer('std_type_id')->after('admission_id')->default(0);
      }
      if (Schema::connection('mysql_yr')->hasColumn('admission_entries', 'valid_till') == FALSE) {
        $table->date('valid_till')->after('std_type_id')->nullable();
      }
    });
    Schema::connection('mysql_yr')->table('admission_forms', function (Blueprint $table) {
      if (Schema::connection('mysql_yr')->hasColumn('admission_forms', 'same_address') == FALSE) {
        $table->char('same_address', 1)->after('corr_address')->default('N');
      }
    });
    Schema::connection('mysql_yr')->table('courses', function (Blueprint $table) {
      if (Schema::connection('mysql_yr')->hasColumn('courses', 'max_optional') == FALSE) {
        $table->integer('max_optional')->after('min_optional')->default(0);
      }
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
//    Schema::connection('mysql_yr')->table('admission_forms', function (Blueprint $table) {
//      $table->dropColumn('same_address');
//    });
  }

}
