<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateTableRemovedStudents extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    if (Schema::connection('mysql_yr')->hasTable('removed_students') == false) {
      Schema::connection('mysql_yr')->create('removed_students', function (Blueprint $table) {
        $table->engine = 'InnoDB';
        $table->increments('id');
        $table->integer('std_id');
        $table->string('remarks', 500)->nullable();
        $table->integer('created_by')->nullable();
        $table->integer('updated_by')->nullable();
        $table->timestamps();
      });
    }
    Schema::connection('mysql_yr')->table('fee_rcpts', function(Blueprint $table) {
      $table->index('fee_bill_id', 'fee_rcpts_fee_bill_id_index');
    });
    $cnt = DB::connection(getYearlyDbConn())->table('fee_rcpt_dets')
        ->join('fee_rcpts', 'fee_rcpt_dets.fee_rcpt_id', '=', 'fee_rcpts.id')
        ->join('fee_bills', 'fee_rcpts.fee_bill_id', '=', 'fee_bills.id')
        ->join('fee_bill_dets', function($q) {
          $q->on('fee_rcpt_dets.index_no', '=', 'fee_bill_dets.index_no')
          ->on('fee_bills.id', '=', 'fee_bill_dets.fee_bill_id')
          ;
        })
        ->whereNull('fee_rcpt_dets.fee_bill_dets_id')
        ->update(['fee_rcpt_dets.fee_bill_dets_id' => DB::raw('fee_bill_dets.id')]);
    var_dump('Records affected: ' . $cnt);
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
    Schema::connection('mysql_yr')->dropIfExists('removed_students');
    try {
      Schema::connection('mysql_yr')->table('fee_rcpts', function (Blueprint $table) {
        $table->dropIndex('fee_rcpts_fee_bill_id_index');
      });
    } catch (Exception $ex) {
      echo 'Index not found!';
    }
  }

}
