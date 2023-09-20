<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RevIntoStaffqualification extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('staff_qualification', function (Blueprint $table) {
            if (Schema::hasColumn('staff_qualification', 'cgpa') == true) {
                $table->dropColumn('cgpa');
            }
        });
        Schema::table('staff_qualification', function (Blueprint $table) {
            if (Schema::hasColumn('staff_qualification', 'pr_cgpa') == false) {
                $table->char('pr_cgpa',1)->default('P')->after('percentage');
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
