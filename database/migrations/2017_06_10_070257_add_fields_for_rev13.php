<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsForRev13 extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    Schema::connection('mysql_yr')->table('course_subject', function (Blueprint $table) {
      if (Schema::connection('mysql_yr')->hasColumn('course_subject', 'uni_code') == FALSE) {
        $table->string('uni_code',50)->nullable()->after('sub_type');
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
