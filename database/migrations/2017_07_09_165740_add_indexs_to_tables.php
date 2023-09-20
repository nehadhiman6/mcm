<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIndexsToTables extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    Schema::connection('mysql_yr')->table('payments', function(Blueprint $table) {
      $table->unique('trcd');
    });
    Schema::connection('mysql_yr')->table('student_users', function(Blueprint $table) {
      $table->unique('email');
    });
//    Schema::connection('mysql_yr')->table('admission_entries', function(Blueprint $table) {
//      $table->unique('admission_id');
//    });
//    Schema::table('admission_forms', function(Blueprint $table) {
//      $table->unique('adm_entry_id');
//    });
//    Schema::connection('mysql_yr')->table('students', function(Blueprint $table) {
//      $table->unique('admission_id');
//      $table->unique('adm_entry_id');
//      $table->unique('std_user_id');
//    });
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
