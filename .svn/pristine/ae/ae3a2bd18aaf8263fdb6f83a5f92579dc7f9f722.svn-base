<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldInLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('locations', function (Blueprint $table) {
            if (Schema::hasColumn('locations', 'is_store') == false) {
                $table->char('is_store',1)->default('N')->after('block_id');
            }
        });
        Schema::table('locations', function (Blueprint $table) {
            if (Schema::hasColumn('locations', 'operated_by') == false) {
                $table->integer('operated_by')->default(0)->after('is_store');
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
        Schema::dropIfExists('locations');
    }
}
