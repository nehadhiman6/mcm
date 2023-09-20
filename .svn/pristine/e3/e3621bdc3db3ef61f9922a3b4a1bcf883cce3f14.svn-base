<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsForRev12 extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    Schema::connection('mysql_yr')->table('student_users', function (Blueprint $table) {
      if (Schema::connection('mysql_yr')->hasColumn('student_users', 'confirmed') == FALSE) {
        $table->boolean('confirmed')->default(0)->after('password');
      }
      if (Schema::connection('mysql_yr')->hasColumn('student_users', 'confirmation_code') == FALSE) {
        $table->string('confirmation_code')->nullable()->after('confirmed');
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
