<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RevisionIntoStudentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::connection('mysql_yr')->table('students', function (Blueprint $table) {
            if (Schema::connection('mysql_yr')->hasColumn('students', 'epic_no') == false) {
                $table->string('epic_no', 15)->after('aadhar_no')->nullable();
            }
            if (Schema::connection('mysql_yr')->hasColumn('students', 'minority') == false) {
                $table->char('minority',1)->default('N')->after('resvcat_id');
            }
            if (Schema::connection('mysql_yr')->hasColumn('students', 'other_religion') == false) {
                $table->string('other_religion',30)->after('religion')->nullable();
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
