<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsForRev35 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_yr')->table('fee_rcpts', function (Blueprint $table) {
            if (Schema::connection('mysql_yr')->hasColumn('fee_rcpts', 'concession') == false) {
                $table->decimal('concession', 12, 2)->default(0)->after('amount');
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
