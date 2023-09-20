<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldForRev43 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('alumni_students', function (Blueprint $table) {
            if (Schema::hasColumn('alumni_students', 'award_yes_no') == false) {
                $table->char('award_yes_no', 1)->after('mobile')->nullable();
            }
            if (Schema::hasColumn('alumni_students', 'remarks') == false) {
                $table->string('remarks')->after('upsc_psu_exam_name')->nullable();
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
