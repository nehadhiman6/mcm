<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAdmSourceToStudentsTable extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    Schema::connection('mysql_yr')->table('students', function (Blueprint $table) {
      $table->string('adm_source', 15)->default('offline')->after('std_type_id');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
    Schema::table('students', function (Blueprint $table) {
      $table->dropColumn('adm_source');
    });
  }

}
