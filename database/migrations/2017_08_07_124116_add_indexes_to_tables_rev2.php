<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIndexesToTablesRev2 extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    Schema::connection('mysql_yr')->table('students', function(Blueprint $table) {
      $table->index('course_id', 'students_course_id_index');
    });
    Schema::connection('mysql_yr')->table('students', function(Blueprint $table) {
      $table->index('roll_no', 'students_roll_no_index');
    });
    Schema::connection('mysql_yr')->table('fee_bills', function(Blueprint $table) {
      $table->index('std_id', 'fee_bills_std_id_index');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
    try {
      Schema::connection('mysql_yr')->table('students', function (Blueprint $table) {
        $table->dropIndex('students_course_id_index');
      });
    } catch (Exception $ex) {
      echo 'Index not found!';
    }
    try {
      Schema::connection('mysql_yr')->table('students', function (Blueprint $table) {
        $table->dropIndex('students_roll_no_index');
      });
    } catch (Exception $ex) {
      echo 'Index not found!';
    }
    try {
      Schema::connection('mysql_yr')->table('fee_bills', function (Blueprint $table) {
        $table->dropIndex('fee_bills_std_id_index');
      });
    } catch (Exception $ex) {
      echo 'Index not found!';
    }
  }

}
