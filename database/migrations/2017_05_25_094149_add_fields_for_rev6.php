<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsForRev6 extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    Schema::connection('mysql_yr')->table('admission_forms', function (Blueprint $table) {
      if (Schema::connection('mysql_yr')->hasColumn('admission_forms', 'aadhar_no') == FALSE) {
        $table->string('aadhar_no', 15)->after('mobile');
      }
      if (Schema::connection('mysql_yr')->hasColumn('admission_forms', 'terms_conditions') == FALSE) {
        $table->char('terms_conditions', 1)->after('res_permit')->default('N');
      }
    });
    Schema::connection('mysql_yr')->table('courses', function (Blueprint $table) {
      if (Schema::connection('mysql_yr')->hasColumn('courses', 'no_of_seats') == FALSE) {
        $table->integer('no_of_seats')->after('sub_no');
      }
      if (Schema::connection('mysql_yr')->hasColumn('courses', 'adm_open') == FALSE) {
        $table->char('adm_open', 1)->after('no_of_seats')->default('N');
      }
      if (Schema::connection('mysql_yr')->hasColumn('courses', 'adm_close_date') == FALSE) {
        $table->date('adm_close_date')->after('adm_open')->nullable();
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
