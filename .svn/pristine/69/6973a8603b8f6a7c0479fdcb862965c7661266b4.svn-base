<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAcRoomFieldInAdmissionFormHostel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_yr')->table('admission_form_hostel', function (Blueprint $table) {
            if (Schema::connection('mysql_yr')->hasColumn('admission_form_hostel', 'ac_room') == false) {
                $table->char('ac_room',1)->default('N')->after('room_mate');
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
