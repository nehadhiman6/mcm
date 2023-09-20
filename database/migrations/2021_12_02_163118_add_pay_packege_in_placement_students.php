<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPayPackegeInPlacementStudents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_yr')->table('placement_students', function (Blueprint $table) {
            if (Schema::connection('mysql_yr')->hasColumn('placement_students', 'pay_package') == false) {
                $table->integer('pay_package')->default(0)->after('job_profile');
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
