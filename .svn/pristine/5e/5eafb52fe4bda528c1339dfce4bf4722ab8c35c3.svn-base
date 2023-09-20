<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddConfirmationDateFieldInStaff extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('staff', function (Blueprint $table) {
            if (Schema::hasColumn('staff', 'confirmation_date') == false) {
                $table->date('confirmation_date')->nullable()->after('mcm_joining_date');
            }
        });

        Schema::table('researches', function (Blueprint $table) {
            if (Schema::hasColumn('researches', 'peer_review') == false) {
                $table->char('peer_review',1)->nullable()->after('ugc_approved');
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
