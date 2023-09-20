<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RevAlumniQualificationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('alumni_students', function (Blueprint $table) {
            if (Schema::hasColumn('alumni_students', 'upsc_psu_exam_name') == false) {
                $table->string('upsc_psu_exam_name',200)->after('competitive_exam_id')->nullable();
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
