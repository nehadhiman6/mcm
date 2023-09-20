<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsForRev52 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasColumn('staff', 'library_code') == false) {
            Schema::table('staff', function (Blueprint $table) {
                $table->string('library_code', 100)->nullable()->after('mobile2');
            });
        }
        if (Schema::hasColumn('staff', 'blood_group') == false) {
            Schema::table('staff', function (Blueprint $table) {
                $table->string('blood_group', 100)->nullable()->after('cat_id');
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
