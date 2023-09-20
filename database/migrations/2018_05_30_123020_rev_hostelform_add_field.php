<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RevHostelformAddField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::connection('mysql_yr')->table('admission_form_hostel', function (Blueprint $table) {
            if (Schema::connection('mysql_yr')->hasColumn('admission_form_hostel', 'schedule_backward_tribe') == false) {
                $table->char('schedule_backward_tribe', 1)->default('N')->after('prv_roll_no');
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
