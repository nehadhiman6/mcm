<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldForRev42 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('alumni_students', function (Blueprint $table) {
            if (Schema::hasColumn('alumni_students', 'ugc_year') == false) {
                $table->integer('ugc_year')->after('ugc_qualified')->nullable();
            }
            if (Schema::hasColumn('alumni_students', 'competitive_exam_year') == false) {
                $table->integer('competitive_exam_year')->after('competitive_exam_qualified')->nullable();
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
