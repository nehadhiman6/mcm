<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToStaffQualificationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('staff_qualification', function (Blueprint $table) {
            if (Schema::hasColumn('staff_qualification', 'pg_subject') == false) {
                $table->string('pg_subject')->nullable()->after('other_exam');
            }
        });
        Schema::table('staff_qualification', function (Blueprint $table) {
            if (Schema::hasColumn('staff_qualification', 'cgpa') == false) {
                $table->decimal('cgpa',4,2)->nullable()->after('percentage');
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
