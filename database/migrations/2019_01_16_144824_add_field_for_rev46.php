<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldForRev46 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasColumn('items', 'unit') == false) {
            Schema::table('items', function (Blueprint $table) {
                $table->string('unit', 10)->after('item')->nullable();
            });
        }
        if (Schema::hasColumn('items', 'consumable') == false) {
            Schema::table('items', function (Blueprint $table) {
                $table->char('consumable', 1)->after('remarks')->default('');
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
