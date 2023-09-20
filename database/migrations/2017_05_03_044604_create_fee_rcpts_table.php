<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeeRcptsTable extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    Schema::connection('mysql_yr')->create('fee_rcpts', function (Blueprint $table) {
      $table->engine = 'InnoDB';
      $table->increments('id');
      $table->integer('fee_bill_id');
      $table->integer('concession_id')->nullable();
      $table->string('fee_type',20);
      $table->string('adm_no', 20);
      $table->date('rcpt_date');
      $table->char('pay_type',2);
      $table->string('pay_mode',20)->nullable();
      $table->string('chqno',20)->nullable();
      $table->string('details',500)->nullable();
      $table->integer('created_by')->nullable();
      $table->integer('updated_by')->nullable();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
    Schema::connection('mysql_yr')->dropIfExists('fee_rcpts');
  }

}
