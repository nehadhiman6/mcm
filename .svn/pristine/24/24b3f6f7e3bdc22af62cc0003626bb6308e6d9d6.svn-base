<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AddFieldsForRev20 extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    Schema::connection('mysql_yr')->table('admission_forms', function(Blueprint $table) {
      $table->dropColumn('sports');
      $table->dropColumn('cultural');
      $table->dropColumn('academic');
    });
    Schema::connection('mysql_yr')->table('admission_forms', function(Blueprint $table) {
      $table->char('sports', 1)->default('N')->after('spl_achieve');
      $table->char('academic', 1)->default('N')->after('sports');
      $table->char('cultural', 1)->default('N')->after('sports');
    });
    DB::connection('mysql_yr')->table('admission_forms')->update(['sports' => 'N', 'cultural' => 'N', 'academic' => 'N']);
    Schema::connection('mysql_yr')->table('fee_rcpts', function (Blueprint $table) {
      if (Schema::connection('mysql_yr')->hasColumn('fee_rcpts', 'total') == true) {
        $table->renameColumn('total', 'amount');
      }
    });
    Schema::connection('mysql_yr')->table('fee_rcpt_dets', function(Blueprint $table) {
     // $table->dropColumn('fee_bill_dets_id');
      $table->decimal('concession', 10, 2)->default(0.00)->change();
    });
    Schema::connection('mysql_yr')->table('students', function (Blueprint $table) {
      if (Schema::connection('mysql_yr')->hasColumn('students', 'adm_cancelled') == false) {
        $table->char('adm_cancelled',1)->default('N')->after('status');
      }
    });
    Schema::connection('mysql_yr')->table('student_users', function (Blueprint $table) {
      if (Schema::connection('mysql_yr')->hasColumn('student_users', 'initial_password') == false) {
        $table->string('initial_password',30)->nullable()->after('password');
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
