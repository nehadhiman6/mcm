<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AddFieldsForRev40 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_yr')->table('students', function (Blueprint $table) {
            if (Schema::connection('mysql_yr')->hasColumn('students', 'selected_ele_id') == false) {
                $table->integer('selected_ele_id')->default(0)->after('course_id');
            }
        });
        if (Schema::connection('mysql_yr')->hasColumn('students', 'selected_ele_id') == true) {
            DB::connection('mysql_yr')->update('update students s join admission_forms a on s.id=a.std_id set s.selected_ele_id=a.selected_ele_id');
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::connection('mysql_yr')->table('students', function (Blueprint $table) {
        //     $table->dropColumn('selected_ele_id');
        // });
    }
}
