<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RevIntoSubjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasColumn('subjects', 'subject') == true) {
            Schema::table('subjects', function (Blueprint $table) {
                $table->string('subject',100)->change();  
            });
        }

        if (Schema::connection('mysql_yr')->hasColumn('subjects_old', 'subject') == true) {
            Schema::connection('mysql_yr')->table('subjects_old', function (Blueprint $table) {
                $table->string('subject',100)->change();  
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
