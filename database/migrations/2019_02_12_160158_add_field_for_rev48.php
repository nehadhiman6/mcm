<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldForRev48 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasColumn('alumni_students', 'is_graduacted') == false) {
            Schema::table('alumni_students', function (Blueprint $table) {
                $table->char('is_graduacted', 1)->default('N')->after('member_yes_no');
            });
        }
        if (Schema::hasColumn('alumni_students', 'is_profession') == false) {
            Schema::table('alumni_students', function (Blueprint $table) {
                $table->char('is_profession', 1)->default('N')->after('member_yes_no');
            });
        }
        if (Schema::hasColumn('alumni_students', 'is_research') == false) {
            Schema::table('alumni_students', function (Blueprint $table) {
                $table->char('is_research', 1)->default('N')->after('member_yes_no');
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
