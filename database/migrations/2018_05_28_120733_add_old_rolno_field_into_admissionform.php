<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOldRolnoFieldIntoAdmissionform extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::connection('mysql_yr')->table('admission_forms', function (Blueprint $table) {
            if (Schema::connection('mysql_yr')->hasColumn('admission_forms', 'lastyr_rollno') == false) {
                $table->string('lastyr_rollno', 20)->nullable()->after('std_id');
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
