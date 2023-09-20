<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsForRev8 extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    Schema::table('users', function (Blueprint $table) {
      if (Schema::hasColumn('users', 'type') == FALSE) {
        $table->string('type', 30)->default('office');
      }
    });
    Schema::connection('mysql_yr')->table('student_users', function (Blueprint $table) {
      if (Schema::connection('mysql_yr')->hasColumn('student_users', 'type') == FALSE) {
        $table->string('type', 30)->default('student');
      }
    });
    Schema::connection('mysql_yr')->table('admission_forms', function (Blueprint $table) {
      if (Schema::connection('mysql_yr')->hasColumn('admission_forms', 'std_user_id') == FALSE) {
        $table->integer('std_user_id')->after('terms_conditions')->nullable();
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
