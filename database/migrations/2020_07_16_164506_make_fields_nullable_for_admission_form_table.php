<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MakeFieldsNullableForAdmissionFormTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_yr')->table('admission_forms', function (Blueprint $table) {
            if (Schema::connection('mysql_yr')->hasColumn('admission_forms', 'loc_cat') == true) {
                $table->string('loc_cat', 10)->default('')->nullable()->change();
            }
        });

        Schema::connection('mysql_yr')->table('admission_forms', function (Blueprint $table) {
            if (Schema::connection('mysql_yr')->hasColumn('admission_forms', 'gender') == true) {
                $table->string('gender', 12)->default('')->change();
            }
        });

        Schema::connection('mysql_yr')->table('admission_form_hostel', function (Blueprint $table) {
            if (Schema::connection('mysql_yr')->hasColumn('admission_form_hostel', 'room_mate') == false) {
                $table->string('room_mate', 200)->default('')->nullable()->after('guardian_relationship');
            }
        });


        
        // Schema::connection('mysql_yr')->table('admission_forms', function (Blueprint $table) {
        //     if (Schema::connection('mysql_yr')->hasColumn('admission_forms', 'epic_no') == true) {
        //         $table->string('epic_no', 10)->default('')->nullable()->change();
        //     }
        // });

        // Schema::connection('mysql_yr')->table('admission_forms', function (Blueprint $table) {
        //     if (Schema::connection('mysql_yr')->hasColumn('admission_forms', 'aadhar_no') == true) {
        //         $table->string('aadhar_no', 10)->default('')->nullable()->change();
        //     }
        // });

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
