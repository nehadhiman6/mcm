<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldForRev47 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasColumn('items', 'remarks') == true) {
            Schema::table('items', function (Blueprint $table) {
                $table->string('remarks')->nullable()->change();
            });
        }
        if (Schema::hasColumn('vendors', 'city_id') == true) {
            Schema::table('vendors', function (Blueprint $table) {
                $table->integer('city_id')->nullable()->change();
            });
        }
        if (Schema::hasColumn('vendors', 'vendor_address') == true) {
            Schema::table('vendors', function (Blueprint $table) {
                $table->string('vendor_address')->nullable()->change();
            });
        }
        if (Schema::hasColumn('vendors', 'contact_no') == true) {
            Schema::table('vendors', function (Blueprint $table) {
                $table->string('contact_no')->nullable()->change();
            });
        }
        if (Schema::hasColumn('vendors', 'contact_person') == true) {
            Schema::table('vendors', function (Blueprint $table) {
                $table->string('contact_person')->nullable()->change();
            });
        }
        if (Schema::hasColumn('returns', 'remarks') == true) {
            Schema::table('returns', function (Blueprint $table) {
                $table->string('remarks')->nullable()->change();
            });
        }
        if (Schema::hasColumn('damages', 'remarks') == true) {
            Schema::table('damages', function (Blueprint $table) {
                $table->string('remarks')->nullable()->change();
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
