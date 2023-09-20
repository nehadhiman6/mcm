<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsForRev2 extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    Schema::connection('mysql_yr')->table('course_subject', function (Blueprint $table) {
      if (Schema::connection('mysql_yr')->hasColumn('course_subject', 'practical') == FALSE) {
        $table->char('practical', 1)->default('N')->nullable()->after('sub_type');
      }
      if (Schema::connection('mysql_yr')->hasColumn('course_subject', 'honours') == FALSE) {
        $table->char('honours', 1)->default('N')->nullable()->after('practical');
      }
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
    Schema::connection('mysql_yr')->table('course_subject', function (Blueprint $table) {
      if (Schema::connection('mysql_yr')->hasColumn('course_subject', 'practical') == true) {
        $table->dropColumn('practical');
      }
      if (Schema::connection('mysql_yr')->hasColumn('course_subject', 'honours') == true) {
        $table->dropColumn('honours');
      }
    });
  }

}
