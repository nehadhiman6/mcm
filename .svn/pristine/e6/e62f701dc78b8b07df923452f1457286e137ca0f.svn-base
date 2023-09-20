<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPuRegno2FieldInStudents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_yr')->table('students', function (Blueprint $table) {
            if (Schema::connection('mysql_yr')->hasColumn('students', 'pu_regno2') == false) {
                $table->string('pu_regno2', 20)->after('pu_regno')->nullable();
            }
        });
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
