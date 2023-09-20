<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldForRev51 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasColumn('staff', 'salutation') == false) {
            Schema::table('staff', function (Blueprint $table) {
                $table->string('salutation')->nullable()->after('gender');
            });
        }
        if (Schema::hasColumn('staff', 'middle_name') == false) {
            Schema::table('staff', function (Blueprint $table) {
                $table->string('middle_name')->nullable()->after('salutation');
            });
        }
        if (Schema::hasColumn('staff', 'last_name') == false) {
            Schema::table('staff', function (Blueprint $table) {
                $table->string('last_name')->nullable()->after('middle_name');
            });
        }
        if (Schema::hasColumn('staff', 'faculty_id') == false) {
            Schema::table('staff', function (Blueprint $table) {
                $table->integer('faculty_id')->nullable()->after('last_name');
            });
        }
        if (Schema::hasColumn('staff', 'address_res') == false) {
            Schema::table('staff', function (Blueprint $table) {
                $table->string('address_res')->nullable()->after('faculty_id');
            });
        }
        if (Schema::hasColumn('staff', 'father_name') == false) {
            Schema::table('staff', function (Blueprint $table) {
                $table->string('father_name', 50)->nullable()->after('address_res');
            });
        }
        if (Schema::hasColumn('staff', 'dob') == false) {
            Schema::table('staff', function (Blueprint $table) {
                $table->date('dob', 100)->nullable()->after('father_name');
            });
        }
        if (Schema::hasColumn('staff', 'mobile2') == false) {
            Schema::table('staff', function (Blueprint $table) {
                $table->string('mobile2', 10)->nullable()->after('dob');
            });
        }
        if (Schema::hasColumn('staff', 'cat_id') == false) {
            Schema::table('staff', function (Blueprint $table) {
                $table->integer('cat_id')->nullable()->after('mobile2');
            });
        }

        if (Schema::hasColumn('staff', 'aadhar_no') == false) {
            Schema::table('staff', function (Blueprint $table) {
                $table->string('aadhar_no', 15)->nullable()->after('dob');
            });
        }
        if (Schema::hasColumn('staff', 'pan_no') == false) {
            Schema::table('staff', function (Blueprint $table) {
                $table->string('pan_no', 15)->nullable()->after('aadhar_no');
            });
        }
        if (Schema::hasColumn('staff', 'emergency_contact') == false) {
            Schema::table('staff', function (Blueprint $table) {
                $table->string('emergency_contact', 10)->nullable()->after('pan_no');
            });
        }
        if (Schema::hasColumn('staff', 'emergency_relation') == false) {
            Schema::table('staff', function (Blueprint $table) {
                $table->string('emergency_relation', 20)->nullable()->after('emergency_contact');
            });
        }
        if (Schema::hasColumn('staff', 'emergency_contact2') == false) {
            Schema::table('staff', function (Blueprint $table) {
                $table->string('emergency_contact2', 10)->nullable()->after('emergency_relation');
            });
        }
        if (Schema::hasColumn('staff', 'emergency_relation2') == false) {
            Schema::table('staff', function (Blueprint $table) {
                $table->string('emergency_relation2', 20)->nullable()->after('emergency_contact2');
            });
        }


        if (Schema::hasColumn('staff', 'area_of_specialization') == false) {
            Schema::table('staff', function (Blueprint $table) {
                $table->string('area_of_specialization')->nullable()->after('emergency_relation2');
            });
        }
        if (Schema::hasColumn('staff', 'other_specialization') == false) {
            Schema::table('staff', function (Blueprint $table) {
                $table->string('other_specialization')->nullable()->after('area_of_specialization');
            });
        }
        if (Schema::hasColumn('staff', 'mcm_joining_date') == false) {
            Schema::table('staff', function (Blueprint $table) {
                $table->date('mcm_joining_date')->nullable()->after('other_specialization');
            });
        }
        if (Schema::hasColumn('staff', 'teaching_exp') == false) {
            Schema::table('staff', function (Blueprint $table) {
                $table->string('teaching_exp', 25)->nullable()->after('mcm_joining_date');
            });
        }
        if (Schema::hasColumn('staff', 'qualification') == false) {
            Schema::table('staff', function (Blueprint $table) {
                $table->string('qualification', 100)->nullable()->after('teaching_exp');
            });
        }

        if (Schema::hasColumn('staff', 'library_code') == false) {
            Schema::table('staff', function (Blueprint $table) {
                $table->string('library_code', 100)->nullable()->after('mobile2');
            });
        }
        if (Schema::hasColumn('staff', 'blood_group') == false) {
            Schema::table('staff', function (Blueprint $table) {
                $table->string('blood_group', 100)->nullable()->after('cat_id');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
}
