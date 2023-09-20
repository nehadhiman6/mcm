<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RevInBecholorDegreeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::connection('mysql_yr')->table('bechelor_degree_details', function (Blueprint $table) {
            if (Schema::connection('mysql_yr')->hasColumn('bechelor_degree_details', 'pg_sem2_result') == false) {
                $table->string('pg_sem2_result',100)->after('pg_sem1_percentage')->nullable();
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
