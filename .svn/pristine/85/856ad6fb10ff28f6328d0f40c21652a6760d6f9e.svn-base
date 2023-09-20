<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsForRev17 extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    Schema::table('boards', function (Blueprint $table) {
      $table->string('name', 100)->change();
    });
    Schema::connection('mysql_yr')->table('admission_forms', function (Blueprint $table) {
      if (Schema::connection('mysql_yr')->hasColumn('admission_forms', 'corr_address') == FALSE) {
        $table->string('corr_address', 200)->after('per_address')->nullable();
      }
      if (Schema::connection('mysql_yr')->hasColumn('admission_forms', 'corr_city') == FALSE) {
        $table->string('corr_city', 50)->after('corr_address')->nullable();
      }
      if (Schema::connection('mysql_yr')->hasColumn('admission_forms', 'corr_state_id') == FALSE) {
        $table->integer('corr_state_id')->after('corr_city')->nullable();
      }
      if (Schema::connection('mysql_yr')->hasColumn('admission_forms', 'corr_pincode') == FALSE) {
        $table->string('corr_pincode')->after('corr_state_id')->nullable();
      }
      $table->integer('std_user_id')->default(0)->change();
    });
    Schema::connection('mysql_yr')->table('academic_detail', function (Blueprint $table) {
      $table->decimal('marks_per', 5, 2)->change();
    });
    Schema::connection('mysql_yr')->table('payments', function (Blueprint $table) {
      if (Schema::connection('mysql_yr')->hasColumn('payments', 'trn_type') == FALSE) {
        $table->string('trn_type', 50)->default('')->after('trcd');
      }
      $table->integer('std_user_id')->default(0)->change();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
    
  }

}
