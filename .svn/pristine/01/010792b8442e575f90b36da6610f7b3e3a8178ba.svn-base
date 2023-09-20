<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToStudentUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::connection('mysql_yr')->hasColumn('student_users', 'otp') == false) {
            Schema::connection('mysql_yr')->table('student_users', function (Blueprint $table) {
                $table->integer('otp')->after('mobile');
            });
        }

        if (Schema::connection('mysql_yr')->hasColumn('student_users', 'mobile_verified') == false) {
            Schema::connection('mysql_yr')->table('student_users', function (Blueprint $table) {
                $table->char('mobile_verified', 1)->default('N')->after('mobile');
            });
        }

        // if (Schema::connection('mysql_yr')->hasColumn('student_users', 'email2') == false) {
        //     Schema::connection('mysql_yr')->table('student_users', function (Blueprint $table) {
        //         $table->string('email_code')->after('email2')->nullable();
        //     });
        // }
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
