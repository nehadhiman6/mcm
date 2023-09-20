<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableOutsiders extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
//    Schema::connection('mysql_yr')->dropIfExists('outsiders');
    Schema::connection('mysql_yr')->create('outsiders', function (Blueprint $table) {
      $table->engine = 'InnoDB';
      $table->increments('id');
      $table->integer('institute');
      $table->integer('std_type_id');
      $table->string('adm_no', 20);
      $table->string('roll_no', 20);
      $table->date('adm_date');
      $table->string('name', 50);
      $table->string('father_name', 50)->default('');
      $table->string('course_name', 50);
      $table->string('mobile', 15)->default('');
      $table->string('email')->default('');
      $table->char('adm_cancelled', 1)->default('N');
      $table->integer('created_by')->nullable();
      $table->integer('updated_by')->nullable();
      $table->timestamps();
    });

    Schema::connection('mysql_yr')->table('fee_bills', function (Blueprint $table) {
      $table->integer('std_id')->default(0)->change();
      $table->string('fee_type', 50)->change();
      if (Schema::connection('mysql_yr')->hasColumn('fee_bills', 'outsider_id') == false)
        $table->integer('outsider_id')->default(0)->after('std_id');
    });

    Schema::connection('mysql_yr')->table('fee_rcpts', function (Blueprint $table) {
      $table->integer('std_id')->default(0)->change();
      $table->string('fee_type', 50)->change();
      if (Schema::connection('mysql_yr')->hasColumn('fee_rcpts', 'outsider_id') == false)
        $table->integer('outsider_id')->default(0)->after('std_id');
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
