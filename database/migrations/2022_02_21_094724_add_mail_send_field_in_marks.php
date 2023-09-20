<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMailSendFieldInMarks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_yr')->table('marks', function (Blueprint $table) {
            if (Schema::connection('mysql_yr')->hasColumn('marks', 'mail_send') == false) {
                $table->char('mail_send',1)->default('N')->after('status');
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
