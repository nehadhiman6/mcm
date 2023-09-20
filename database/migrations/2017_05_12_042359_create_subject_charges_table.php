<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubjectChargesTable extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    Schema::connection('mysql_yr')->create('subject_charges', function (Blueprint $table) {
      $table->engine = 'InnoDB';
      $table->increments('id');
      $table->integer('installment_id');
      $table->integer('course_id');
      $table->integer('subject_id');
      $table->decimal('pract_fee',10,2)->nullable();
      $table->decimal('pract_exam_fee',10,2)->nullable();
      $table->decimal('hon_fee',10,2)->nullable();
      $table->decimal('hon_exam_fee',10,2)->nullable();
      $table->integer('pract_id')->nullable();
      $table->integer('hon_id')->nullable();
      $table->integer('exam_id')->nullable();
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
    Schema::connection('mysql_yr')->dropIfExists('subject_charges');
  }

}
