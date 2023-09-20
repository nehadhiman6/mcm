<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsForRev14 extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    Schema::connection('mysql_yr')->table('admission_forms', function (Blueprint $table) {
      $table->string('aadhar_no',15)->nullable()->change();
      if (Schema::connection('mysql_yr')->hasColumn('admission_forms', 'adm_entry_id') == FALSE) {
        $table->integer('adm_entry_id')->nullable()->after('final_submission');
      }
      if (Schema::connection('mysql_yr')->hasColumn('admission_forms', 'source') == FALSE) {
        $table->string('source', 50)->nullable()->after('adm_entry_id');
      }
      if (Schema::connection('mysql_yr')->hasColumn('admission_forms', 'city') == FALSE) {
        $table->string('city', 50)->nullable()->after('per_Address');
      }
      if (Schema::connection('mysql_yr')->hasColumn('admission_forms', 'state_id') == FALSE) {
        $table->integer('state_id')->nullable()->after('city');
      }
    });
    Schema::connection('mysql_yr')->table('academic_detail', function (Blueprint $table) {
      if (Schema::connection('mysql_yr')->hasColumn('academic_detail', 'total_marks') == FALSE) {
        $table->decimal('total_marks',10,2)->nullable()->after('marks');
      }
      if (Schema::connection('mysql_yr')->hasColumn('academic_detail', 'marks_obtained') == FALSE) {
        $table->decimal('marks_obtained',10,2)->nullable()->after('total_marks');
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
