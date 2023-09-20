<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RevIntoStudents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::connection('mysql_yr')->hasColumn('students','hostel_room_id') == false) {
            Schema::connection('mysql_yr')->table('students', function (Blueprint $table) {
                $table->integer('hostel_room_id')->default(0)->after('adm_entry_id');
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
