<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToAluminiStudents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasColumn('alumni_students', 'pu_pupin') == false) {
            Schema::table('alumni_students', function (Blueprint $table) {
                $table->string('pu_pupin', 20)->nullable();
            });
        }
        if (Schema::hasColumn('alumni_students', 'pu_regno') == false) {
            Schema::table('alumni_students', function (Blueprint $table) {
                $table->string('pu_regno', 20)->nullable();
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
        //
    }
}
