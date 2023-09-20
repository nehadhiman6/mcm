<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsTable extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    Schema::connection('mysql_yr')->create('payments', function (Blueprint $table) {
      $table->engine = 'InnoDB';
      $table->increments('id');
      $table->string('trcd', 50)->unique();
      $table->string('trn_type', 50);
      $table->string('status', 50)->default('');
      $table->string('unmappedstatus', 50)->default('');
      $table->string('trid', 50);
      $table->string('ourstatus', 50)->default('');
      $table->integer('billid')->unsigned();
      $table->decimal('amt', 10, 0)->default(0);
      $table->decimal('fine', 6, 2)->default(0.00);
      $table->string('trdate', 50);
      $table->string('trdate1', 50);
      $table->dateTime('trdate2')->nullable();
      $table->string('msg', 100)->nullable();
      $table->string('through', 50)->nullable();
      $table->string('product', 50)->nullable();
      $table->string('cc_no', 25)->nullable();
      $table->string('bank_txn', 25)->nullable();
      $table->string('clientcode', 25)->nullable();
      $table->string('bank', 50)->nullable();
      $table->dateTime('trntime')->nullable();
      $table->decimal('comm', 10, 2)->default('0.00');
      $table->string('email', 50);
      $table->string('mobile', 10);
      $table->string('refunded', 1)->defaukt('N');
      $table->tinyInteger('mailsent')->default('0');
      $table->integer('std_user_id')->unsigned()->index('std_user_id');
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
    Schema::connection('mysql_yr')->dropIfExists('payments');
  }

}
