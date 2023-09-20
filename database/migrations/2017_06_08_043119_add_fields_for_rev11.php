<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsForRev11 extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    Schema::connection('mysql_yr')->table('academic_detail', function (Blueprint $table) {
      if (Schema::connection('mysql_yr')->hasColumn('academic_detail', 'last_exam') == FALSE) {
        $table->char('last_exam', 1)->nullable()->after('exam');
      }
      if (Schema::connection('mysql_yr')->hasColumn('academic_detail', 'other_exam') == FALSE) {
        $table->string('other_exam', 50)->nullable()->after('last_exam');
      }
      if (Schema::connection('mysql_yr')->hasColumn('academic_detail', 'other_board') == FALSE) {
        $table->string('other_board', 100)->nullable()->after('board_id');
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
