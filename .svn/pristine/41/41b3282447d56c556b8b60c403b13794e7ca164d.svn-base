<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsForRev3 extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    Schema::connection('mysql_yr')->table('fee_bills', function (Blueprint $table) {
      if (Schema::connection('mysql_yr')->hasColumn('fee_bills', 'std_id') == FALSE) {
        $table->integer('std_id')->after('std_type_id')->nullable();
      }
      if (Schema::connection('mysql_yr')->hasColumn('fee_bills', 'concession') == FALSE) {
        $table->decimal('concession', 10, 2)->after('fee_amt')->nullable();
      }
      if (Schema::connection('mysql_yr')->hasColumn('fee_bills', 'bill_amt') == FALSE) {
        $table->decimal('bill_amt', 10, 2)->after('concession');
      }
      if (Schema::connection('mysql_yr')->hasColumn('fee_bills', 'amt_rec') == FALSE) {
        $table->decimal('amt_rec', 10, 2)->after('bill_amt')->nullable();
      }
      if (Schema::connection('mysql_yr')->hasColumn('fee_rcpts', 'cancelled') == FALSE) {
        $table->char('cancelled', 1)->after('remarks')->default('N');
      }
    });
    Schema::connection('mysql_yr')->table('fee_rcpts', function (Blueprint $table) {
      if (Schema::connection('mysql_yr')->hasColumn('fee_rcpts', 'std_id') == FALSE) {
        $table->integer('std_id')->after('fee_bill_id')->nullable();
      }
      if (Schema::connection('mysql_yr')->hasColumn('fee_rcpts', 'total') == FALSE) {
        $table->decimal('total', 10, 2)->after('adm_no');
      }
      if (Schema::connection('mysql_yr')->hasColumn('fee_rcpts', 'cancelled') == FALSE) {
        $table->char('cancelled', 1)->after('details')->default('N');
      }
    });
    Schema::connection('mysql_yr')->table('admission_forms', function (Blueprint $table) {
      if (Schema::connection('mysql_yr')->hasColumn('admission_forms', 'std_id') == FALSE) {
        $table->integer('std_id')->after('id')->nullable();
      }
      if (Schema::connection('mysql_yr')->hasColumn('admission_forms', 'status') == FALSE) {
        $table->char('status', 1)->after('std_id')->default('N');
      }
    });
    Schema::connection('mysql_yr')->table('students', function (Blueprint $table) {
      if (Schema::connection('mysql_yr')->hasColumn('students', 'cancelled') == FALSE) {
        $table->char('cancelled', 1)->after('adm_no')->nullable();
      }
      if (Schema::connection('mysql_yr')->hasColumn('students', 'removed') == FALSE) {
        $table->char('removed', 1)->after('cancelled')->nullable();
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
