<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RevMigrationAdmFormAddDivision extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::connection('mysql_yr')->table('academic_detail', function (Blueprint $table) {
            if (Schema::connection('mysql_yr')->hasColumn('academic_detail', 'reappear_subjects') == false) {
                $table->string('reappear_subjects',100)->after('subjects')->nullable();
            }
            if (Schema::connection('mysql_yr')->hasColumn('academic_detail', 'division') == false) {
                $table->string('division',100)->after('reappear_subjects')->nullable();
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
