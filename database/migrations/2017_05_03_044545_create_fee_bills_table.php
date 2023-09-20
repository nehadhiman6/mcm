<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeeBillsTable extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    Schema::connection('mysql_yr')->create('fee_bills', function (Blueprint $table) {
      $table->engine = 'InnoDB';
      $table->increments('id');
      $table->integer('course_id');
      $table->integer('std_type_id');
      $table->date('bill_date');
      $table->integer('install_id');
      $table->integer('concession_id')->nullable();
      $table->string('adm_no',20);
      $table->string('fee_type',20);
      $table->decimal('fee_amt',10,2);
      $table->decimal('fine',10,2)->nullable();
      $table->string('fine_remarks',500)->nullable();
      $table->date('due_date');
      $table->string('remarks',500)->nullable();
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
    Schema::connection('mysql_yr')->dropIfExists('fee_bills');
  }

}
