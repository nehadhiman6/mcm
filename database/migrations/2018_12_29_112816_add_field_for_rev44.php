<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldForRev44 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('alumni_students', function (Blueprint $table) {
            if (Schema::hasColumn('alumni_students', 'member_yes_no') == false) {
                $table->char('member_yes_no', 1)->after('remarks')->nullable();
            }
            if (Schema::hasColumn('alumni_students', 'reason_yes_no') == false) {
                $table->char('reason_yes_no', 1)->after('remarks')->nullable();
            }
            if (Schema::hasColumn('alumni_students', 'payment_amount') == false) {
                $table->integer('payment_amount')->after('remarks')->nullable();
            }
            if (Schema::hasColumn('alumni_students', 'donation_reason') == false) {
                $table->string('donation_reason', 200)->after('remarks')->nullable();
            }
            if (Schema::hasColumn('alumni_students', 'donation_other') == false) {
                $table->string('donation_other', 200)->after('remarks')->nullable();
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
