<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNewFieldsTableAlumni extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('alumni_students', function (Blueprint $table) {
            if (Schema::hasColumn('alumni_students', 'other_competitive_exam') == false) {
                $table->string('other_competitive_exam',200)->after('competitive_exam_id')->nullable();
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
        Schema::table('alumni_students', function($table)
        {
            $table->dropColumn(['other_competitive_exam']);
        });
    }
}
