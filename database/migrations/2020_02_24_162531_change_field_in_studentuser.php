<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeFieldInStudentuser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::connection('mysql_yr')->hasColumn('student_users', 'email_2') == true) {
            Schema::connection('mysql_yr')->table('student_users', function (Blueprint $table) {
                $table->renameColumn('email_2', 'email2');
            });
        }

        if (Schema::connection('mysql_yr')->hasColumn('student_users', 'email2') == false) {
            Schema::connection('mysql_yr')->table('student_users', function (Blueprint $table) {
                $table->string('email2')->after('email')->nullable();
            });
        }

        if (Schema::connection('mysql_yr')->hasColumn('student_users', 'otp') == true) {
            Schema::connection('mysql_yr')->table('student_users', function (Blueprint $table) {
                $table->renameColumn('otp', 'email2_code');
            });
        }

        if (Schema::connection('mysql_yr')->hasColumn('student_users', 'email2_code') == true) {
            Schema::connection('mysql_yr')->table('student_users', function (Blueprint $table) {
                $table->string('email2_code', 30)->change();
            });
        }

        if (Schema::connection('mysql_yr')->hasColumn('student_users', 'mobile_verified') == false) {
            Schema::connection('mysql_yr')->table('student_users', function (Blueprint $table) {
                $table->char('mobile_verified', 1)->default('N')->after('mobile');
            });
        }

        if (Schema::connection('mysql_yr')->hasColumn('student_users', 'email2_confirmed') == false) {
            Schema::connection('mysql_yr')->table('student_users', function (Blueprint $table) {
                $table->char('email2_confirmed', 1)->default('N')->after('email2');
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
