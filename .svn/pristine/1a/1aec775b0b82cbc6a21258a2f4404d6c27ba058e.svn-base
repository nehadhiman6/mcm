<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFacultyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('faculty', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('faculty')->default('');
            $table->integer('created_by');
            $table->integer('updated_by');
            $table->timestamps();
        });

        if (Schema::hasColumn('departments', 'faculty_id') == false) {
            Schema::table('departments', function (Blueprint $table) {
                $table->integer('faculty_id')->after('name')->nullable();
            });
        }

        if (Schema::hasColumn('subjects', 'dept_id') == false) {
            Schema::table('subjects', function (Blueprint $table) {
                $table->integer('dept_id')->after('uni_code')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('faculty');
    }
}
