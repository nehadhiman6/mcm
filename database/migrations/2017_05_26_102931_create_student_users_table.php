<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentUsersTable extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  	public function up() {
		Schema::connection('mysql_yr')->create('student_users', function (Blueprint $table) {
			$table->engine = 'InnoDB';
			$table->increments('id');
			$table->string('name');
			$table->string('email');
			$table->string('mobile', 15);
			$table->string('password');
			$table->boolean('confirmed')->default(0);
			$table->string('confirmation_code')->nullable();
			$table->rememberToken();
			$table->timestamps();
		});
  	}

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
    Schema::connection('mysql_yr')->dropIfExists('student_users');
  }

}
