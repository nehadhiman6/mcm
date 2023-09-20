<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Rev1IntoStuCrtPasses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       
        Schema::table('stu_crt_passes', function (Blueprint $table) {
            if (Schema::hasColumn('stu_crt_passes', 'contact_no') == false) {
                $table->string('contact_no', 50)->nullable()->after('type');
            }
        });

        
        Schema::table('stu_crt_passes', function (Blueprint $table) {
            if (Schema::hasColumn('stu_crt_passes', 'email') == false) {
                $table->string('email', 100)->nullable()->after('contact_no');
            }
        });

        Schema::table('stu_crt_passes', function (Blueprint $table) {
            if (Schema::hasColumn('stu_crt_passes', 'rejected') == false) {
                $table->char('rejected',1)->default('N')->after('email');
            }
        });

        Schema::table('stu_crt_passes', function (Blueprint $table) {
            if (Schema::hasColumn('stu_crt_passes', 'remarks') == false) {
                $table->string('remarks', 200)->nullable()->after('rejected');
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
