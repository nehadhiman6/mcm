<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFileRegCodeToAlumniStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasColumn('alumni_students', 'reg_code') == false) {
            Schema::table('alumni_students', function (Blueprint $table) {
                $table->string('reg_code', 30)->nullable()->after('session');
            });
        }
        if (Schema::hasColumn('alumni_users', 'reg_code') == false) {
            Schema::table('alumni_users', function (Blueprint $table) {
                $table->string('reg_code', 30)->nullable()->after('remember_token');
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
