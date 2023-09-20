<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeeStructuresTable extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    Schema::connection('mysql_yr')->create('fee_structures', function (Blueprint $table) {
      $table->engine = 'InnoDB';
      $table->increments('id');
      $table->integer('course_id');
      $table->integer('std_type_id');
      $table->integer('installment_id');
      $table->integer('subhead_id');
      $table->decimal('amount',10,2);
      $table->char('optional',1)->default('N');
      $table->char('opt_default',1)->default('N');
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
    Schema::connection('mysql_yr')->dropIfExists('fee_structures');
  }

}
