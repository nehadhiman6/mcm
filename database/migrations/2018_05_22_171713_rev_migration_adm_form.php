<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RevMigrationAdmForm extends Migration
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
            if (Schema::connection('mysql_yr')->hasColumn('admission_forms', 'punjabi_in_tenth') == false) {
                $table->char('punjabi_in_tenth', 1)->default('N')->after('remarks_diff_abled');
            }
        });

        Schema::connection('mysql_yr')->table('admission_subs', function (Blueprint $table) {
            if (Schema::connection('mysql_yr')->hasColumn('admission_subs', 'ele_group_id') == false) {
                $table->integer('ele_group_id')->default(0)->after('sub_group_id');
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
